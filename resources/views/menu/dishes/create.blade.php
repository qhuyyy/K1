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
                            <label for="ingredient1" class="form-label">Nguyên liệu 1</label>
                            <select class="form-select" id="ingredient1" onchange="updateIngredientId('ingredient1', 'ingredient_id1')">
                                <option value="">Chọn nguyên liệu</option>
                                @foreach ($ingredients as $ingredient)
                                    <option value="{{ $ingredient->id }}" data-ingredient-id="{{ $ingredient->id }}">{{ $ingredient->IngredientName }}</option>
                                @endforeach
                            </select>
                            <input type="hidden" id="ingredient_id1" name="Ingredient1_ID">
                        </div>
                        <div class="mb-3">
                            <label for="ingredient2" class="form-label">Nguyên liệu 2</label>
                            <select class="form-select" id="ingredient2" onchange="updateIngredientId('ingredient2', 'ingredient_id2')">
                                <option value="">Chọn nguyên liệu</option>
                                @foreach ($ingredients as $ingredient)
                                    <option value="{{ $ingredient->id }}" data-ingredient-id="{{ $ingredient->id }}">{{ $ingredient->IngredientName }}</option>
                                @endforeach
                            </select>
                            <input type="hidden" id="ingredient_id2" name="Ingredient2_ID">
                        </div>
                        <div class="mb-3">
                            <label for="ingredient3" class="form-label">Nguyên liệu 3</label>
                            <select class="form-select" id="ingredient3" onchange="updateIngredientId('ingredient3', 'ingredient_id3')">
                                <option value="">Chọn nguyên liệu</option>
                                @foreach ($ingredients as $ingredient)
                                    <option value="{{ $ingredient->id }}" data-ingredient-id="{{ $ingredient->id }}">{{ $ingredient->IngredientName }}</option>
                                @endforeach
                            </select>
                            <input type="hidden" id="ingredient_id3" name="Ingredient3_ID">
                        </div>
                        <div class="mb-3">
                            <label for="ingredient4" class="form-label">Nguyên liệu 4</label>
                            <select class="form-select" id="ingredient4" onchange="updateIngredientId('ingredient4', 'ingredient_id4')">
                                <option value="">Chọn nguyên liệu</option>
                                @foreach ($ingredients as $ingredient)
                                    <option value="{{ $ingredient->id }}" data-ingredient-id="{{ $ingredient->id }}">{{ $ingredient->IngredientName }}</option>
                                @endforeach
                            </select>
                            <input type="hidden" id="ingredient_id4" name="Ingredient4_ID">
                        </div>
                        <div class="mb-3">
                            <label for="ingredient5" class="form-label">Nguyên liệu 5</label>
                            <select class="form-select" id="ingredient5" onchange="updateIngredientId('ingredient5', 'ingredient_id5')">
                                <option value="">Chọn nguyên liệu</option>
                                @foreach ($ingredients as $ingredient)
                                    <option value="{{ $ingredient->id }}" data-ingredient-id="{{ $ingredient->id }}">{{ $ingredient->IngredientName }}</option>
                                @endforeach
                            </select>
                            <input type="hidden" id="ingredient_id5" name="Ingredient5_ID">
                        </div>
                    </div>
                    <div class="text-center">
                        <span>Không có nguyên liệu bạn cần ?</span>
                        <a href="{{ route('ingredients.index') }}">Xem danh sách nguyên liệu bạn có</a>
                    </div>
                    <div class="container d-flex justify-content-center align-items-center pt-2">
                        <div class="text-center pb-2 mx-2">
                            <a href="{{ route('dishes.index') }}" class="btn btn-primary" style="width:98.89px">
                                Quay lại</a>
                        </div>
                        <div class="text-center pb-2 mx-2">
                            <button type=submit class="btn btn-primary">Thêm mới</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection

@section('script')
    <script>
        function updateIngredientId(selectId, inputId) {
            var select = document.getElementById(selectId);
            var ingredientIdInput = document.getElementById(inputId);
            var selectedOption = select.options[select.selectedIndex];
            var ingredientId = selectedOption.getAttribute("data-ingredient-id");
            ingredientIdInput.value = ingredientId;
        }
    </script>
@endsection
    

