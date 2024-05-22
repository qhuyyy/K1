@extends('base')

@section('title', 'Chi tiết thông tin đơn bán hàng')

@section('main')
    <section class="slide-section">
        <div class="container border rounded border-secondary">
            <div class="container text-center pt-2">
                <h2>Chi tiết thông tin đơn bán hàng</h2>
            </div>
            <div class="container">
                <div class="row justify-content-center mx-auto" style="width:80%">
                    <div class="mb-3">
                        <label for="formGroupExampleInput" class="form-label">STT</label>
                        <input type="text" readonly class="form-control" id="formGroupExampleInput" name="id"
                            value="{{ $bill->id }}">
                    </div>
                    <div class="mb-3">
                        <label for="formGroupExampleInput2" class="form-label">Ngày</label>
                        <input type="text" readonly class="form-control" id="formGroupExampleInput2" name="Date"
                            value="{{ $bill->Date }}">
                    </div>
                    @foreach ($bill->products as $index => $product)
                        <div class="mb-3 border border-2 border-dark pb-2">
                            <div class="h5">Danh sách các sản phẩm</div>
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="product{{ $index }}" class="form-label" data-product-type="{{ $product->product_type->ProductTypeName }}">
                                        {{ $product->product_type->ProductTypeName }}
                                    </label>
                                    <input type="text" readonly class="form-control" id="product{{ $index }}"
                                        value="{{ $product->ProductName }}" readonly>
                                </div>
                                <div class="col-md-3">
                                    <label for="price_{{ $index }}" class="form-label">Đơn giá</label>
                                    <input class="form-control price" type="text" id="price_{{ $index }}"
                                        placeholder="Đơn giá được tự động cập nhật" value="{{ $product->Price }}" readonly>
                                </div>
                                <div class="col-md-3">
                                    <label for="quantity_{{ $index }}" class="form-label">Số lượng</label>
                                    <input class="form-control quantity" type="text" id="quantity_{{ $index }}"
                                        name="products[{{ $index }}][quantity]"
                                        value="{{ $product->pivot->Quantity }}">
                                </div>
                                <div class="col-md-3">
                                    <label for="subtotal_{{ $index }}" class="form-label">Tổng</label>
                                    <input class="form-control subtotal" type="text" id="subtotal_{{ $index }}"
                                        name="products[{{ $index }}][subtotal]"
                                        value="{{ $product->Price * $product->pivot->Quantity }}" readonly>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    <div class="mb-3">
                        <label for="formGroupExampleInput" class="form-label">Gọi thêm đồ</label>
                        <input type="text" readonly class="form-control" id="formGroupExampleInput" name="Extra"
                            value="{{ $bill->Extra }}">
                    </div>
                    <div class="mb-3">
                        <label for="formGroupExampleInput" class="form-label">Tổng cộng</label>
                        <input type="text" readonly class="form-control" id="formGroupExampleInput" name="Total"
                            value="{{ $bill->Total }}">
                    </div>
                </div>
                <div class="text-center pb-2">
                    <a href="{{ route('bills.index') }}" class="btn btn-warning"> Quay lại</a>
                </div>
            </div>
        </div>
    </section>
@endsection
