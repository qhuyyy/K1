@extends('base')

@section('title', 'Chỉnh sửa thông tin món ăn')

@section('main')
    <section class="slide-section">
        <div class="container border rounded border-secondary">
            <div class="container text-center pt-2">
                <h2>Chỉnh sửa thông tin món ăn</h2>
            </div>
            <div class="container">
                <form method="POST" action="{{ route('dishes.update', $dish) }}">
                    @csrf
                    @method('PUT')
                    <div class="row justify-content-center mx-auto" style="width:80%">
                        <div class="mb-3">
                            <label for="formGroupExampleInput" class="form-label">STT</label>
                            <input type="text" readonly class="form-control" id="formGroupExampleInput" name="id"
                                value="{{ $dish->id }}">
                        </div>
                        <div class="mb-3">
                            <label for="formGroupExampleInput2" class="form-label">Tên món ăn</label>
                            <input type="text" class="form-control" id="formGroupExampleInput2" name="DishName"
                                value="{{ $dish->DishName }}">
                        </div>
                        <div class="mb-3">
                            <label for="dishtype" class="form-label">Loại món ăn</label>
                            <select class="form-select" id="dishtype" name="DishType_ID"
                                onchange="updateDishId('dishtype', 'dishtype_id')">
                                <option value="">Chọn loại món ăn</option>
                                @foreach ($dishtypes as $dishtype)
                                    <option value="{{ $dishtype->id }}" data-dish-id="{{ $dishtype->id }}"
                                        @if ($dish->DishType_ID == $dishtype->id) selected @endif>{{ $dishtype->DishTypeName }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="formGroupExampleInput2" class="form-label">Giá</label>
                            <input type="text" class="form-control" id="formGroupExampleInput2" name="Price"
                                value="{{ $dish->Price }}">
                        </div>
                        <div id="ingredients-container" class="border border-2 border-dark mb-3">
                            <div class="h5">Danh sách các nguyên liệu</div>
                            <div class="mb-3">
                                @foreach ($dish->ingredients as $index => $dishIngredient)
                                    <div class="row ingredient-row mb-3">
                                        <div class="col-md-6">
                                            <label for="ingredient{{ $index }}" class="form-label">Nguyên
                                                liệu</label>
                                            <select class="form-select ingredient" name="ingredient[]"
                                                id="ingredient{{ $index }}"
                                                onchange="updateUnit(this),updateIngredientID()">
                                                <option value="">- Chọn nguyên liệu -</option>
                                                @foreach ($ingredients as $ingredient)
                                                    <option value="{{ $ingredient->id }}"
                                                        data-unit-name="{{ $ingredient->unit->UnitName }}"
                                                        @if ($dishIngredient->id == $ingredient->id) selected @endif>
                                                        {{ $ingredient->IngredientName }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <label for="amount{{ $index }}" class="form-label">Định lượng cho 10
                                                suất</label>
                                            <input class="form-control" type="text" name="amount[]"
                                                id="amount{{ $index }}"
                                                value="{{ $dishIngredient->pivot->Amount !== null ? $dishIngredient->pivot->Amount : '' }}"
                                                placeholder="chưa có giá trị">
                                        </div>
                                        <div class="col-md-2">
                                            <label for="unit{{ $index }}" class="form-label">Đơn vị tính</label>
                                            <input class="form-control" type="text" name="unit[]"
                                                id="unit{{ $index }}" readonly
                                                value="{{ $dishIngredient->unit->UnitName ?? 'chưa có giá trị' }}">
                                        </div>
                                        <div class="col-md-1 d-flex align-items-end justify-content-end">
                                            <button type="button" class="btn btn-danger"
                                                onclick="removeIngredientRow(this)">Xóa</button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="row d-flex justify-content-center align-items-center pt-2 text-center">
                            <div class="col-md-3">
                                <button type="button" id="add-ingredient" class="btn btn-info">Thêm nguyên liệu</button>
                            </div>

                        </div>
                    </div>
                    <div class="text-center">
                        <span>Không có nguyên liệu bạn cần ?</span>
                        <a href="{{ route('ingredients.index') }}">Xem danh sách nguyên liệu bạn có</a>
                    </div>
                    <div class="container d-flex justify-content-center align-items-center pt-2">
                        <div class="text-center pb-2 mx-2">
                            <a href="{{ route('dishes.index') }}" class="btn btn-warning">
                                Quay lại</a>
                        </div>
                        <div class="text-center pb-2 mx-2">
                            <button type=submit class="btn btn-warning">Cập nhật</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection

@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            updateIngredientID();

            document.querySelector('form').addEventListener('submit', function(event) {
                if (arrayIngredientID.length === 0) {
                    event.preventDefault();
                    alert('Vui lòng thêm ít nhất một nguyên liệu.');
                }

                if (hasDuplicates(arrayIngredientID)) {
                    event.preventDefault();
                    alert(
                        'Bạn đã chọn cùng một loại nguyên liệu nhiều lần. Vui lòng chọn những loại nguyên liệu khác nhau.'
                        );
                }
            });

            function hasDuplicates(array) {
                return (new Set(array)).size !== array.length;
            }
        })

        let arrayIngredientID = [];

        function updateIngredientID() {
            arrayIngredientID = [];
            document.querySelectorAll('.ingredient').forEach((select) => {
                var ingredientID = select.value;
                if (ingredientID !== '') {
                    arrayIngredientID.push(ingredientID);
                }
            });
            console.log('Id: ', arrayIngredientID);
        }

        document.getElementById('add-ingredient').addEventListener('click', function() {
            var container = document.getElementById('ingredients-container');
            var div = document.createElement('div');
            div.classList.add('mb-3', 'ingredient-row');
            var index = container.querySelectorAll('.ingredient-row').length;
            div.innerHTML = `
                <div class="row">
                    <div class="col-md-6">
                        <label for="ingredient${index}" class="form-label">Nguyên liệu</label>
                        <select class="form-select ingredient" name="ingredient[]" id="ingredient${index}" onchange="updateUnit(this), updateIngredientID()">
                            <option value="">- Chọn nguyên liệu -</option>
                            @foreach ($ingredients as $ingredient)
                                <option value="{{ $ingredient->id }}" data-unit-name="{{ $ingredient->unit->UnitName }}">{{ $ingredient->IngredientName }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="amount${index}" class="form-label">Định lượng cho 10 suất</label>
                        <input class="form-control" type="text" name="amount[]" id="amount${index}" placeholder="chưa có giá trị">
                    </div>
                    <div class="col-md-2">
                        <label for="unit${index}" class="form-label">Đơn vị tính</label>
                        <input class="form-control" type="text" name="unit[]" id="unit${index}" readonly>
                    </div>
                    <div class="col-md-1 d-flex align-items-end justify-content-end">
                        <button type="button" class="btn btn-danger" onclick="removeIngredientRow(this)">Xóa</button>
                    </div>
                </div>
            `;
            container.appendChild(div);
            updateIngredientID(); 
        });

        function removeIngredientRow(button) {
            var row = button.parentElement.parentElement;
            row.parentElement.removeChild(row);
            updateIngredientID(); 
        }

        function updateUnit(select) {
            var selectedOption = select.options[select.selectedIndex];
            var unitName = selectedOption.getAttribute('data-unit-name');
            var unitInput = select.parentElement.nextElementSibling.nextElementSibling.querySelector('[id^="unit"]');
            unitInput.value = unitName || '';
        }

        document.getElementById('ingredient').addEventListener('change', function() {
            var select = document.getElementById('ingredient');
            var selectedOption = select.options[select.selectedIndex];
            var unitName = selectedOption.getAttribute('data-unit-name');

            document.getElementById('unit').value = unitName || '';
        });

        function updateDishId(selectId, inputId) {
            var select = document.getElementById(selectId);
            var dishIdInput = document.getElementById(inputId);
            var selectedOption = select.options[select.selectedIndex];
            var dishId = selectedOption.getAttribute("data-dish-id");
            dishIdInput.value = dishId;
        }
    </script>
@endsection
