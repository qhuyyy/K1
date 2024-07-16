@extends('base')

@section('title', 'Chỉnh sửa thông tin hóa đơn')

@section('main')
    <section class="slide-section">
        <div class="container border rounded border-secondary">
            <div class="container text-center pt-2">
                <h2>Chỉnh sửa thông tin hóa đơn</h2>
            </div>
            @if ($bill->BillType_ID == '1')
                <form id="form1" method="POST" action="{{ route('bills.updateProducts', $bill) }}">
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
                            <input type="date" class="form-control" id="Date" name="Date"
                                value="{{ $bill->Date }}" placeholder="Chọn ngày">
                        </div>
                        <div class="border border-2 border-dark mb-3">
                            <div class="h5">Thông tin khách hàng</div>
                            <div class="row">
                                <div class="mb-3 col-md-4">
                                    <label for="formGroupExampleInput" class="form-label">Họ tên</label>
                                    <input type="text" class="form-control" id="formGroupExampleInput"
                                        name="CustomerName" value="{{ $bill->customer->CustomerName }}"
                                        placeholder="Nhập họ tên của khách hàng">
                                </div>
                                <div class="mb-3 col-md-4">
                                    <label for="formGroupExampleInput" class="form-label">Thông tin liên hệ</label>
                                    <input type="text" class="form-control" id="formGroupExampleInput" name="Contact"
                                        value="{{ $bill->customer->Contact }}" placeholder="Nhập thông tin liên hệ">
                                </div>
                                <div class="mb-3 col-md-4">
                                    <label for="formGroupExampleInput" class="form-label">Ghi chú</label>
                                    <input type="text" class="form-control" id="formGroupExampleInput" name="Note"
                                        value="{{ $bill->customer->Note }}" placeholder="Nhập ghi chú">
                                </div>
                            </div>
                        </div>
                        <div class="products-container border border-2 border-dark mb-3" id="products-container">
                            <div class="h5">Danh sách các sản phẩm</div>
                            @foreach ($bill->products as $index => $product)
                                <div class="mb-3">
                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <label for="product{{ $index }}" class="form-label"
                                                data-product-type="{{ $product->product_type->ProductTypeName }}">
                                                {{ $product->product_type->ProductTypeName }}
                                            </label>
                                            <select class="form-select product" id="product_{{ $index }}"
                                                name="products[{{ $index }}][id]"
                                                onchange="updateProductDetails(this),updateProductID()">
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
                                                placeholder="Đơn giá được tự động cập nhật" value="{{ $product->Price }}"
                                                readonly>
                                        </div>
                                        <div class="col-md-2">
                                            <label for="quantity_{{ $index }}" class="form-label">Số lượng</label>
                                            <input class="form-control quantity" type="text"
                                                id="quantity_{{ $index }}"
                                                name="products[{{ $index }}][quantity]"
                                                onchange="updateArrayQuantity(),updateArrayPrice(),updateTotal()"
                                                value="{{ $product->pivot->Quantity }}">
                                        </div>
                                        <div class="col-md-3">
                                            <label for="subtotal_{{ $index }}" class="form-label">Tổng</label>
                                            <input class="form-control subtotal" type="text"
                                                id="subtotal_{{ $index }}"
                                                name="products[{{ $index }}][subtotal]"
                                                value="{{ $product->pivot->SubTotal }}" readonly>
                                        </div>
                                        <div class="col-md-1 d-flex align-items-end justify-content-end mx-0">
                                            <button type="button" class="btn btn-danger"
                                                onclick="removeProduct(this)">Xóa</button>
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
            @else
                <form id="form2" method="POST" action="{{ route('bills.updateTables', $bill) }}">
                    @csrf
                    @method('PUT')
                    <div class="row justify-content-center mx-auto" style="width:80%">
                        <div class="mb-3">
                            <label for="formGroupExampleInput" class="form-label">STT</label>
                            <input type="text" readonly class="form-control" id="formGroupExampleInput"
                                name="id" value="{{ $bill->id }}" title="Không thể chỉnh sửa STT">
                        </div>
                        <div class="mb-3">
                            <label for="formGroupExampleInput2" class="form-label">Date</label>
                            <input type="date" class="form-control" id="Date" name="Date"
                                value="{{ $bill->Date }}" placeholder="Chọn ngày">
                        </div>
                        <div class="border border-2 border-dark mb-3">
                            <div class="h5">Thông tin khách hàng</div>
                            <div class="row">
                                <div class="mb-3 col-md-4">
                                    <label for="formGroupExampleInput" class="form-label">Họ tên</label>
                                    <input type="text" class="form-control" id="formGroupExampleInput"
                                        name="CustomerName" value="{{ $bill->customer->CustomerName }}"
                                        placeholder="Nhập họ tên của khách hàng">
                                </div>
                                <div class="mb-3 col-md-4">
                                    <label for="formGroupExampleInput" class="form-label">Thông tin liên hệ</label>
                                    <input type="text" class="form-control" id="formGroupExampleInput" name="Contact"
                                        value="{{ $bill->customer->Contact }}" placeholder="Nhập thông tin liên hệ">
                                </div>
                                <div class="mb-3 col-md-4">
                                    <label for="formGroupExampleInput" class="form-label">Ghi chú</label>
                                    <input type="text" class="form-control" id="formGroupExampleInput" name="Note"
                                        value="{{ $bill->customer->Note }}" placeholder="Nhập ghi chú">
                                </div>
                            </div>
                        </div>
                        <div class="combo-products-container border border-2 border-dark mb-3"
                            id="combo-products-container">
                            <div class="h5">Danh sách các món</div>
                            <label for="menu-id" class="form-label">STT Menu</label>
                            <input type="text" readonly class="form-control mb-3" id="menu-id" name="Menu_ID"
                                value="" placeholder="Chọn ngày và STT Menu sẽ được tự động hiển thị">
                            @foreach ($table->dishes as $index => $dish)
                                <div class="mb-3">
                                    <div class="row mb-3">
                                        <div class="col-md-5">
                                            <label for="dish_{{ $index }}" class="form-label">Món ăn</label>
                                            <select class="form-select dish-select dish" id="dish_{{ $index }}"
                                                name="dishes[{{ $index }}][id]"
                                                onchange="updateDishSelected(this), updateArrayPriceForCombo(), updateArrayQuantityForCombo(), updateDishID(), updateSubTotalForCombo()"
                                                data-selected-value="{{ $dish->id }}">
                                                <!-- Option elements will be dynamically added here using JavaScript -->
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <label for="price_{{ $index }}" class="form-label">Đơn giá</label>
                                            <input class="form-control price" type="text"
                                                id="price_{{ $index }}" name="dishes[{{ $index }}][price]"
                                                value="{{ $dish->Price }}" readonly>
                                        </div>
                                        <div class="col-md-2">
                                            <label for="quantity_{{ $index }}" class="form-label">Số lượng</label>
                                            <input class="form-control quantity" type="text"
                                                name="dishes[{{ $index }}][quantity]"
                                                id="quantity_{{ $index }}"
                                                value="{{ $dish->pivot->NumberOfDishes }}"
                                                onchange="updateArrayQuantityForCombo(),updateTotalForCombo(),updateSubTotalForCombo()">
                                        </div>
                                        <div class="col-md-2">
                                            <label for="subtotal_{{ $index }}" class="form-label">Tổng</label>
                                            <input class="form-control subtotal" type="text"
                                                id="subtotal_{{ $index }}"
                                                name="dishes[{{ $index }}][subtotal]"
                                                value="{{ $dish->Price * $dish->pivot->NumberOfDishes }}" readonly>
                                        </div>
                                        <div class="col-md-1 d-flex align-items-end justify-content-end mx-0">
                                            <button type="button" class="btn btn-danger" onclick="removeDish(this)"
                                                onchange="updateDishSelected()">Xóa</button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <button type="button" id="add-dish" class="btn btn-info mb-3">Thêm món mới</button>
                        <div class="container">
                            <div class="row">
                                <div class="mb-3 col-md-4">
                                    <label for="" class="form-label">Số lượng mâm</label>
                                    <input type="text" class="form-control" id="number-of-tables"
                                        name="NumberOfTables" placeholder="Nhập số lượng mâm"
                                        value="{{ $table->NumberOfTables }}" onchange="updateTotalForCombo()">
                                </div>
                                <div class="mb-3 col-md-4">
                                    <label for="combo-extra" class="form-label">Gọi thêm đồ</label>
                                    <input type="text" class="form-control extra" id="combo-extra" name="Extra"
                                        placeholder="Nhập số tiền gọi thêm đồ" onchange="updateTotalForCombo()"
                                        value="{{ $bill->Extra }}">
                                </div>
                                <div class="mb-3 col-md-4">
                                    <label for="combo-prepaid" class="form-label">Đặt cọc trước</label>
                                    <input type="text" class="form-control prepaid" id="combo-prepaid" name="Prepaid"
                                        placeholder="Nhập số tiền đặt cọc trước" value="{{ $bill->Prepaid }}">
                                </div>
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
            @endif
        </div>
    </section>
