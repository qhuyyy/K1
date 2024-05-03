@extends('base')

@section('title','Chỉnh sửa loại món ăn')
    
@section('main')
<section class="slide-section">
    <div class="container border rounded border-secondary">
        <div class="container text-center pt-2">
            <h2>Chỉnh sửa thông tin loại món ăn</h2>
        </div>
        <form method="POST" action="{{ route('dishtypes.update', $dishtype) }}">
            @csrf
            @method('PUT')
            <div class="row justify-content-center mx-auto" style="width:80%">
                <div class="mb-3">
                    <label for="formGroupExampleInput" class="form-label">STT</label>
                    <input type="text" readonly class="form-control" id="formGroupExampleInput" name="id"
                        value="{{ $dishtype->id }}" title="Không thể chỉnh sửa STT">
                </div>
                <div class="mb-3">
                    <label for="formGroupExampleInput2" class="form-label">Tên loại món ăn</label>
                    <input type="text" class="form-control" id="formGroupExampleInput2" name="DishTypeName"
                        value="{{ $dishtype->DishTypeName }}" placeholder="Nhập tên loại món ăn">
                </div>
            </div>
            <div class="container d-flex justify-content-center align-items-center">
                <div class="text-center pb-2 mx-2">
                    <a href="{{ route('dishtypes.index') }}" class="btn btn-warning">Quay lại</a>
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
    

