@extends('base')

@section('title','Thêm loại món ăn mới')
    
@section('main')
<section class="slide-section">
    <div class="container border rounded border-secondary">
        <div class="container text-center pt-2">
            <h2>Thêm mới loại món ăn</h2>
        </div>
        <div class="container">
            <form class="" method="POST" action="{{ route('dishtypes.store')}}">
                @csrf
                <div class="row justify-content-center mx-auto" style="width:80%">
                    <div class="mb-3">
                        <label for="formGroupExampleInput" class="form-label">STT</label>
                        <input type="text" readonly class="form-control" id="formGroupExampleInput" name="id" value="" placeholder="STT tự động tăng (không cần nhập)">
                    </div>
                    <div class="mb-3">
                        <label for="formGroupExampleInput2" class="form-label">Loại món ăn</label>
                        <input type="text" class="form-control" id="formGroupExampleInput2" name="DishTypeName" value="" placeholder="Nhập tên loại món ăn">
                    </div>
                </div> 
                <div class="container d-flex justify-content-center align-items-center">
                    <div class="text-center pb-2 mx-2">
                        <a href="{{ route('dishtypes.index') }}" class="btn btn-warning" style="width:98.89px"> Quay lại</a>
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
    