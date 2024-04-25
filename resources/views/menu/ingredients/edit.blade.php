@extends('base')

@section('title','Chỉnh sửa thông tin nguyên liệu ')
    
@section('main')
    <section class="slide-section">
        <div class="container border rounded border-secondary">
            <div class="container text-center pt-2">
                <h2>Chỉnh sửa thông tin nguyên liệu</h2>
            </div>
            <form method="POST" action="{{ route('ingredients.update', $ingredient) }}">
                @csrf
                @method('PUT')
                <div class="row justify-content-center mx-auto" style="width:80%">
                    <div class="mb-3">
                        <label for="formGroupExampleInput" class="form-label">STT</label>
                        <input type="text" readonly class="form-control" id="formGroupExampleInput" name="id"
                            value="{{ $ingredient->id }}" title="Không thể chỉnh sửa STT">
                    </div>
                    <div class="mb-3">
                        <label for="formGroupExampleInput2" class="form-label">Tên nguyên liệu</label>
                        <input type="text" class="form-control" id="formGroupExampleInput2" name="IngredientName"
                            value="{{ $ingredient->IngredientName }}" placeholder="Nhập tên nguyên liệu">
                    </div>
                </div>
                <div class="container d-flex justify-content-center align-items-center">
                    <div class="text-center pb-2 mx-2">
                        <a href="{{ route('ingredients.index') }}" class="btn btn-primary" style="width:98.89px"> Quay lại</a>
                    </div>
                    <div class="text-center pb-2 mx-2">
                        <button type=submit class="btn btn-primary">Cập nhật</button>
                    </div>
                </div>
            </form>
        </div>
        </div>
    </section>
@endsection


    
