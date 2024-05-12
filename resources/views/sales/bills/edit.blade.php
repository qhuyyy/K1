@extends('base')

@section('title', 'Chỉnh sửa thông tin hóa đơn')

@section('main')
    <section class="slide-section">
        <div class="container border rounded border-secondary">
            <div class="container text-center pt-2">
                <h2>Chỉnh sửa thông tin hóa đơn</h2>
            </div>
            <form method="POST" action="{{ route('bills.update', $bill) }}">
                @csrf
                @method('PUT')
                <div class="row justify-content-center mx-auto" style="width:80%">
                    <div class="mb-3">
                        <label for="formGroupExampleInput" class="form-label">STT</label>
                        <input type="text" readonly class="form-control" id="formGroupExampleInput" name="id"
                            value="{{ $bill->id }}" title="Không thể chỉnh sửa STT">
                    </div>
                    <div class="mb-3">
                        <label for="formGroupExampleInput2" class="form-label">Date</label>
                        <input type="date" class="form-control" id="formGroupExampleInput2" name="Date"
                            value="{{ $bill->Date }}" placeholder="Chọn ngày">
                    </div>
                    <div class="products-container border border-2 border-dark mb-3" id="products-container">
                        <div class="h5">Danh sách các món</div>
                        @foreach ($bill->products as $index => $product)
                            <div class="mb-3">
                                <div class="row mb-3">
                                    <div class="col-md-3">
                                        <label for="product_{{ $index }}" class="form-label">
                                            @if ($product->product_type->ProductTypeName == 'Cơm suất')
                                                Loại suất
                                            @elseif ($product->product_type->ProductTypeName == 'Đồ ăn nhanh')
                                                Tên món
                                            @endif
                                        </label>
                                        <select class="form-select product" id="product_{{ $index }}"
                                            name="products[{{ $index }}][id]"
                                            onchange="updateProductDetails(this),updateProductID(),updateSubTotal(); updateTotal();">
                                            <option value="">- Chọn loại suất -</option>
                                            @foreach ($products as $productOption)
                                                @if (
                                                    $product->product_type->ProductTypeName == 'Cơm suất' &&
                                                        $productOption->product_type->ProductTypeName == 'Cơm suất')
                                                    <option value="{{ $productOption->id }}"
                                                        data-product-price="{{ $productOption->Price }}"
                                                        data-product-id="{{ $productOption->id }}"
                                                        @if ($product->id == $productOption->id) selected @endif>
                                                        {{ $productOption->ProductName }}
                                                    </option>
                                                @elseif (
                                                    $product->product_type->ProductTypeName == 'Đồ ăn nhanh' &&
                                                        $productOption->product_type->ProductTypeName == 'Đồ ăn nhanh')
                                                    <option value="{{ $productOption->id }}"
                                                        data-product-price="{{ $productOption->Price }}"
                                                        data-product-id="{{ $productOption->id }}"
                                                        @if ($product->id == $productOption->id) selected @endif>
                                                        {{ $productOption->ProductName }}
                                                    </option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="price_{{ $index }}" class="form-label">Đơn giá</label>
                                        <input class="form-control price" type="text" id="price_{{ $index }}"
                                            placeholder="Đơn giá được tự động cập nhật" onchange="updateTotal()"
                                            value="{{ $product->Price }}" readonly>
                                    </div>
                                    <div class="col-md-2">
                                        <label for="quantity_{{ $index }}" class="form-label">Số lượng</label>
                                        <input class="form-control quantity" type="text"
                                            id="quantity_{{ $index }}"
                                            name="products[{{ $index }}][quantity]"
                                            onchange="updateArrayQuantity(),updateTotal()"
                                            value="{{ $product->pivot->Quantity }}">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="subtotal_{{ $index }}" class="form-label">Tổng</label>
                                        <input class="form-control subtotal" type="text"
                                            id="subtotal_{{ $index }}"
                                            name="products[{{ $index }}][subtotal]" value="" readonly>
                                    </div>
                                    <div class="col-md-1 d-flex align-items-end justify-content-end mx-0">
                                        <button type="button" class="btn btn-danger"
                                            onclick="removeProduct({{ $index }})">Xóa</button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>      
                    <div class="mb-3 d-flex justify-content-center align-items-center">
                        <div class="text-center mx-2">
                            <button type="button" id="add-product" class="btn btn-info">Thêm suất cơm mới</button>
                        </div>
                        <div class="text-center mx-2">
                            <button type="button" id="add-fastfood" class="btn btn-info">Thêm món ăn nhanh</button>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="formGroupExampleInput" class="form-label">Tổng cộng</label>
                        <input type="text" class="form-control" id="totalInput" name="Total"
                            value="{{ $bill->Total }}" placeholder="Tổng được tự động cập nhật" readonly>
                    </div>
                </div>
                <div class="container d-flex justify-content-center align-items-center">
                    <div class="text-center pb-2 mx-2">
                        <a href="{{ route('bills.index') }}" class="btn btn-warning"> Quay lại</a>
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

