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
                            @for ($i = 1; $i <= 5; $i++)
                                @if ($dish->{"ingredient$i"} !== null)
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="formGroupExampleInput2" class="form-label">Nguyên liệu {{ $i }}</label>
                                            <input type="text" readonly class="form-control" id="formGroupExampleInput2"
                                                value="{{ $dish->{"ingredient$i"}->IngredientName }}">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="amount{{ $i }}" class="form-label">Định lượng cho 10 suất</label>
                                            <input type="text" readonly class="form-control" id="amount{{ $i }}" name="Amount{{ $i }}"
                                                value="{{ $dish->{"Amount{$i}"} }}" placeholder="Nhập định lượng">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="" class="form-label">Đơn vị tính</label>
                                        <input type="text" class="form-control" id="unit_name{{ $i }}" name="Unit{{ $i }}_Name" value="{{ !is_null($dish->{"ingredient$i"}->unit) ? $dish->{"ingredient$i"}->unit->UnitName : '' }}" readonly>
                                    </div>
                                    
                                @endif
                            @endfor
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
        function updateIngredientAndUnitId(index) {
            var select = document.getElementById("ingredient" + index);
            var unitNameInput = document.getElementById("unit_name" + index);
            var selectedOption = select.options[select.selectedIndex];
            var unitID = selectedOption.getAttribute("data-unit-id");
            var ingredientID = selectedOption.getAttribute("data-ingredient-id");
            document.getElementById("ingredient_id" + index).value = ingredientID;
            var units = {!! json_encode($units) !!};
            var unitName = units.find(unit => unit.id == unitID).UnitName;
            unitNameInput.value = unitName;
        }
    </script>
@endsection

