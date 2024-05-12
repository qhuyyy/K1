@extends('base')

@section('title','Chi tiết thông tin sản phẩm')
    
@section('main')
    <section class="slide-section">
        <div class="container border rounded border-secondary">
            <div class="container text-center pt-2">
                <h2>Chi tiết thông tin sản phẩm</h2>
            </div>
            <div class="container">
                <div class="row justify-content-center mx-auto" style="width:80%">
                    <div class="mb-3">
                        <label for="formGroupExampleInput" class="form-label">STT</label>
                        <input type="text" readonly class="form-control" id="formGroupExampleInput"
                            name="id" value="{{ $product->id }}">
                    </div>
                    <div class="mb-3">
                        <label for="formGroupExampleInput2" class="form-label">Loại sản phẩm</label>
                        <input type="text" readonly class="form-control" id="formGroupExampleInput2"
                            name="ProductTypeName" value="{{ $product->product_type->ProductTypeName }}">
                    </div>
                    <div class="mb-3">
                        <label for="formGroupExampleInput" class="form-label">Tên sản phẩm</label>
                        <input type="text" readonly class="form-control" id="formGroupExampleInput"
                            name="ProductName" value="{{ $product->ProductName }}">
                    </div>
                    <div class="mb-3">
                        <label for="formGroupExampleInput2" class="form-label">Giá</label>
                        <input type="text" readonly class="form-control" id="formGroupExampleInput2"
                            name="Price" value="{{ $product->Price }}">
                    </div>
                </div>
                <div class="text-center pb-2">
                    <a href="{{ route('products.index') }}" class="btn btn-warning"> Quay lại</a>
                </div>    
            </div>
        </div>
    </section>
@endsection
    

