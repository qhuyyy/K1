@extends('base')

@section('title', 'Thêm thực đơn mới')

@section('main')
    <section class="slide-section">
        <div class="container border rounded border-secondary">
            <div class="container text-center pt-2">
                <h2>Thêm mới thực đơn</h2>
            </div>
            <div class="container">
                <form class="" method="POST" action="{{ route('menus.store') }}">
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
                                value="{{ date('Y-m-d') }}" placeholder="Nhập ngày" {{ request()->date ? request()->date : date('Y-m-d') }}>
                        </div>
                        <div class="mb-3">
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="NumberOfTotalPortions" class="form-label">Số lượng suất ăn dự kiến</label>
                                    <input type="text" class="form-control" id="NumberOfTotalPortions"
                                        name="NumberOfTotalPortions" value="" placeholder="Nhập số lượng suất ăn">
                                </div>
                                <div class="col-md-4">
                                    <label for="TotalFoodCost" class="form-label">Tổng số tiền mua thực phẩm tối đa</label>
                                    <input type="text" class="form-control" id="TotalFoodCost" name="TotalFoodCost"
                                        value="" placeholder="Nhập số lượng suất ăn" readonly>
                                </div>
                                <div class="col-md-4">
                                    <label for="totalFoodPurchase" class="form-label">Tổng số tiền mua thực phẩm hiện tại</label>
                                    <input type="text" class="form-control" id="totalFoodPurchase" readonly>
                                </div>
                            </div>
                        </div>
                        <div id="dishes-container">
                            <div class="mb-3">

                            </div>
                        </div>
                        <div class="row d-flex justify-content-center align-items-center pt-2 text-center">
                            <div class="col-md-3">
                                <button type="button" id="add-dish" class="btn btn-info">Thêm món</button>
                            </div>
                        </div>
                    </div>
                    <div class="container d-flex justify-content-center align-items-center pt-2">
                        <div class="text-center pb-2 mx-2">
                            <a href="{{ route('menus.index') }}" class="btn btn-warning">
                                Quay lại</a>
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
        let valueTotal = 0;

        let arrayUocTinh = [];
        function updateArray(){
            arrayUocTinh = [];
            document.querySelectorAll('.giatriuoctinh').forEach((item)=>{
                arrayUocTinh.push(item.value);
            })
        }

        let arraySoLuong = [];
        function updateSoLuong(){
            valueTotal = 0;
            arraySoLuong = [];
            document.querySelectorAll('.soluong').forEach((item)=>{
                arraySoLuong.push(item.value);
                
            })
            
            const arrayTotal = arrayUocTinh.map((value, index) => Number(value) / 10 * Number(arraySoLuong[index]));          
            document.querySelectorAll('.ketqua').forEach((item,i)=>{
                item.value = !isNaN(arrayTotal[i]) ? arrayTotal[i] : '';
                valueTotal += Number(item.value);
            })
            console.log('Tổng tiền',valueTotal);
            document.getElementById('totalFoodPurchase').value = valueTotal.toLocaleString('vi-VN', {
                style: 'currency',
                currency: 'VND'
            });
        }


        
        var dishes = {!! json_encode($dishes) !!};
        var ingredients = {!! json_encode($ingredients) !!};

        document.getElementById('NumberOfTotalPortions').addEventListener('input', function() {
            var numberOfPortions = this.value;
            var totalFoodCostInput = document.getElementById('TotalFoodCost');
            var foodCostPerPortion = 25000 * 0.4;

            if (!isNaN(numberOfPortions) && numberOfPortions.trim() !== '') {
                var totalFoodCost = numberOfPortions * foodCostPerPortion;
                totalFoodCostInput.value = totalFoodCost.toLocaleString('vi-VN', {
                    style: 'currency',
                    currency: 'VND'
                });
            } else {
                totalFoodCostInput.value = '';
            }
        });

        document.getElementById('add-dish').addEventListener('click', function() {

            var container = document.getElementById('dishes-container');
            var index = container.getElementsByClassName('mb-3').length;
            var div = document.createElement('div');
            div.classList.add('mb-3');
            div.innerHTML = `
            <div class="row">
                <div class="col-md-11">
                    <div class="row">
                        <div class="col-md-5">
                            <label for="dish_${index}" class="form-label h5">Món ăn</label>
                            <select class="form-select" id="dish_${index}" name="dishes[${index}][id]" onchange="getIngredients(${index})">
                                <option value="">- Chọn món ăn -</option>
                                @foreach ($dishes as $dish)
                                    <option value="{{ $dish->id }}">{{ $dish->DishName }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="numberofportions_${index}" class="form-label">Số lượng suất</label>
                            <input class="form-control soluong" type="text" name="dishes[${index}][numberOfPortions]" id="numberofportions_${index}" onchange="updateSoLuong()">
                        </div>   
                        <div class="col-md-2">
                            <label for="price_${index}" class="form-label">Giá trị ước tính</label>
                            <input class="form-control giatriuoctinh" type="text" id="price_${index}" name="dishes[${index}][price]" readonly>
                        </div>
                        <div class="col-md-3">
                            <label for="totalEstimatedValue_${index}" class="form-label">Tổng tiền </label>
                            <input class="form-control ketqua" type="text" id="totalEstimatedValue_${index}" name="dishes[${index}][totalEstimatedValue]" readonly>
                        </div>
                    </div>
                    <div class="row">
                        <div id="ingredient-list_${index}"></div>
                    </div>
                </div>
                <div class="col-md-1 d-flex align-items-start justify-content-start" style="margin-top: 2.3rem;">
                    <button type="button" class="btn btn-danger" onclick="removeDish(${index})">Xóa</button>
                </div>
            </div>
            `;

            container.appendChild(div);
            createNewIngredientList(index);
            
            updateArray();
            console.log(arrayUocTinh);
            const array = [];
        });         
        

        function removeDish(index) {
            var dishToRemove = document.getElementById('dish_' + index).closest('.mb-3');
            dishToRemove.parentNode.removeChild(dishToRemove);

            // Xóa cả danh sách nguyên liệu của món ăn
            var ingredientList = document.getElementById('ingredient-list_' + index);
            if (ingredientList) {
                ingredientList.parentNode.removeChild(ingredientList);
            }
        }

        function createNewIngredientList(index) {
            var ingredientListDiv = document.createElement('div');
            ingredientListDiv.id = 'ingredient-list_' + index;
            var dishesContainer = document.getElementById('dishes-container');
            dishesContainer.appendChild(ingredientListDiv);

        }

        function getIngredients(index) {
            var select = document.getElementById('dish_' + index);
            var dishId = select.value;
            var dish = {!! json_encode($dishes->toArray()) !!}.find(dish => dish.id == dishId);

            var ingredientInputs = '';
            var totalEstimatedValue = 0;

            dish.ingredients.forEach(function(ingredient) {
                var ingredientInfo = getIngredientInfo(ingredient.id);
                var amount = getAmount(dishId, ingredient.id);
                var ingredientTotal = ingredientInfo.price * amount;
                totalEstimatedValue += ingredientTotal;

                ingredientInputs +=
                    '<div class="row mb-3">' +
                    '<div class="col-md-4">' +
                    '<label for="ingredient-list" class="form-label">Nguyên liệu tương ứng</label>' +
                    '<input class="form-control" type="text" value="' + ingredientInfo.name + '" readonly>' +
                    '</div>' +
                    '<div class="col-md-3">' +
                    '<label for="ingredient-list" class="form-label">Đơn giá</label>' +
                    '<input class="form-control" type="text" value="' + ingredientInfo.price + '" readonly>' +
                    '</div>' +
                    '<div class="col-md-3">' +
                    '<label for="ingredient-list" class="form-label">Định lượng cho 10 suất</label>' +
                    '<input class="form-control" type="text" value="' + amount + '" readonly>' +
                    '</div>' +
                    '<div class="col-md-2">' +
                    '<label for="ingredient-list" class="form-label">Tổng cộng</label>' +
                    '<input class="form-control" type="text" value="' + ingredientTotal.toLocaleString('vi-VN', {
                        style: 'currency',
                        currency: 'VND'
                    }) + '" readonly>' +
                    '</div>' +
                    '</div>';
            });

            // Hiển thị thông tin nguyên liệu trong danh sách
            document.getElementById('ingredient-list_' + index).innerHTML = ingredientInputs;

            // Hiển thị tổng giá trị ước tính của món
            document.getElementById('price_' + index).value = totalEstimatedValue;
            var GiaTriUocTinh = totalEstimatedValue;

            updateArray();
            updateSoLuong();
            console.log(arrayUocTinh);
        }

        function getIngredientInfo(ingredientId) {
            var ingredients = {!! json_encode($ingredients->toArray()) !!};
            var ingredient = ingredients.find(function(item) {
                return item.id == ingredientId;
            });

            return ingredient ? {
                name: ingredient.IngredientName,
                price: ingredient.Price
            } : {
                name: 'Không có',
                price: '0'
            };
        }

        function getAmount(dishId, ingredientId) {
            var dishIngredients = {!! json_encode($dishIngredients->toArray()) !!};
            var dishIngredient = dishIngredients.find(function(item) {
                return item.Dish_ID == dishId && item.Ingredient_ID == ingredientId;
            });

            return dishIngredient && dishIngredient.Amount !== null ? dishIngredient.Amount : 'chưa nhập giá trị';
        }

        document.querySelector('form').addEventListener('submit', function(event) {
            // Ngăn chặn hành động mặc định của sự kiện submit
            event.preventDefault();

            // Lấy tổng số tiền mua hiện tại và số tiền dự kiến từ các input
            var totalFoodPurchaseInput = document.getElementById('totalFoodPurchase');
            var totalFoodPurchase = parseFloat(totalFoodPurchaseInput.value.replace(/\D/g, ''));
            var totalFoodCostInput = document.getElementById('TotalFoodCost');
            var totalFoodCost = parseFloat(totalFoodCostInput.value.replace(/\D/g, ''));

            // So sánh tổng số tiền mua hiện tại với số tiền dự kiến
            if (totalFoodPurchase > totalFoodCost) {
                // Nếu tổng số tiền mua hiện tại lớn hơn số tiền dự kiến, thông báo cho người dùng và không submit form
                alert('Tổng số tiền mua thực phẩm vượt quá số tiền dự kiến. Vui lòng kiểm tra lại!');
            } else {
                // Nếu không, cho phép submit form
                event.target.submit();
            }
        });

        // Lấy URL hiện tại
        var currentUrl = window.location.href;
        // Tách phần sau cùng của URL, chứa ngày
        var parts = currentUrl.split('/');
        var date = parts[parts.length - 1]; 

        document.getElementById("formGroupExampleInput2").value = date;
    </script>
@endsection
