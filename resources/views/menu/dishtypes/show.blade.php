@extends('base')

@section('title','Chi tiết loại món ăn')
    
@section('main')
<section class="slide-section">
    <div class="container border rounded border-secondary">
        <div class="container text-center pt-2">
            <h2>Chi tiết thông tin loại món ăn</h2>
        </div>
        <div class="container">
                <div class="row justify-content-center mx-auto" style="width:80%">
                    <div class="mb-3">
                        <label for="formGroupExampleInput" class="form-label">STT</label>
                        <input type="text" readonly class="form-control" id="formGroupExampleInput"
                            name="id" value="{{ $dishtype->id }}">
                    </div>
                    <div class="mb-3">
                        <label for="formGroupExampleInput2" class="form-label">Tên loại món ăn</label>
                        <input type="text" readonly class="form-control" id="formGroupExampleInput2"
                            name="DishTypeName" value="{{ $dishtype->DishTypeName }}">
                    </div>
                </div>
                <div class="text-center pb-2">
                    <a href="{{ route('dishtypes.index') }}" class="btn btn-primary"> Quay lại</a>
                </div>
        </div>
    </div>
</section>
@endsection
    

