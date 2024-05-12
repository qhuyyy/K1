@extends('base')

@section('title','Chỉnh sửa thông tin loại sản phẩm')
    
@section('main')
    <section class="slide-section">
        <div class="container border rounded border-secondary">
            <div class="container text-center pt-2">
                <h2>Chỉnh sửa thông tin loại sản phẩm</h2>
            </div>
            <form method="POST" action="{{ route('producttypes.update', $producttype) }}">
                @csrf
                @method('PUT')
                <div class="row justify-content-center mx-auto" style="width:80%">
                    <div class="mb-3">
                        <label for="formGroupExampleInput" class="form-label">STT</label>
                        <input type="text" readonly class="form-control" id="formGroupExampleInput" name="id"
                            value="{{ $producttype->id }}" title="Không thể chỉnh sửa STT">
                    </div>
                    <div class="mb-3">
                        <label for="formGroupExampleInput" class="form-label">Tên loại sản phẩm</label>
                        <input type="text" class="form-control" id="formGroupExampleInput" name="ProductTypeName"
                            value="{{ $producttype->ProductTypeName }}" placeholder="Nhập tên sản phẩm">
                    </div>
                    <div class="mb-3">
                        <label for="formGroupExampleInput2" class="form-label">Ghi chú</label>
                        <input type="text" class="form-control" id="formGroupExampleInput2" name="Note"
                            value="{{ $producttype->Note }}" placeholder="Nhập giá sản phẩm">
                    </div>
                </div>
                <div class="container d-flex justify-content-center align-items-center">
                    <div class="text-center pb-2 mx-2">
                        <a href="{{ route('producttypes.index') }}" class="btn btn-warning"> Quay lại</a>
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
    