@endsection

@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let dishesData = [];
            let selectedDishes = [];
            let arrayPriceCombo = [];
            let arrayQuantityCombo = [];
            let arraySubTotalCombo = [];

            if ("{{ $bill->BillType_ID }}" == '1') {
                document.getElementById('form1').addEventListener('submit', function(event) {
                    var productIdList = arrayProductId;
                    var duplicateProductId = hasDuplicates(productIdList);

                    if (duplicateProductId) {
                        event.preventDefault();
                        alert(
                            "Bạn đã chọn cùng một sản phẩm nhiều lần. Vui lòng chọn những sản phẩm khác nhau."
                        );
                    }

                    if (productIdList.length === 0) {
                        event.preventDefault();
                        alert('Vui lòng thêm ít nhất một sản phẩm.');
                    }
                });
                updateProductID();
            }

            if ("{{ $bill->BillType_ID }}" == '2') {
                document.getElementById('form2').addEventListener('submit', function(event) {
                    var dishIdList = arrayDishId;
                    var duplicateDishId = hasDuplicates(dishIdList);

                    if (duplicateDishId) {
                        event.preventDefault();
                        alert("Bạn đã chọn cùng một món nhiều lần. Vui lòng chọn những món khác nhau.");
                    }

                    if (dishIdList.length === 0) {
                        event.preventDefault();
                        alert('Vui lòng thêm ít nhất một món.');
                    }
                });
            }

            function hasDuplicates(array) {
                return (new Set(array)).size !== array.length;
            }

            document.querySelector('#Date').addEventListener('change', function() {
                updateMenuId();
                clearDishRows();
            });

            async function updateMenuId() {
                const dateInput = document.querySelector('#Date').value;
                if (dateInput) {
                    const data = await fetchMenuId(dateInput);
                    const menuIdInput = document.getElementById('menu-id');
                    if (data.menu_id) {
                        menuIdInput.value = data.menu_id;
                        dishesData = data.dishes;
                        updateAllDishSelects();
                    } else {
                        menuIdInput.value = 'Không có menu nào được tìm thấy';
                        dishesData = [];
                        updateAllDishSelects();
                    }
                }
            }

            function updateDishOptions() {
                // Lặp qua mỗi select box dish_option
                document.querySelectorAll('.dish-select').forEach(select => {
                    // Lấy giá trị đã chọn từ thuộc tính data của option được chọn
                    const selectedDishId = select.value;
                    // Lặp qua từng option trong select box
                    select.querySelectorAll('option').forEach(option => {
                        // Nếu giá trị của option trùng với giá trị đã chọn, đặt selected = true
                        if (option.value === selectedDishId) {
                            option.selected = true;
                        }
                    });
                });
            }

            function clearDishRows() {
                const dishRows = document.querySelectorAll('#combo-products-container .row');
                dishRows.forEach(row => {
                    row.remove();
                });
                document.getElementById('number-of-tables').value = '1';
                document.getElementById('totalInput').value = '0';
            }

            function updateAllDishSelects() {
                const dishSelects = document.querySelectorAll('.dish-select');
                dishSelects.forEach(select => {
                    select.innerHTML = ''; // Xóa tất cả các option hiện có trong select box

                    // Thêm option mặc định
                    const defaultOption = document.createElement('option');
                    defaultOption.value = '';
                    defaultOption.textContent = '- Chọn món ăn -';
                    select.appendChild(defaultOption);

                    dishesData.forEach(dish => {
                        const option = document.createElement('option');
                        option.value = dish.id;
                        option.textContent = dish.DishName;
                        option.dataset.dishPrice = dish
                            .Price; // Thêm giá vào thuộc tính dữ liệu của option
                        select.appendChild(option);
                    });

                    // Đặt giá trị đã chọn nếu có
                    const selectedValue = select.getAttribute('data-selected-value');
                    if (selectedValue) {
                        select.value = selectedValue;
                    }
                });
            }

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
                var container = document.querySelector('.combo-products-container'); // Chọn container
                var index = container ? container.getElementsByClassName('row').length :
                    0; // Lấy số lượng dòng hiện tại
                var div = document.createElement('div'); // Tạo một div mới
                div.classList.add('row', 'mb-3'); // Thêm class 'row' và 'mb-3' vào div
                div.innerHTML = `
                    <div class="col-md-5">
                        <label for="dish_${index}" class="form-label">Món ăn</label>
                        <select class="form-select dish-select dish" id="dish_${index}"
                            name="dishes[${index}][id]"
                            onchange="updateDishSelected(); updateArrayPriceForCombo(); updateArrayQuantityForCombo(); updateDishID(); updateSubTotalForCombo()" 
                            >
                            <!-- Option elements will be dynamically added here using JavaScript -->
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label for="price_${index}" class="form-label">Đơn giá</label>
                        <input class="form-control price" type="text" id="price_${index}"
                            name="dishes[${index}][price]" placeholder="0" readonly>
                    </div>
                    <div class="col-md-2">
                        <label for="quantity_${index}" class="form-label">Số lượng</label>
                        <input class="form-control quantity" type="text" id="quantity_${index}"
                            name="dishes[${index}][quantity]" placeholder="0"
                            onchange="updateArrayQuantityForCombo(),updateTotalForCombo(),updateSubTotalForCombo()">
                    </div>
                    <div class="col-md-2">
                                            <label for="subtotal_{{ $index }}" class="form-label">Tổng</label>
                                            <input class="form-control subtotal" type="text"
                                                id="subtotal_{{ $index }}"
                                                name="dishes[{{ $index }}][subtotal]"
                                                value ="0" readonly>
                                                </div>
                    <div class="col-md-1 d-flex align-items-end justify-content-end mx-0">
                        <button type="button" class="btn btn-danger" onclick="removeDishes(${index})">Xóa</button>
                    </div>
                `;

                container.appendChild(div); // Thêm div vào container
                updateDishSelect(index); // Cập nhật select box cho món ăn mới thêm
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
            updateDishOptions();
            updateArrayPriceForCombo();
            updateArrayQuantityForCombo();
            
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
                        <label for="product_${index}" class="form-label">Cơm suất</label>
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
                            placeholder="Đơn giá được tự động cập nhật" readonly>
                    </div>
                    <div class="col-md-2">
                        <label for="quantity_${index}" class="form-label">Số lượng</label>
                        <input class="form-control quantity" type="text" id="quantity_${index}" name="products[${index}][quantity]" onchange="updateArrayQuantity(),updateArrayPrice(),updateTotal()">
                    </div>
                    <div class="col-md-3">
                        <label for="subtotal_${index}" class="form-label">Tổng</label>
                        <input class="form-control subtotal" type="text" id="subtotal_${index}" name="products[${index}][subtotal]" value="0" readonly>
                    </div>
                    <div class="col-md-1 d-flex align-items-end justify-content-end mx-0">
                                            <button type="button" class="btn btn-danger"
                                            onclick="removeProduct(this)">Xóa</button>
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
                                            <label for="product_${index}" class="form-label">Đồ ăn nhanh</label>
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
                                            onclick="removeProduct(this)">Xóa</button>
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

            // Cập nhật đơn giá và số lượng
            updateArrayPrice();
            updateArrayQuantity();

            // Tính lại tổng tiền
            updateSubTotal();
            updateTotal();
        }

        function removeProduct(button) {
            // Truy cập đến phần tử cha của nút "Xóa" được click
            var rowToRemove = button.closest('.row');
            // Loại bỏ phần tử cha khỏi DOM
            rowToRemove.parentNode.removeChild(rowToRemove);
            // Sau khi loại bỏ dòng, cập nhật lại giá trị
            updateArrayPrice();
            updateArrayQuantity();
            updateSubTotal();
            updateTotal();
            updateProductID();
        }

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

        function updateDishID() {
            arrayDishId = [];
            document.querySelectorAll('.dish').forEach((select) => {
                var dishId = select.value;
                if (dishId != '') {
                    arrayDishId.push(dishId);
                }
            });
            console.log('Id: ', arrayDishId);
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

        function updateArrayPriceForCombo() {
            arrayPriceCombo = [];
            document.querySelectorAll('.price').forEach((item) => {
                arrayPriceCombo.push(parseFloat(item.value) || 0);
            });
            console.log('Đơn giá (combo): ', arrayPriceCombo);

        }

        function updateArrayQuantityForCombo() {
            arrayQuantityCombo = [];
            document.querySelectorAll('.quantity').forEach((item) => {
                arrayQuantityCombo.push(parseInt(item.value) || 0);
            });
            console.log('Số lượng (combo): ', arrayQuantityCombo);

        }

        function updateSubTotalForCombo() {
            arraySubTotalCombo = arrayPriceCombo.map((price, index) => price * arrayQuantityCombo[index]);
            console.log('Tổng (combo): ', arraySubTotalCombo);

            document.querySelectorAll('.subtotal').forEach((item, index) => {
                if (isNaN(arraySubTotalCombo[index])) {
                    item.value = 0;
                } else {
                    item.value = arraySubTotalCombo[index];
                }
            });

            updateTotalForCombo();
        }

        function updateTotalForCombo() {
            let total = 0;

            document.querySelectorAll('.subtotal').forEach((subtotalInput) => {
                const subtotal = parseFloat(subtotalInput.value) || 0;
                total += subtotal;
            });

            const numberOfTables = parseFloat(document.getElementById('number-of-tables').value) || 1;

            total *= numberOfTables;
            const extra = parseFloat(document.getElementById('combo-extra').value) || 0;
            total += extra;
            document.getElementById('totalInput').value = total;

            console.log('Tổng giá trị:', total);
        }

        function removeDish(button) {
            var rowToRemove = button.closest('.row');
            // Loại bỏ phần tử cha khỏi DOM
            rowToRemove.parentNode.removeChild(rowToRemove);
            updateDishSelected();
            updateDishID();
            updateArrayPriceForCombo();
            updateArrayQuantityForCombo();
            updateTotal();
        }

        function removeDishes(index) {
            $(`#dish_${index}`).closest('.row').remove();
            updateDishSelected();
            updateDishID();
            updateArrayPriceForCombo();
            updateArrayQuantityForCombo();
            updateTotalForCombo();
        }
    </script>
@endsection
