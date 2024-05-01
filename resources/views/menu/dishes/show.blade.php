@extends('base')

@section('title','Chi tiết thông tin món ăn')
    
@section('main')
    <section class="slide-section">
        <div class="container border rounded border-secondary">
            <div class="container text-center pt-2">
                <h2>Chi tiết thông tin món ăn</h2>
            </div>
            <div class="container">
                <div class="row justify-content-center mx-auto" style="width:80%">
                    <div class="mb-3">
                        <label for="formGroupExampleInput" class="form-label">STT</label>
                        <input type="text" readonly class="form-control" id="formGroupExampleInput"
                            name="id" value="{{ $dish->id }}">
                    </div>
                    <div class="mb-3">
                        <label for="formGroupExampleInput2" class="form-label">Tên món ăn</label>
                        <input type="text" readonly class="form-control" id="formGroupExampleInput2"
                            name="DishName" value="{{ $dish->DishName }}">
                    </div>
                    <div class="mb-3">
                        <label for="formGroupExampleInput2" class="form-label">Loại món ăn</label>
                        <input type="text" readonly class="form-control" id="formGroupExampleInput2"
                            value="{{ $dish->dish_type->DishTypeName }}">
                    </div>
                    <div class="mb-3">
                        <div class="row">
                            @foreach ($dish->ingredients as $ingredient)
                                <div class="col-md-7">
                                    <label class="form-label">Nguyên liệu</label>
                                    <input type="text" readonly class="form-control mb-2" value="{{ $ingredient->IngredientName }}">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Định lượng cho 10 suất</label>
                                    <input type="text" readonly class="form-control mb-2" value="{{ $ingredient->pivot->Amount !== null ? $ingredient->pivot->Amount : 'chưa có giá trị' }}">
                                </div>
                                <div class="col-md-2">
                                    <label for="unit" class="form-label">Đơn vị tính</label>
                                    <input class="form-control" type="text" id="unit" name="unit" readonly>
                                </div>
                            @endforeach  
                        </div> 
                    </div>
                </div>
                <div class="text-center pb-2">
                    <a href="{{ route('dishes.index') }}" class="btn btn-warning"> Quay lại</a>
                </div>    
            </div>
        </div>
    </section>
@endsection
    
@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var ingredientSelects = document.querySelectorAll('.form-select[name="ingredient[]"]');
            ingredientSelects.forEach(function(select) {
                updateUnit(select);
            });
        });

        function updateUnit(select) {
            var selectedOption = select.options[select.selectedIndex];
            var unitName = selectedOption.getAttribute('data-unit-name');
            var unitInput = select.parentElement.nextElementSibling.nextElementSibling.querySelector('#unit');
            unitInput.value = unitName || '';
        } 
    </script>
@endsection

