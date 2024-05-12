@extends('base')

@section('title','Thêm sản phẩm mới')
    
@section('main')
    <section class="slide-section">
        <div class="container border rounded border-secondary">
            <div class="container text-center pt-2">
                <h2>Thêm mới sản phẩm</h2>
            </div>
            <div class="container">
                <form class="" method="POST" action="{{ route('products.store') }}">
                    @csrf
                    <div class="row justify-content-center mx-auto" style="width:80%">
                        <div class="mb-3">
                            <label for="formGroupExampleInput" class="form-label">STT</label>
                            <input type="text" readonly class="form-control" id="formGroupExampleInput"
                                name="id" value="" placeholder="STT tự động tăng (không cần nhập)">
                        </div>
                        <div class="mb-3">
                            <label for="producttype" class="form-label">Loại sản phẩm</label>
                            <select class="form-select" id="ProductType_ID" name="ProductType_ID">
                                <option value="">- Chọn loại sản phẩm -</option>
                                @foreach ($producttypes as $producttype)
                                    <option value="{{ $producttype->id }}">
                                        {{ $producttype->ProductTypeName }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="formGroupExampleInput2" class="form-label">Tên sản phẩm</label>
                            <input type="text" class="form-control" id="formGroupExampleInput2" name="ProductName"
                                value="" placeholder="Nhập tên sản phẩm">
                        </div>
                        <div class="mb-3">
                            <label for="formGroupExampleInput2" class="form-label">Giá</label>
                            <input type="text" class="form-control" id="formGroupExampleInput2" name="Price"
                                value="" placeholder="Nhập giá sản phẩm" pattern="[0-9]+"
                                title="Chỉ cho phép nhập số">
                        </div>
                    </div>
                    <div class="container d-flex justify-content-center align-items-center">
                        <div class="text-center pb-2 mx-2">
                            <a href="{{ route('employees.index') }}" class="btn btn-warning">
                                Quay lại</a>
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

    

