@extends('base')

@section('title','Thêm loại thực phẩm mới')
    
@section('main')
<section class="slide-section">
    <div class="container border rounded border-secondary">
        <div class="container text-center pt-2">
            <h2>Thêm mới loại thực phẩm</h2>
        </div>
        <div class="container">
            <form class="" method="POST" action="{{ route('foodtypes.store')}}">
                @csrf
                <div class="row justify-content-center mx-auto" style="width:80%">
                    <div class="mb-3">
                        <label for="formGroupExampleInput" class="form-label">STT</label>
                        <input type="text" readonly class="form-control" id="formGroupExampleInput" name="id" value="" placeholder="STT tự động tăng (không cần nhập)">
                    </div>
                    <div class="mb-3">
                        <label for="formGroupExampleInput2" class="form-label">Loại thực phẩm</label>
                        <input type="text" class="form-control" id="formGroupExampleInput2" name="FoodTypeName" value="" placeholder="Nhập tên loại thực phẩm">
                    </div>
                    <div class="mb-3">
                        <label for="formGroupExampleInput" class="form-label">Mô tả</label>
                        <input type="text" class="form-control" id="formGroupExampleInput" name="Description" value="" placeholder="Thêm mô tả về loại thực phẩm">
                    </div>
                </div> 
                <div class="container d-flex justify-content-center align-items-center">
                    <div class="text-center pb-2 mx-2">
                        <a href="{{ route('foodtypes.index') }}" class="btn btn-primary" style="width:98.89px"> Quay lại</a>
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
    