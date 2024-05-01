@extends('base')

@section('title', 'Thêm thực đơn mới')
    
@section('main')
    <section class="slide-section">
        <div class="container border rounded border-secondary">
            <div class="container text-center pt-2">
                <h2>Thêm mới thực đơn</h2>
            </div>
            <div class="container">
                <form class="" method="POST" action="{{ route('dailymenus.store') }}">
                    @csrf
                    <div class="row justify-content-center mx-auto" style="width:80%">
                        <div class="mb-3">
                            <label for="formGroupExampleInput" class="form-label">STT</label>
                            <input type="text" readonly class="form-control" id="formGroupExampleInput"
                                name="id" value="" placeholder="STT tự động tăng (không cần nhập)">
                        </div>
                        <div class="mb-3">
                            <label for="formGroupExampleInput2" class="form-label">Ngày</label>
                            <input type="date" class="form-control" id="formGroupExampleInput2" name="Date"
                                   value="{{ date('Y-m-d') }}" placeholder="Nhập ngày">
                        </div>
                        <div class="mb-3">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="NumberOfTotalPortions" class="form-label">Số lượng suất ăn dự kiến</label>
                                    <input type="text" class="form-control" id="NumberOfTotalPortions"
                                           name="NumberOfTotalPortions" value="" placeholder="Nhập số lượng suất ăn">
                                </div>
                                <div class="col-md-6">
                                    <label for="TotalFoodCost" class="form-label">Tổng số tiền mua thực phẩm dự kiến</label>
                                    <input type="text" class="form-control" id="TotalFoodCost"
                                           name="TotalFoodCost" value="" placeholder="Nhập số lượng suất ăn" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            @for ($i = 1; $i <= 10; $i++)
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="dish{{ $i }}" class="form-label">Món {{ $i }}</label>
                                            <select class="form-select" id="dish_select{{ $i }}" onchange="updateDishId('dish_select{{ $i }}', 'dish_id{{ $i }}', {{ $i }})">
                                                <option value="">Chọn món ăn</option>
                                                @foreach ($dishes as $dish)
                                                    <option value="{{ $dish->id }}" data-dish-id="{{ $dish->id }}"
                                                        @for($j = 1; $j <= 5; $j++)
                                                            data-ingredient-id-{{ $j }}="{{ $dish->{'Ingredient'.$j.'_ID'} }}"
                                                        @endfor
                                                    >{{ $dish->DishName }}</option>
                                                @endforeach
                                            </select>
                                            <input type="hidden" id="dish_id{{ $i }}" name="Dish{{ $i }}_ID">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="NumberOfPortions{{ $i }}" class="form-label">Số lượng suất ăn cho món {{$i}}</label>
                                            <input type="text" class="form-control" id="NumberOfPortions{{ $i }}"
                                                name="NumberOfPortions{{ $i }}" value="" placeholder="Nhập số lượng suất ăn">
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    @for($j = 1; $j <= 5; $j++)
                                        <div>
                                            <label for="ingredient_id_display{{ $i }}_{{ $j }}" class="form-label">Nguyên liệu {{ $j }}</label>
                                            <input type="text" id="ingredient_id_display{{ $i }}_{{ $j }}" readonly>
                                        </div>
                                    @endfor
                                </div>
                            @endfor      
                        </div>
                    </div>
                    <div class="container d-flex justify-content-center align-items-center pt-2">
                        <div class="text-center pb-2 mx-2">
                            <a href="{{ route('dailymenus.index') }}" class="btn btn-warning" style="width:98.89px">
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
        function updateDishId(selectId, inputId, index) {
            var select = document.getElementById(selectId);
            var dishIdInput = document.getElementById(inputId);
            
            dishIdInput.value = select.value;

            for (var j = 1; j <= 5; j++) {
                var ingredientDisplayId = "ingredient_id_display" + index + "_" + j;
                var ingredientId = select.options[select.selectedIndex].getAttribute("data-ingredient-id-" + j);
                
                if (ingredientId !== null) {
                    document.getElementById(ingredientDisplayId).value = ingredientId;
                } else {
                    // Nếu không có ingredientId, gán giá trị mặc định
                    document.getElementById(ingredientDisplayId).value = "";
                }
            }
        }
        
        var numberOfPortionsInput = document.getElementById("NumberOfTotalPortions");
            numberOfPortionsInput.addEventListener("input", function() {
            var numberOfPortions = parseInt(numberOfPortionsInput.value);
            if (!isNaN(numberOfPortions)) {
                var totalPrice = numberOfPortions * 25000 * 0.4;
                document.getElementById("TotalFoodCost").value = totalPrice.toLocaleString('vi-VN', { style: 'currency', currency: 'VND' });
            } else {
                document.getElementById("TotalFoodCost").value = "";
            }
        });


    </script>
@endsection