@section('script')
    <script>
        let arrayProductID = [];
        let arrayPrice = [];
        let arrayQuantity = [];
        let arraySubTotal = [];

        document.addEventListener("DOMContentLoaded", function() {
            updateArrayPrice();
            updateArrayQuantity();
            updateSubTotal();
            updateTotal();
            updateProductID();
        });

        function updateArrayPrice() {
            arrayPrice = [];
            document.querySelectorAll('.price').forEach((item) => {
                arrayPrice.push(parseFloat(item.value) || 0);
            });
            console.log('Đơn giá: ', arrayPrice);
            updateSubTotal(); // Gọi hàm cập nhật tổng sau khi cập nhật giá
        }

        function updateArrayQuantity() {
            arrayQuantity = [];
            document.querySelectorAll('.quantity').forEach((item) => {
                arrayQuantity.push(parseInt(item.value) || 0);
            });
            console.log('Số lượng: ', arrayQuantity);
            updateSubTotal(); // Gọi hàm cập nhật tổng sau khi cập nhật số lượng
        }

        function updateSubTotal() {
            arraySubTotal = arrayPrice.map((price, index) => price * arrayQuantity[index]); // Tính tổng từng mặt hàng
            console.log('Tổng: ', arraySubTotal);

            // Gán giá trị từ mảng arraySubTotal vào các ô input có class subtotal
            document.querySelectorAll('.subtotal').forEach((item, index) => {
                // Kiểm tra nếu giá trị tổng là NaN thì hiển thị là 0
                if (isNaN(arraySubTotal[index])) {
                    item.value = 0;
                } else {
                    item.value = arraySubTotal[index]; // Gán giá trị từ mảng arraySubTotal vào input tương ứng
                }
            });
        }

        document.querySelectorAll('.quantity, .price').forEach(function(input) {
            input.addEventListener('change', function() {
                updateTotal(); // Cập nhật giá trị tổng
            });
        });

        function updateTotal() {
            let total = 0;
            // Lặp qua mỗi sản phẩm để tính tổng
            document.querySelectorAll('.subtotal').forEach(function(subtotalInput) {
                total += parseFloat(subtotalInput.value) || 0; // Chuyển đổi giá trị sang số và cộng vào tổng
            });
            document.getElementById('totalInput').value = total; // Cập nhật giá trị tổng vào input "Tổng cộng"
        }


        function updateProductID() {
            arrayProductId = [];
            document.querySelectorAll('.product').forEach((select) => {
                var productId = select.value;
                if (productId !== '') {
                    arrayProductId.push(productId);
                }
            });
            console.log('Id: ', arrayProductId);
        }

        document.getElementById('add-product').addEventListener('click', function() {
            var container = document.querySelector('.products-container');
            var index = container.getElementsByClassName('mb-3').length;
            var div = document.createElement('div');
            div.classList.add('mb-3');
            div.innerHTML = `
            <div class="row mb-3">
                <div class="col-md-3">
                    <label for="product_${index}" class="form-label">Loại suất</label>
                    <select class="form-select product" id="product_${index}" name="products[${index}][id]" onchange="updateProductDetails(this),updateProductID()">
                        <option value="">- Chọn loại suất -</option>
                        @foreach ($products as $product)
                            @if ($product->product_type->ProductTypeName == 'Cơm suất')
                                <option value="{{ $product->id }}"
                                    data-producttype-name="{{ $product->product_type->ProductTypeName }}"
                                    data-product-price="{{ $product->Price }}"
                                    data-product-id="{{ $product->id }}"> 
                                    {{ $product->ProductName }}
                                </option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="price_${index}" class="form-label">Đơn giá</label>
                    <input class="form-control price" type="text" id="price_${index}"
                        placeholder="Đơn giá được tự động cập nhật" onchange="updateTotal()" readonly>
                </div>
                <div class="col-md-2">
                    <label for="quantity_${index}" class="form-label">Số lượng</label>
                    <input class="form-control quantity" type="text" id="quantity_${index}" name="products[${index}][quantity]" onchange="updateArrayQuantity(),updateTotal()">
                </div>
                <div class="col-md-3">
                    <label for="subtotal_${index}" class="form-label">Tổng</label>
                    <input class="form-control subtotal" type="text" id="subtotal_${index}" name="products[${index}][subtotal]" value="0" readonly>
                </div>
                <div class="col-md-1 d-flex align-items-end justify-content-end mx-0">
                                        <button type="button" class="btn btn-danger"
                                            onclick="removeProduct({{ $index }})">Xóa</button>
                                    </div>
            </div>
            `;
            container.appendChild(div);
        });

        document.getElementById('add-fastfood').addEventListener('click', function() {
            var container = document.querySelector('.products-container');
            var index = container.getElementsByClassName('mb-3').length;
            var div = document.createElement('div');
            div.classList.add('mb-3');
            div.innerHTML = `
            <div class="row mb-3 pb-2">
                                    <div class="col-md-3">
                                        <label for="product_${index}" class="form-label">Chọn món ăn nhanh</label>
                                        <select class="form-select product" id="product_${index}"
                                            name="products[${index}][id]"
                                            onchange="updateProductDetails(this),updateProductID(),updateTotal()">
                                            <option value="">- Chọn món -</option>
                                            @foreach ($products as $product)
                                                @if ($product->product_type->ProductTypeName == 'Đồ ăn nhanh')
                                                    <option value="{{ $product->id }}"
                                                        data-product-price="{{ $product->Price }}"
                                                        data-product-id="{{ $product->id }}">
                                                        {{ $product->ProductName }}
                                                    </option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="price_${index}" class="form-label">Đơn giá</label>
                                        <input class="form-control price" type="text" id="price_${index}"
                                            placeholder="Đơn giá được tự động cập nhật" onchange="updateTotal()" readonly>
                                    </div>
                                    <div class="col-md-2">
                                        <label for="quantity_${index}" class="form-label">Số lượng</label>
                                        <input class="form-control quantity" type="text" id="quantity_${index}"
                                            name="products[${index}][quantity]"
                                            onchange="updateArrayQuantity(),updateTotal()">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="subtotal_${index}" class="form-label">Tổng</label>
                                        <input class="form-control subtotal" type="text" id="subtotal_${index}"
                                            name="products[${index}][subtotal]" value="0" readonly>
                                    </div>
                                    <div class="col-md-1 d-flex align-items-end justify-content-end mx-0">
                                        <button type="button" class="btn btn-danger"
                                            onclick="removeProduct(${index})">Xóa</button>
                                    </div>
                                </div>
            `;
            container.appendChild(div);
        });
        
        function updateProductDetails(select) {
            var selectedOption = select.options[select.selectedIndex];

            var productId = selectedOption.value;

            var productPrice = selectedOption.getAttribute('data-product-price');
            var priceInput = select.parentElement.nextElementSibling.querySelector('.price');
            priceInput.value = productPrice || '';

            // updateArrayPrice();
            updateArrayPrice();
        }

        function removeProduct(index) {
            var productToRemove = document.querySelector(`#product_${index}`).closest('.mb-3');
            var nextRow = productToRemove.nextElementSibling;
            if (nextRow) {
                nextRow.parentNode.removeChild(nextRow);
            }
            productToRemove.parentNode.removeChild(productToRemove);

            // Sau khi xóa sản phẩm, cập nhật lại tổng cộng
            updateTotal();
        }

        document.addEventListener('DOMContentLoaded', function() {
            document.querySelector('form').addEventListener('submit', function(event) {
                var productIdList = arrayProductId;
                var duplicateProductId = hasDuplicates(productIdList);

                if (duplicateProductId) {
                    event.preventDefault();
                    alert(
                        "Bạn đã chọn cùng một loại suất nhiều lần. Vui lòng chọn những loại suất khác nhau");
                }
            });

            function hasDuplicates(array) {
                return (new Set(array)).size !== array.length;
            }
        });
    </script>
@endsection
