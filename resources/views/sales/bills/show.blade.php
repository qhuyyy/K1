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
                    <div class="mb-3">
                        <label for="formGroupExampleInput" class="form-label">Loại đơn</label>
                        <input type="text" class="form-control" id="formGroupExampleInput" name="Contact"
                            value="{{ $bill->bill_type->BillTypeName }}" readonly>
                    </div>
                    <div class="border border-2 border-dark mb-3">
                        <div class="h5">Thông tin khách hàng</div>
                        <div class="row">
                            <div class="mb-3 col-md-4">
                                <label for="formGroupExampleInput" class="form-label">Họ tên</label>
                                <input type="text" class="form-control" id="formGroupExampleInput" name="CustomerName"
                                    value="{{ $bill->customer->CustomerName }}" readonly>
                            </div>
                            <div class="mb-3 col-md-4">
                                <label for="formGroupExampleInput" class="form-label">Thông tin liên hệ</label>
                                <input type="text" class="form-control" id="formGroupExampleInput" name="Contact"
                                    value="{{ $bill->customer->Contact ?? 'Chưa có' }}" readonly>
                            </div>
                            <div class="mb-3 col-md-4">
                                <label for="formGroupExampleInput" class="form-label">Ghi chú</label>
                                <input type="text" readonly class="form-control" id="formGroupExampleInput"
                                    name="Note" value="{{ $bill->customer->Note ?? 'Chưa có' }}" readonly>
                            </div>
                        </div>
                    </div>
                    @if ($bill->BillType_ID == 2)
                        <div class="mb-3 border border-2 border-dark pb-2">
                            <div class="h5">Danh sách các món</div>
                            @foreach ($tables as $table)
                                @if ($table->Bill_ID == $bill->id)
                                    @foreach ($table->dishes as $index => $dish)
                                        <div class="row">
                                            <div class="col-md-5">
                                                <label for="dish_{{ $index }}" class="form-label">Món ăn</label>
                                                <input type="text" class="form-control" name="" id=""
                                                    value="{{ $dish->DishName }}">
                                            </div>
                                            <div class="col-md-2">
                                                <label for="price_{{ $index }}" class="form-label">Đơn giá</label>
                                                <input class="form-control price" type="text"
                                                    id="price_{{ $index }}"
                                                    name="dishes[{{ $index }}][price]" value="{{ $dish->Price }}"
                                                    readonly>
                                            </div>
                                            <div class="col-md-2">
                                                <label for="quantity_{{ $index }}" class="form-label">Số
                                                    lượng</label>
                                                <input class="form-control quantity" type="text"
                                                    id="quantity_{{ $index }}"
                                                    name="dishes[{{ $index }}][quantity]"
                                                    value="{{ $dish->pivot->NumberOfDishes }}"
                                                    onchange="updateSubtotal({{ $index }})">
                                            </div>
                                            <?php
                                                $subtotal = $dish->Price * $dish->pivot->NumberOfDishes;
                                            ?>
                                            <div class="col-md-2">
                                                <label for="subtotal_{{ $index }}" class="form-label">Tổng</label>
                                                <input class="form-control subtotal" type="text"
                                                    id="subtotal_{{ $index }}"
                                                    name="dishes[{{ $index }}][subtotal]"
                                                    value="{{ $subtotal }}" readonly>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            @endforeach
                        </div>
                        <div class="container">
                            <div class="row">
                                <div class="mb-3 col-md-4">
                                    <label for="" class="form-label">Số lượng mâm</label>
                                    <input type="text" class="form-control" id="" name="NumberOfTables"
                                        value="{{ $table->NumberOfTables }}">
                                </div>
                                <div class="mb-3 col-md-4">
                                    <label for="combo-extra" class="form-label">Gọi thêm đồ</label>
                                    <input type="text" class="form-control extra" id="combo-extra" name="Extra"
                                        value="{{ $bill->Extra }}">
                                </div>
                                <div class="mb-3 col-md-4">
                                    <label for="combo-prepaid" class="form-label">Đặt cọc trước</label>
                                    <input type="text" class="form-control prepaid" id="combo-prepaid" name="Prepaid"
                                        value="{{ $bill->Prepaid }}">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="combo-total" class="form-label">Tổng cộng</label>
                                <input type="text" class="form-control total" id="combo-total" name="Total"
                                    value="{{ $bill->Total }}" readonly>
                            </div>
                        </div>
                    @else
                        <div class="mb-3 border border-2 border-dark pb-2">
                            <div class="h5">Danh sách các sản phẩm</div>
                            @foreach ($bill->products as $index => $product)
                                <div class="row">
                                    <div class="col-md-3">
                                        <label for="product{{ $index }}" class="form-label"
                                            data-product-type="{{ $product->product_type->ProductTypeName }}">
                                            {{ $product->product_type->ProductTypeName }}
                                        </label>
                                        <input type="text" readonly class="form-control"
                                            id="product{{ $index }}" value="{{ $product->ProductName }}"
                                            readonly>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="price_{{ $index }}" class="form-label">Đơn giá</label>
                                        <input class="form-control price" type="text" id="price_{{ $index }}"
                                            placeholder="Đơn giá được tự động cập nhật" value="{{ $product->Price }}"
                                            readonly>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="quantity_{{ $index }}" class="form-label">Số lượng</label>
                                        <input class="form-control quantity" type="text"
                                            id="quantity_{{ $index }}"
                                            name="products[{{ $index }}][quantity]"
                                            value="{{ $product->pivot->Quantity }}">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="subtotal_{{ $index }}" class="form-label">Tổng</label>
                                        <input class="form-control subtotal" type="text"
                                            id="subtotal_{{ $index }}"
                                            name="products[{{ $index }}][subtotal]"
                                            value="{{ $product->pivot->SubTotal }}" readonly>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif

                </div>
                <div class="text-center pb-2">
                    <a href="{{ route('bills.index') }}" class="btn btn-warning"> Quay lại</a>
                </div>
            </div>
        </div>
    </section>
@endsection
