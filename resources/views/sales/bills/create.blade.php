@extends('base')

@section('title', 'Thêm đơn mới')

@section('main')
    <section class="slide-section">
        <div class="container border rounded border-secondary">
            <div class="container text-center pt-2">
                <h2>Thêm mới đơn</h2>
            </div>
            <div class="container text-center pt-2">
                <input type="radio" id="single-dish" name="orderType" value="single">
                <label for="single-dish">Thêm suất cơm/đồ ăn nhanh mới</label>
                <input type="radio" id="combo-dish" name="orderType" value="combo" checked>
                <label for="combo-dish">Thêm mâm cơm mới</label>
            </div>
            <div class="container">
                <form id="single-dish-form" class="order-form" method="POST" action="{{ route('bills.store') }}"
                    style="display:none;">
                    @csrf
                    <div class="row justify-content-center mx-auto" style="width:80%">
                        <div class="mb-3">
                            <label for="formGroupExampleInput" class="form-label">STT</label>
                            <input type="text" readonly class="form-control" id="formGroupExampleInput" name="id"
                                value="" placeholder="STT tự động tăng (không cần nhập)">
                        </div>
                        <div class="mb-3">
                            <label for="formGroupExampleInput2" class="form-label">Ngày</label>
                            <input type="date" class="form-control" id="formGroupExampleInput2" name="Date"
                                value="{{ request()->date ? request()->date : date('Y-m-d') }}">
                        </div>
                        <div id="products-container" class="products-container border border-2 border-dark mb-3">
                            <div class="h5">Danh sách các sản phẩm</div>
                            <div class="mb-3">
                                {{-- Products list --}}
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
                            <label for="" class="form-label">Gọi thêm đồ</label>
                            <input type="text" class="form-control extra" id="extra" name="Extra" placeholder="0"
                                onchange="updateTotal()">
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

                <form id="combo-dish-form" class="order-form" method="POST" action="{{ route('bills.store') }}">
                    @csrf
                    <div class="row justify-content-center mx-auto" style="width:80%">
                        <div class="mb-3">
                            <label for="formGroupExampleInput" class="form-label">STT</label>
                            <input type="text" readonly class="form-control" id="formGroupExampleInput" name="id"
                                value="" placeholder="STT tự động tăng (không cần nhập)">
                        </div>
                        <div class="mb-3">
                            <label for="formGroupExampleInput2" class="form-label">Ngày</label>
                            <input type="date" class="form-control" id="formGroupExampleInput2" name="Date"
                                value="{{ date('Y-m-d') }}" placeholder="Nhập ngày"
                                {{ request()->date ? request()->date : date('Y-m-d') }}>
                        </div>
                        <div id="combo-products-container" class="products-container border border-2 border-dark mb-3">
                            <div class="h5">Danh sách các món</div>
                            <div class="mb-3">
                                <label for="menu-id" class="form-label">STT Menu</label>
                                <input type="text" readonly class="form-control mb-3" id="menu-id" name="Menu_ID"
                                    value="" placeholder="Chọn ngày và STT Menu sẽ được tự động hiển thị">
                                <div class="row">
                                    <div class="col-md-5">
                                        <label for="dish_${index}" class="form-label">Món ăn</label>
                                        <select class="form-select dish-select" id="dish_${index}"
                                            name="dishes[${index}][id]"
                                            onchange="updateDishSelected(),updateArrayPrice()">
                                            <!-- Option elements will be dynamically added here using JavaScript -->
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <label for="price_${index}" class="form-label">Đơn giá</label>
                                        <input class="form-control price" type="text" id="price_${index}"
                                            name="dishes[${index}][price]" placeholder="0"
                                            onchange="updateTotalForCombo()" readonly>
                                    </div>
                                    <div class="col-md-2">
                                        <label for="quantity_${index}" class="form-label">Số lượng</label>
                                        <input class="form-control quantity" type="text" id="quantity_${index}"
                                            name="dishes[${index}][quantity]" placeholder="0"
                                            onchange="updateArrayQuantity(),updateTotalForCombo()">
                                    </div>
                                    <div class="col-md-2">
                                        <label for="subtotal_${index}" class="form-label">Tổng</label>
                                        <input class="form-control subtotal" type="text" id="subtotal_${index}"
                                            name="dishes[${index}][subtotal]" placeholder="0" readonly>
                                    </div>
                                    <div class="col-md-1 d-flex align-items-end justify-content-end mx-0">
                                        <button type="button" class="btn btn-danger" onclick="removeDish(${index})"
                                            onchange="updateDishSelected()">Xóa</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="button" id="add-dish" class="btn btn-info">Thêm món mới</button>
                        <div class="mb-3">
                            <label for="combo-extra" class="form-label">Gọi thêm đồ</label>
                            <input type="text" class="form-control extra" id="combo-extra" name="Extra"
                                placeholder="0" onchange="updateTotalForCombo()">
                        </div>
                        <div class="mb-3">
                            <label for="combo-total" class="form-label">Tổng cộng</label>
                            <input type="text" class="form-control total" id="combo-total" name="Total"
                                value="0" readonly>
                        </div>
                    </div>
                    <div class="container d-flex justify-content-center align-items-center">
                        <div class="text-center pb-2 mx-2">
                            <a href="{{ route('bills.index') }}" class="btn btn-warning"> Quay lại</a>
                        </div>
                        <div class="text-center pb-2 mx-2">
                            <button type="submit" class="btn btn-warning">Thêm mới</button>
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
                        "Bạn đã chọn cùng một loại sản phẩm nhiều lần. Vui lòng chọn những loại sản phẩm khác nhau."
                    );
                }

                if (productIdList.length === 0) {
                    event.preventDefault();
                    alert('Vui lòng thêm ít nhất một sản phẩm.');
                }
            });

            function hasDuplicates(array) {
                return (new Set(array)).size !== array.length;
            }

            document.querySelectorAll('input[name="orderType"]').forEach((radio) => {
                radio.addEventListener('change', function() {
                    if (this.value === 'single') {
                        document.getElementById('single-dish-form').style.display = 'block';
                        document.getElementById('combo-dish-form').style.display = 'none';
                    } else {
                        document.getElementById('single-dish-form').style.display = 'none';
                        document.getElementById('combo-dish-form').style.display = 'block';
                        updateMenuId();
                    }
                });
            });

            document.querySelector('#combo-dish-form input[name="Date"]').addEventListener('change', function() {
                document.querySelectorAll('.price').forEach((priceInput) => {
                    priceInput.value = '';
                });
                document.querySelectorAll('.quantity').forEach((quantityInput) => {
                    quantityInput.value = '';
                });
                document.querySelectorAll('.subtotal').forEach((subtotalInput) => {
                    subtotalInput.value = '';
                });
                updateMenuId();
            });

            async function updateMenuId() {
                selectedDishes = [];
                console.log('Danh sách DishID đã chọn:', selectedDishes);
                const dateInput = document.querySelector('#combo-dish-form input[name="Date"]').value;
                if (dateInput) {
                    const data = await fetchMenuId(dateInput);
                    console.log('Menu ID:', data.menu_id);
                    if (data.menu_id) {
                        document.getElementById('menu-id').value = data.menu_id;
                        dishesData = data.dishes;
                        console.log('Dish ID:', data.dishes);
                        updateAllDishSelects();
                    } else {
                        document.getElementById('menu-id').value = 'Không có menu nào được tìm thấy';
                        dishesData = [];
                        updateAllDishSelects();
                    }
                }
                //clearDishRows();
            }

            function clearDishRows() {
                const dishRows = document.querySelectorAll('#combo-products-container .row');
                dishRows.forEach(row => {
                    row.remove();
                });
            }

            function updateAllDishSelects() {
                const dishSelects = document.querySelectorAll('.dish-select');
                dishSelects.forEach(select => {
                    select.innerHTML = '';
                    const defaultOption = document.createElement('option');
                    defaultOption.value = '';
                    defaultOption.textContent = '- Chọn món ăn -';
                    select.appendChild(defaultOption);

                    select.value = '';

                    dishesData.forEach(dish => {
                        const option = document.createElement('option');
                        option.value = dish.id;
                        option.textContent = dish.DishName;
                        option.dataset.dishPrice = dish
                            .Price; // Thêm giá vào thuộc tính dữ liệu của option
                        select.appendChild(option);
                    });
                });
            }

            let dishesData = [];

            async function fetchMenuId(date) {
                try {
                    const response = await fetch(`{{ route('getMenuIdByDate') }}?date=${date}`);
                    if (response.ok) {
                        return await response.json();
                    } else {
                        console.error('Không thể lấy Menu ID');
                        return {
                            menu_id: '',
                            dishes: []
                        };
                    }
                } catch (error) {
                    console.error('Lỗi:', error);
                    return {
                        menu_id: '',
                        dishes: []
                    };
                }
            }

            document.getElementById('add-dish').addEventListener('click', function() {
                var container = document.querySelector('#combo-products-container');
                var index = container.getElementsByClassName('mb-3').length;
                var div = document.createElement('div');
                div.classList.add('mb-3');
                div.innerHTML = `
                <div class="row">
                                    <div class="col-md-5">
                                        <label for="dish_${index}" class="form-label">Món ăn</label>
                                        <select class="form-select dish-select" id="dish_${index}"
                                            name="dishes[${index}][id]"
                                            onchange="updateDishSelected(),updateArrayPrice()">
                                            <!-- Option elements will be dynamically added here using JavaScript -->
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <label for="price_${index}" class="form-label">Đơn giá</label>
                                        <input class="form-control price" type="text" id="price_${index}"
                                            name="dishes[${index}][price]" placeholder="0"
                                            onchange="updateTotalForCombo()" readonly>
                                    </div>
                                    <div class="col-md-2">
                                        <label for="quantity_${index}" class="form-label">Số lượng</label>
                                        <input class="form-control quantity" type="text" id="quantity_${index}"
                                            name="dishes[${index}][quantity]" placeholder="0"
                                            onchange="updateArrayQuantity(),updateTotalForCombo()">
                                    </div>
                                    <div class="col-md-2">
                                        <label for="subtotal_${index}" class="form-label">Tổng</label>
                                        <input class="form-control subtotal" type="text" id="subtotal_${index}"
                                            name="dishes[${index}][subtotal]" placeholder="0" readonly>
                                    </div>
                                    <div class="col-md-1 d-flex align-items-end justify-content-end mx-0">
                                        <button type="button" class="btn btn-danger" onclick="removeDish(${index})"
                                            onchange="updateDishSelected()">Xóa</button>
                                    </div>
                                </div>`;

                container.appendChild(div);
                updateDishSelect(index);
            });

            // Thêm hàm mới để cập nhật select box món ăn mới thêm vào
            function updateDishSelect(index) {
                const select = document.getElementById(`dish_${index}`);
                select.innerHTML = '';
                const defaultOption = document.createElement('option');
                defaultOption.value = '';
                defaultOption.textContent = '- Chọn món ăn -';
                select.appendChild(defaultOption);

                select.value = '';

                dishesData.forEach(dish => {
                    const option = document.createElement('option');
                    option.value = dish.id;
                    option.textContent = dish.DishName;
                    option.dataset.dishPrice = dish.Price; // Thêm giá vào thuộc tính dữ liệu của option
                    select.appendChild(option);
                });
            }
            updateMenuId();
        });

        let selectedDishes = [];

        function updateDishSelected() {
            selectedDishes = [];
            document.querySelectorAll('.dish-select').forEach((select) => {
                let selectedOption = select.options[select.selectedIndex];
                if (selectedOption) {
                    let dishId = selectedOption.value;
                    if (dishId !== '') {
                        let dishObject = {
                            id: dishId,
                            name: selectedOption.textContent,
                            price: selectedOption.dataset.dishPrice // Sử dụng giá từ thuộc tính dữ liệu
                        };
                        selectedDishes.push(dishObject);
                        // Tìm input giá gần nhất và cập nhật giá trị
                        let priceInput = select.closest('.row').querySelector('.price');
                        priceInput.value = dishObject.price;
                    }
                }
            });
            console.log('Danh sách Dish đã chọn:', selectedDishes);
        }

        function updatePriceInput() {
            selectedDishes.forEach((dish) => {
                const inputId = `price_${dish.id}`;
                const priceInput = document.getElementById(inputId);
                if (priceInput) {
                    priceInput.value = dish.price;
                }
            });
        }

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
            updateSubTotal();
        }

        function updateArrayQuantity() {
            arrayQuantity = [];
            document.querySelectorAll('.quantity').forEach((item) => {
                arrayQuantity.push(parseInt(item.value) || 0);
            });
            console.log('Số lượng: ', arrayQuantity);
            updateSubTotal();
        }

        function updateSubTotal() {
            arraySubTotal = arrayPrice.map((price, index) => price * arrayQuantity[index]);
            console.log('Tổng: ', arraySubTotal);

            document.querySelectorAll('.subtotal').forEach((item, index) => {
                if (isNaN(arraySubTotal[index])) {
                    item.value = 0;
                } else {
                    item.value = arraySubTotal[index];
                }
            });

            updateTotal();
        }

        function updateTotal() {
            let total = arraySubTotal.reduce((acc, curr) => acc + (isNaN(curr) ? 0 : curr), 0);

            let extraValue = parseFloat(document.getElementById('extra').value) || 0;
            total += extraValue;

            document.getElementById('total').value = total;
        }

        function updateTotalForCombo() {
            let total = 0;

            // Lặp qua mỗi hàng trong form thứ hai để tính tổng giá trị
            document.querySelectorAll('#combo-dish-form .subtotal').forEach((subtotalInput) => {
                const subtotal = parseFloat(subtotalInput.value) || 0;
                total += subtotal;
            });

            // Lấy giá trị của extra và cộng vào tổng
            const extra = parseFloat(document.getElementById('combo-extra').value) || 0;
            total += extra;

            // Cập nhật tổng giá trị vào input Total của form thứ hai
            document.getElementById('combo-total').value = total;

            // Log ra tổng giá trị
            console.log('Tổng giá trị:', total);
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
            var container = document.querySelector('#products-container');
            var index = container.getElementsByClassName('mb-3').length;
            var div = document.createElement('div');
            div.classList.add('mb-3');
            div.innerHTML = `
                <div class="row mb-3 pb-2">
                    <div class="col-md-3">
                        <label for="product_${index}" class="form-label">Loại suất</label>
                        <select class="form-select product" id="product_${index}" name="products[${index}][id]" onchange="updateProductDetails(this),updateProductID(),updateTotal()">
                            <option value="">- Chọn loại suất -</option>
                            @foreach ($products as $product)
                                @if ($product->product_type->ProductTypeName == 'Cơm suất')
                                    <option value="{{ $product->id }}" data-product-price="{{ $product->Price }}" data-product-id="{{ $product->id }}">{{ $product->ProductName }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="price_${index}" class="form-label">Đơn giá</label>
                        <input class="form-control price" type="text" id="price_${index}" placeholder="Đơn giá được tự động cập nhật" onchange="updateTotal()" readonly>
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
                        <button type="button" class="btn btn-danger" onclick="removeProduct(${index})">Xóa</button>
                    </div>
                </div>`;
            container.appendChild(div);
        });

        document.getElementById('add-fastfood').addEventListener('click', function() {
            var container = document.querySelector('#products-container');
            var index = container.getElementsByClassName('mb-3').length;
            var div = document.createElement('div');
            div.classList.add('mb-3');
            div.innerHTML = `
                <div class="row mb-3 pb-2">
                    <div class="col-md-3">
                        <label for="product_${index}" class="form-label">Món ăn nhanh</label>
                        <select class="form-select product" id="product_${index}" name="products[${index}][id]" onchange="updateProductDetails(this),updateProductID(),updateTotal()">
                            <option value="">- Chọn món -</option>
                            @foreach ($products as $product)
                                @if ($product->product_type->ProductTypeName == 'Đồ ăn nhanh')
                                    <option value="{{ $product->id }}" data-product-price="{{ $product->Price }}" data-product-id="{{ $product->id }}">{{ $product->ProductName }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="price_${index}" class="form-label">Đơn giá</label>
                        <input class="form-control price" type="text" id="price_${index}" placeholder="Đơn giá được tự động cập nhật" onchange="updateTotal()" readonly>
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
                        <button type="button" class="btn btn-danger" onclick="removeProduct(${index})">Xóa</button>
                    </div>
                </div>`;
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
            $(`#product_${index}`).closest('.row').remove();
            updateArrayPrice();
            updateArrayQuantity();
            updateSubTotal();
            updateTotal();
            updateProductID();
        }

        function removeDish(index) {
            $(`#dish_${index}`).closest('.row').remove();
            updateDishSelected();
        }
    </script>
@endsection
