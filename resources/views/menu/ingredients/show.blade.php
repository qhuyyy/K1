@extends('base')

@section('title','Chi tiết thông tin nguyên liệu')
    
@section('main')
    <section class="slide-section">
        <div class="container border rounded border-secondary">
            <div class="container text-center pt-2">
                <h2>Chi tiết thông tin nguyên liệu</h2>
            </div>
            <div class="container">
                <div class="row justify-content-center mx-auto" style="width:80%">
                    <div class="mb-3">
                        <label for="formGroupExampleInput" class="form-label">STT</label>
                        <input type="text" readonly class="form-control" id="formGroupExampleInput"
                            name="id" value="{{ $ingredient->id }}">
                    </div>
                    <div class="mb-3">
                        <label for="formGroupExampleInput2" class="form-label">Tên nguyên liệu</label>
                        <input type="text" readonly class="form-control" id="formGroupExampleInput2"
                            name="Name" value="{{ $ingredient->IngredientName }}">
                    </div>
                <div class="text-center pb-2">
                    <a href="{{ route('ingredients.index') }}" class="btn btn-primary"> Quay lại</a>
                </div>        
            </div>
        </div>
    </section>
    
@endsection