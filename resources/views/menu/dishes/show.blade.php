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
                    @for ($i = 1; $i <= 5; $i++)
                        @if ($dish->{"ingredient$i"} !== null)
                            <div class="mb-3">
                                <label for="formGroupExampleInput2" class="form-label">Nguyên liệu {{ $i }}</label>
                                <input type="text" readonly class="form-control" id="formGroupExampleInput2"
                                    value="{{ $dish->{"ingredient$i"}->IngredientName }}">
                            </div>
                        @endif
                    @endfor
                </div>
                <div class="text-center pb-2">
                    <a href="{{ route('dishes.index') }}" class="btn btn-warning"> Quay lại</a>
                </div>    
            </div>
        </div>
    </section>
@endsection
    

