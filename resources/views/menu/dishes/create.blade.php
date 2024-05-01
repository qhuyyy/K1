@extends('base')

@section('title','Thêm món ăn mới')
    
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
                            <input type="text" readonly class="form-control" id="formGroupExampleInput"
                                name="id" value="" placeholder="STT tự động tăng (không cần nhập)">
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
                                    <option value="{{ $dishtype->id }}" data-dishtype-id="{{ $dishtype->id }}" {{ request()->dishtype == $dishtype->id ? 'selected' : '' }}>
                                        {{ $dishtype->DishTypeName }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            @for ($i = 1; $i <= 5; $i++)
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="ingredient{{ $i }}" class="form-label">Nguyên liệu {{ $i }}</label>
                                            <select class="form-select" id="ingredient{{ $i }}" onchange="updateIngredientAndUnitId('{{ $i }}')">
                                                <option value="">Chọn nguyên liệu</option>
                                                @foreach ($ingredients as $ingredient)
                                                    <option value="{{ $ingredient->id }}" data-ingredient-id="{{ $ingredient->id }}" data-unit-id="{{ $ingredient->Unit_ID }}">{{ $ingredient->IngredientName }}</option>
                                                @endforeach
                                            </select>
                                            <input type="hidden" id="ingredient_id{{ $i }}" name="Ingredient{{ $i }}_ID">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="amount{{ $i }}" class="form-label">Định lượng cho 10 suất</label>
                                            <input type="text" class="form-control" id="amount{{ $i }}" name="Amount{{ $i }}"
                                                value="" placeholder="Nhập định lượng">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="" class="form-label">Đơn vị tính</label>
                                        <input type="text" class="form-control" id="unit_name{{ $i }}" name="Unit{{ $i }}_Name" readonly>
                                    </div>               
                                </div>
                            @endfor
                        </div>                         
                    </div>
                    <div class="text-center">
                        <span>Không có nguyên liệu bạn cần ?</span>
                        <a href="{{ route('ingredients.index') }}">Xem danh sách nguyên liệu bạn có</a>
                    </div>
                    <div class="container d-flex justify-content-center align-items-center pt-2">
                        <div class="text-center pb-2 mx-2">
                            <a href="{{ route('dishes.index') }}" class="btn btn-warning" style="width:98.89px">
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
        function updateIngredientAndUnitId(index) {
            var select = document.getElementById("ingredient" + index);
            var unitNameInput = document.getElementById("unit_name" + index);
            var selectedOption = select.options[select.selectedIndex];
            var unitID = selectedOption.getAttribute("data-unit-id");
            var ingredientID = selectedOption.getAttribute("data-ingredient-id");

            if (ingredientID) {
                // Nếu người dùng đã chọn một nguyên liệu, cập nhật đơn vị tính bình thường
                document.getElementById("ingredient_id" + index).value = ingredientID;
                var units = {!! json_encode($units) !!};
                var unitName = units.find(unit => unit.id == unitID).UnitName;
                unitNameInput.value = unitName;
            } else {
                // Nếu người dùng không chọn nguyên liệu, đặt giá trị của đơn vị tính là rỗng
                document.getElementById("ingredient_id" + index).value = '';
                unitNameInput.value = '';
            }
        }       
    </script>
@endsection
    

