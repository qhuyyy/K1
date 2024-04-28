@extends('base')

@section('title','Chỉnh sửa loại thực phẩm')
    
@section('main')
<section class="slide-section">
    <div class="container border rounded border-secondary">
        <div class="container text-center pt-2">
            <h2>Chỉnh sửa thông tin loại thực phẩm</h2>
        </div>
        <form method="POST" action="{{ route('foodtypes.update', $foodtype) }}">
            @csrf
            @method('PUT')
            <div class="row justify-content-center mx-auto" style="width:80%">
                <div class="mb-3">
                    <label for="formGroupExampleInput" class="form-label">STT</label>
                    <input type="text" readonly class="form-control" id="formGroupExampleInput" name="id"
                        value="{{ $foodtype->id }}" title="Không thể chỉnh sửa STT">
                </div>
                <div class="mb-3">
                    <label for="formGroupExampleInput2" class="form-label">Tên loại thực phẩm</label>
                    <input type="text" class="form-control" id="formGroupExampleInput2" name="FoodTypeName"
                        value="{{ $foodtype->FoodTypeName }}" placeholder="Nhập tên loại thực phẩm">
                </div>
                <div class="mb-3">
                    <label for="formGroupExampleInput" class="form-label">Mô tả</label>
                    <input type="text" class="form-control" id="formGroupExampleInput" name="Description"
                        value="{{ $foodtype->Description }}" placeholder="Thêm mô tả về loại thực phẩm">
                </div>
            </div>
            <div class="container d-flex justify-content-center align-items-center">
                <div class="text-center pb-2 mx-2">
                    <a href="{{ route('foodtypes.index') }}" class="btn btn-warning" style="width:98.89px"> Quay lại</a>
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
    

