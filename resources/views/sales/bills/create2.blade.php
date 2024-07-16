@extends('base')

@section('title', 'Thêm đơn mới đơn cơm suất')

@section('main')
    <section class="slide-section">
        <div class="container border rounded border-secondary">
            <div class="container text-center pt-2">
                <h2>Thêm mới đơn cơm suất</h2>
            </div>
            <div class="container text-center pt-2">
                <a href="{{ route('bills.createWithoutParams') }}" class="btn btn-info">Thêm đơn sản phẩm</a>
            </div>
            <div class="container">
                <form id="combo-dish-form" class="order-form" method="POST" action="{{ route('save.tables') }}">
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
                        <div class="border border-2 border-dark mb-3">
                            <div class="h5">Thông tin khách hàng</div>
                            <div class="row">
                                <div class="mb-3 col-md-4">
                                    <label for="formGroupExampleInput" class="form-label">Họ tên</label>
                                    <input type="text" class="form-control" id="formGroupExampleInput"
                                        name="CustomerName" value="Khách hàng" placeholder="Nhập họ tên của khách hàng">
                                </div>
                                <div class="mb-3 col-md-4">
                                    <label for="formGroupExampleInput" class="form-label">Thông tin liên hệ</label>
                                    <input type="text" class="form-control" id="formGroupExampleInput" name="Contact"
                                        value="" placeholder="Nhập thông tin liên hệ">
                                </div>
                                <div class="mb-3 col-md-4">
                                    <label for="formGroupExampleInput" class="form-label">Ghi chú</label>
                                    <input type="text" class="form-control" id="formGroupExampleInput" name="Note"
                                        value="" placeholder="Thêm ghi chú">
                                </div>
                            </div>
                        </div>
                        <div id="combo-products-container" class="border border-2 border-dark mb-3">
                            <div class="h5">Danh sách các món</div>
                            <div class="mb-3">
                                <label for="menu-id" class="form-label">STT Menu</label>
                                <input type="text" readonly class="form-control mb-3" id="menu-id" name="Menu_ID"
                                    value="" placeholder="Chọn ngày và STT Menu sẽ được tự động hiển thị">
                                <div class="row">

                                </div>
                            </div>
                        </div>
                        <button type="button" id="add-dish" class="btn btn-info mb-3">Thêm món mới</button>
                        <div class="container">
                            <div class="row">
                                <div class="mb-3 col-md-4">
                                    <label for="" class="form-label">Số lượng mâm</label>
                                    <input type="text" class="form-control" id="number-of-tables" name="NumberOfTables"
                                        placeholder="Nhập số lượng mâm" value="1" onchange="updateTotalForCombo()">
                                </div>
                                <div class="mb-3 col-md-4">
                                    <label for="combo-extra" class="form-label">Gọi thêm đồ</label>
                                    <input type="text" class="form-control extra" id="combo-extra" name="Extra"
                                        placeholder="Nhập số tiền gọi thêm đồ" onchange="updateTotalForCombo()"
                                        value="0">
                                </div>
                                <div class="mb-3 col-md-4">
                                    <label for="combo-prepaid" class="form-label">Đặt cọc trước</label>
                                    <input type="text" class="form-control prepaid" id="combo-prepaid" name="Prepaid"
                                        placeholder="Nhập số tiền đặt cọc trước" value="0">
                                </div>
                            </div>
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
            document.querySelector('#combo-dish-form').addEventListener('submit', function(event) {
                var dishIdList = arrayDishId;
                var duplicateDishId = hasDuplicates(dishIdList);

                if (duplicateDishId) {
                    event.preventDefault();
                    alert(
                        "Bạn đã chọn cùng một món nhiều lần. Vui lòng chọn những món khác nhau."
                    );
                }

                if (dishIdList.length === 0) {
                    event.preventDefault();
                    alert('Vui lòng thêm ít nhất một món.');
                }
            });

            function hasDuplicates(array) {
                return (new Set(array)).size !== array.length;
            }

            document.querySelector('#combo-dish-form input[name="Date"]').addEventListener('change', function() {
                updateMenuId();
            });

            function clearDishRows() {
                const dishRows = document.querySelectorAll('#combo-products-container .row');
                dishRows.forEach(row => {
                    row.remove();
                });
                document.getElementById('number-of-tables').value = '1';
                document.getElementById('combo-total').value = '0';
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
                                        <select class="form-select dish-select dish" id="dish_${index}"
                                            name="dishes[${index}][id]"
                                            onchange="updateDishSelected(),updateArrayPriceForCombo(),updateDishID()">
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
                                            onchange="updateArrayQuantityForCombo(),updateTotalForCombo()">
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
                clearDishRows();
            }

        })

        let selectedDishes = [];
        let arrayDishId = [];
        let arrayPriceCombo = [];
        let arrayQuantityCombo = [];
        let arraySubTotalCombo = [];

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
                if (dishId !== '') {
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
            document.querySelectorAll('#combo-dish-form .price').forEach((item) => {
                arrayPriceCombo.push(parseFloat(item.value) || 0);
            });
            console.log('Đơn giá (combo): ', arrayPriceCombo);
            updateSubTotalForCombo();
        }

        function updateArrayQuantityForCombo() {
            arrayQuantityCombo = [];
            document.querySelectorAll('#combo-dish-form .quantity').forEach((item) => {
                arrayQuantityCombo.push(parseInt(item.value) || 0);
            });
            console.log('Số lượng (combo): ', arrayQuantityCombo);
            updateSubTotalForCombo();
        }

        function updateSubTotalForCombo() {
            arraySubTotalCombo = arrayPriceCombo.map((price, index) => price * arrayQuantityCombo[index]);
            console.log('Tổng (combo): ', arraySubTotalCombo);

            document.querySelectorAll('#combo-dish-form .subtotal').forEach((item, index) => {
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

            document.querySelectorAll('#combo-dish-form .subtotal').forEach((subtotalInput) => {
                const subtotal = parseFloat(subtotalInput.value) || 0;
                total += subtotal;
            });

            const extra = parseFloat(document.getElementById('combo-extra').value) || 0;
            total += extra;

            const numberOfTables = parseFloat(document.querySelector('input[name="NumberOfTables"]').value) || 1;

            total *= numberOfTables;

            document.getElementById('combo-total').value = total;

            console.log('Tổng giá trị:', total);
        }

        function removeDish(index) {
            $(`#dish_${index}`).closest('.row').remove();
            updateDishSelected();
            updateDishID();
            updateArrayPriceForCombo();
            updateArrayQuantityForCombo();
            updateTotalForCombo();
        }
    </script>
@endsection
