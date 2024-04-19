@extends('base')

@section('title','Chi tiết loại thực phẩm')
    
@section('main')
<section class="slide-section">
    <div class="container border rounded border-secondary">
        <div class="container text-center pt-2">
            <h2>Chi tiết thông tin loại thực phẩm</h2>
        </div>
        <div class="container">
                <div class="row justify-content-center mx-auto" style="width:80%">
                    <div class="mb-3">
                        <label for="formGroupExampleInput" class="form-label">STT</label>
                        <input type="text" readonly class="form-control" id="formGroupExampleInput"
                            name="id" value="{{ $foodtype->id }}">
                    </div>
                    <div class="mb-3">
                        <label for="formGroupExampleInput2" class="form-label">Tên loại thực phẩm</label>
                        <input type="text" readonly class="form-control" id="formGroupExampleInput2"
                            name="FoodTypeName" value="{{ $foodtype->FoodTypeName }}">
                    </div>
                    <div class="mb-3">
                        <label for="formGroupExampleInput" class="form-label">Mô tả</label>
                        <input type="text" readonly class="form-control" id="formGroupExampleInput"
                            name="Description" value="{{ $foodtype->Description }}">
                    </div>
                </div>
                <div class="text-center pb-2">
                    <a href="{{ route('foodtypes.index') }}" class="btn btn-primary"> Quay lại</a>
                </div>
        </div>
    </div>
</section>
@endsection
    

