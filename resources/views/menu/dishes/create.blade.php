@extends('base')

@section('title', 'Thêm món ăn mới')

@section('main')
    <section class="slide-section">
        <div class="container border rounded border-secondary">
            <div class="container text-center pt-2">
                <h2>Thêm mới món ăn</h2>
            </div>
            <div class="container">
                <form class="" method="POST" action="{{ route('dishes.store') }}">
                    @csrf
                    <div class="row justify-content-center mx-auto" style="width:80%">
                        <div class="mb-3">
                            <label for="formGroupExampleInput" class="form-label">STT</label>
                            <input type="text" readonly class="form-control" id="formGroupExampleInput" name="id"
                                value="" placeholder="STT tự động tăng (không cần nhập)">
                        </div>
                        <div class="mb-3">
                            <label for="formGroupExampleInput2" class="form-label">Tên món ăn</label>
                            <input type="text" class="form-control" id="formGroupExampleInput2" name="DishName"
                                value="" placeholder="Nhập tên món ăn">
                        </div>
                        <div class="mb-3">
                            <label for="dishtype" class="form-label">Loại món ăn</label>
                            <select class="form-select" id="dishtype" name="dishtype">
                                <option value="">- Chọn loại món ăn -</option>
                                @foreach ($dishtypes as $dishtype)
                                    <option value="{{ $dishtype->id }}" data-dishtype-id="{{ $dishtype->id }}"
                                        {{ request()->dishtype == $dishtype->id ? 'selected' : '' }}>
                                        {{ $dishtype->DishTypeName }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="formGroupExampleInput2" class="form-label">Đơn giá</label>
                            <input type="text" class="form-control" id="formGroupExampleInput2" name="Price"
                                value="" placeholder="Nhập đơn giá">
                        </div>
                        <div id="ingredients-container" class="border border-2 border-dark mb-3">
                            <div class="h5">Danh sách các nguyên liệu</div>
                            <div class="mb-3">

                            </div>
                        </div>
                        <div class="row d-flex justify-content-center align-items-center pt-2 text-center">
                            <div class="col-md-3">
                                <button type="button" id="add-ingredient" class="btn btn-info">Thêm nguyên liệu</button>
                            </div>
                        </div>
                    </div>
                    <div class="text-center mb-3">
                        <span>Không có nguyên liệu bạn cần ?</span>
                        <a href="{{ route('ingredients.index') }}">Xem danh sách nguyên liệu bạn có</a>
                    </div>

                    <div class="container d-flex justify-content-center align-items-center pt-2">
                        <div class="text-center pb-2 mx-2">
                            <a href="{{ route('dishes.index') }}" class="btn btn-warning">
                                Quay lại</a>
                        </div>
                        <div class="text-center pb-2 mx-2">
                            <button type=submit class="btn btn-warning">Thêm mới</button>
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
            document.querySelector('form').addEventListener('submit', function(event) {
                if (arrayIngredientID.length === 0) {
                    event.preventDefault();
                    alert('Vui lòng thêm ít nhất một nguyên liệu.');
                }

                if (hasDuplicates(arrayIngredientID)){
                    event.preventDefault();
                    alert('Bạn đã chọn cùng một loại nguyên liệu nhiều lần. Vui lòng chọn những loại nguyên liệu khác nhau.');
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
            div.classList.add('mb-3');
            div.innerHTML = `
                <div class="row">
                    <div class="col-md-6">
                        <label for="ingredient" class="form-label">Nguyên liệu</label>
                        <select class="form-select ingredient" id="ingredient" name="ingredient[]" onchange="updateUnit(this),updateIngredientID()">
                            <option value="">- Chọn nguyên liệu -</option>
                            @foreach ($ingredients as $ingredient)
                                <option value="{{ $ingredient->id }}" data-unit-name="{{ $ingredient->unit->UnitName }}">{{ $ingredient->IngredientName }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="amount" class="form-label">Định lượng cho 10 suất</label>
                        <input class="form-control" type="text" name="amount[]" id="amount">
                    </div>
                    <div class="col-md-2">
                        <label for="unit" class="form-label">Đơn vị tính</label>
                        <input class="form-control" type="text" name="unit[]" id="unit" readonly>
                    </div>
                    <div class="col-md-1 d-flex align-items-end justify-content-end">
                        <button type="button" class="btn btn-danger" onclick="removeIngredientRow(this)">Xóa</button>
                    </div>
                </div>
            `;
            container.appendChild(div);
        });

        function removeIngredientRow(button) {
            var row = button.parentElement.parentElement;
            row.parentElement.removeChild(row);
            updateIngredientID();
        }

        function updateUnit(select) {
            var selectedOption = select.options[select.selectedIndex];
            var unitName = selectedOption.getAttribute('data-unit-name');
            var unitInput = select.parentElement.nextElementSibling.nextElementSibling.querySelector('#unit');
            unitInput.value = unitName || '';
        }

        document.getElementById('ingredient').addEventListener('change', function() {
            var select = document.getElementById('ingredient');
            var selectedOption = select.options[select.selectedIndex];
            var unitName = selectedOption.getAttribute('data-unit-name');

            document.getElementById('unit').value = unitName || '';
        });
    </script>
@endsection
