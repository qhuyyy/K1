@extends('base')

@section('title','Chỉnh sửa thông tin món ăn')
    
@section('main')
    <section class="slide-section">
        <div class="container border rounded border-secondary">
            <div class="container text-center pt-2">
                <h2>Chỉnh sửa thông tin món ăn</h2>
            </div>
            <form method="POST" action="{{ route('dishes.update', $dish) }}">
                @csrf
                @method('PUT')
                <div class="row justify-content-center mx-auto" style="width:80%">
                    <div class="mb-3">
                        <label for="formGroupExampleInput" class="form-label">STT</label>
                        <input type="text" readonly class="form-control" id="formGroupExampleInput" name="id"
                            value="{{ $dish->id }}" title="Không thể chỉnh sửa STT">
                    </div>
                    <div class="mb-3">
                        <label for="formGroupExampleInput2" class="form-label">Tên món ăn</label>
                        <input type="text" class="form-control" id="formGroupExampleInput2" name="DishName"
                            value="{{ $dish->DishName }}" placeholder="Nhập tên món ăn">
                    </div>
                    <div class="mb-3">
                        <label for="dishtype" class="form-label">Loại món ăn</label>
                        <select class="form-select" id="dishtype" onchange="updateDishTypeId()">
                            <option value="">Chọn loại món ăn</option>
                            @foreach ($dishtypes as $dishtype)
                                <option value="{{ $dishtype->id }}" data-dishtype-id="{{ $dishtype->id }}"
                                    @if ($dish->DishType_ID == $dishtype->id) selected @endif>{{ $dishtype->DishTypeName }}</option>
                            @endforeach
                        </select>
                        <input type="hidden" id="dishtype_id" name="DishType_ID" value="{{ $dish->DishType_ID }}">
                    </div>
                    <div id="ingredients-container">
                        @foreach ($dish->ingredients as $dishIngredient)
                            <div class="row">
                                <div class="col-md-7">
                                    <label for="ingredients" class="form-label">Nguyên liệu</label>
                                    <select class="form-select mb-2" name="ingredients[]">
                                        <option value="">Chọn nguyên liệu</option>
                                        @foreach ($ingredients as $ingredient)
                                            <option value="{{ $ingredient->id }}"  data-unit-name="{{ $ingredient->unit->UnitName }}" @if ($dishIngredient->id == $ingredient->id) selected @endif>{{ $ingredient->IngredientName }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="" class="form-label">Định lượng cho 10 suất</label>
                                    <input type="text" class="form-control mb-2" value="{{ $dishIngredient->pivot->Amount !== null ? $dishIngredient->pivot->Amount : 'chưa có giá trị' }}">
                                </div>
                                <div class="col-md-2">
                                    <label for="unit" class="form-label">Đơn vị tính</label>
                                    <input class="form-control" type="text" id="unit" name="unit" readonly value="{{ $dishIngredient->unit->UnitName ?? 'chưa có giá trị' }}">
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="row justify-content-center align-items-center text-center">
                        <div class="col-md-2">
                            <button type="button" id="add-ingredient" class="btn btn-info">Thêm nguyên liệu</button>
                        </div>
                        <div class="col-md-2">
                            <button type="button" id="remove-ingredient" class="btn btn-danger">Bớt nguyên liệu</button>
                        </div>
                    </div>
                </div>
                <div class="text-center">
                    <span>Không có nguyên liệu bạn cần ?</span>
                    <a href="{{ route('ingredients.index') }}">Xem danh sách nguyên liệu bạn có</a>
                </div>
                <div class="container d-flex justify-content-center align-items-center pt-2">
                    <div class="text-center pb-2 mx-2">
                        <a href="{{ route('dishes.index') }}" class="btn btn-warning" style="width:98.89px"> Quay lại</a>
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
        document.addEventListener("DOMContentLoaded", function() {
            function updateUnit(select) {
                var selectedOption = select.options[select.selectedIndex];
                var unitName = selectedOption.getAttribute('data-unit-name');
                var unitInput = select.parentElement.nextElementSibling.nextElementSibling.querySelector('.form-control[name="unit"]');
                if (unitInput) {
                    unitInput.value = unitName || ''; // Cập nhật giá trị đơn vị tính
                }

                // Nếu không có unitInput, tức là không có ô đơn vị tính, 
                // ta sẽ tìm đến ô đơn vị tính có id "unit"
                if (!unitInput) {
                    unitInput = select.parentElement.nextElementSibling.nextElementSibling.querySelector('#unit');
                    if (unitInput) {
                        unitInput.value = unitName || '';
                    }
                }
            }

            // Lắng nghe sự kiện change trên tất cả các select box nguyên liệu
            var ingredientsSelects = document.querySelectorAll('select[name="ingredients[]"]');
            ingredientsSelects.forEach(function(select) {
                select.addEventListener('change', function() {
                    updateUnit(this); // Gọi hàm updateUnit khi có sự thay đổi
                });
            });

            // Hàm updateUnit cũng có thể được gọi khi trang được tải lần đầu để hiển thị đơn vị tính cho nguyên liệu mặc định
            ingredientsSelects.forEach(function(select) {
                if (select.value) {
                    updateUnit(select);
                }
            });

            document.getElementById('add-ingredient').addEventListener('click', function() {
                var container = document.getElementById('ingredients-container');
                var div = document.createElement('div');
                div.className = "row"; // Thêm class "row" vào div mới tạo
                div.innerHTML = `
                    <div class="col-md-7">
                        <label for="ingredients" class="form-label">Nguyên liệu</label>
                        <select class="form-select mb-2" name="ingredients[]" onchange="updateUnit(this)">
                            <option value="">- Chọn nguyên liệu -</option>
                            @foreach ($ingredients as $ingredient)
                                <option value="{{ $ingredient->id }}" data-unit-name="{{ $ingredient->unit->UnitName }}">{{ $ingredient->IngredientName }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="" class="form-label">Định lượng cho 10 suất</label>
                        <input type="text" class="form-control" placeholder="Định lượng cho 10 suất">
                    </div>
                    <div class="col-md-2">
                        <label for="unit" class="form-label">Đơn vị tính</label>
                        <input class="form-control" type="text" id="unit" name="unit[]" readonly placeholder="Đơn vị tính">
                    </div>
                `;
                container.appendChild(div);
            });

            document.getElementById('remove-ingredient').addEventListener('click', function() {
                var container = document.getElementById('ingredients-container');
                var children = container.querySelectorAll('.row');
                var lastChild = children[children.length - 1];

                if (children.length > 1) {
                    container.removeChild(lastChild);
                }

                var labels = container.querySelectorAll('label');
                var lastLabel = labels[labels.length - 1];
                container.removeChild(lastLabel);
            });

            document.querySelector('form').addEventListener('submit', function(event) {
                var ingredients = document.querySelectorAll('select[name="ingredients[]"]');
                var allIngredientsSelected = true;

                // Kiểm tra xem tất cả các ô nguyên liệu đã được chọn chưa
                ingredients.forEach(function(ingredient) {
                    if (!ingredient.value) {
                        allIngredientsSelected = false;
                    }
                });

                // Nếu không có tất cả các ô nguyên liệu được chọn, ngăn chặn việc submit form
                if (!allIngredientsSelected) {
                    event.preventDefault();
                    alert("Vui lòng chọn hết các nguyên liệu trước khi cập nhật.");
                }
            }); 
        });


    </script>
@endsection
