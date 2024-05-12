@extends('base')

@section('title', 'Thêm đơn mới')

@section('main')
    <section class="slide-section">
        <div class="container border rounded border-secondary">
            <div class="container text-center pt-2">
                <h2>Thêm mới đơn</h2>
            </div>
            <div class="container">
                <form class="" method="POST" action="{{ route('bills.store') }}">
                    @csrf
                    <div class="row justify-content-center mx-auto" style="width:80%">
                        <div class="mb-3">
                            <label for="formGroupExampleInput" class="form-label">STT</label>
                            <input type="text" readonly class="form-control" id="formGroupExampleInput" name="id"
                                value="" placeholder="STT tự động tăng (không cần nhập)">
                        </div>
                        <div class="mb-3">
                            <label for="formGroupExampleInput2" class="form-label">Date</label>
                            <input type="date" class="form-control" id="formGroupExampleInput2" name="Date"
                                value="{{ request()->date ? request()->date : date('Y-m-d') }}">
                        </div>
                        <div id="products-container" class="products-container border border-2 border-dark mb-3">
                            <div class="h5">Danh sách các món</div>
                            <div class="mb-3">

                            </div>
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
                            <label for="" class="form-label">Tổng cộng</label>
                            <input type="text" class="form-control total" id="total" name="Total" value="0"
                                readonly>
                        </div>
                    </div>
                    <div class="container d-flex justify-content-center align-items-center">
                        <div class="text-center pb-2 mx-2">
                            <a href="{{ route('bills.index') }}" class="btn btn-warning"> Quay lại</a>
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

@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelector('form').addEventListener('submit', function(event) {
                var productIdList = arrayProductId;
                var duplicateProductId = hasDuplicates(productIdList);

                if (duplicateProductId) {
                    event.preventDefault();
                    alert(
                        "Bạn đã chọn cùng một loại suất nhiều lần. Vui lòng chọn những loại suất khác nhau"
                    );
                } else {

                }


            });

            function hasDuplicates(array) {
                return (new Set(array)).size !== array.length;
            }


            document.getElementById('add-product').addEventListener('click', function() {

                document.getElementById('products-container').style.display = 'block';
            });

        });


        let arrayProductId = [];
        let arrayPrice = [];
        let arrayQuantity = [];
        let arraySubTotal = [];


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

            updateTotal(); // Cập nhật tổng cộng
        }

        function updateTotal() {
            let total = arraySubTotal.reduce((acc, curr) => acc + (isNaN(curr) ? 0 : curr), 0);
            document.getElementById('total').value = total;
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
            <div class="row mb-3 pb-2">
                                    <div class="col-md-3">
                                        <label for="product_${index}" class="form-label">Loại suất</label>
                                        <select class="form-select product" id="product_${index}"
                                            name="products[${index}][id]"
                                            onchange="updateProductDetails(this),updateProductID(),updateTotal()">
                                            <option value="">- Chọn loại suất -</option>
                                            @foreach ($products as $product)
                                                @if ($product->product_type->ProductTypeName == 'Cơm suất')
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

            updateArrayPrice();
        }

        function removeProduct(index) {
            // Tìm phần tử cha của nút "Xóa" được click (dòng hiện tại) và loại bỏ nó khỏi DOM
            $(`#product_${index}`).closest('.row').remove();
            // Sau khi loại bỏ dòng, cập nhật lại giá trị
            updateArrayPrice();
            updateArrayQuantity();
            updateSubTotal();
            updateTotal();
            updateProductID(); // Cập nhật danh sách ID sản phẩm
        }
    </script>
@endsection
