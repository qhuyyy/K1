@extends('base')

@section('title', 'Chi tiết thông tin thực đơn')

@section('main')
    <section class="slide-section">
        <div class="container border rounded border-secondary">
            <div class="container text-center pt-2">
                <h2>Chi tiết thông tin thực đơn</h2>
            </div>
            <div class="container">
                <div class="row justify-content-center mx-auto" style="width:80%">
                    <div class="mb-3">
                        <label for="formGroupExampleInput" class="form-label">STT</label>
                        <input type="text" readonly class="form-control" id="formGroupExampleInput" name="id"
                            value="{{ $menu->id }}">
                    </div>
                    <div class="mb-3">
                        <label for="formGroupExampleInput2" class="form-label">Tên món ăn</label>
                        <input type="text" readonly class="form-control" id="formGroupExampleInput2" name="Date"
                            value="{{ $menu->Date }}">
                    </div>
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="NumberOfTotalPortions" class="form-label">Số lượng suất ăn dự kiến</label>
                                <input type="text" class="form-control" id="NumberOfTotalPortions"
                                    name="NumberOfTotalPortions" value="{{ $menu->NumberOfTotalPortions }}"
                                    placeholder="Nhập số lượng suất ăn" readonly>
                            </div>
                            <div class="col-md-4">
                                <label for="TotalFoodCost" class="form-label">Tổng số tiền tối đa thực phẩm dự kiến</label>
                                <input type="text" class="form-control" id="TotalFoodCost" name="TotalFoodCost"
                                    value="{{ $menu->NumberOfTotalPortions * 25000 * 0.4 }}" readonly>
                            </div>
                            <div class="col-md-4">
                                <label for="totalFoodPurchase" class="form-label">Tổng số tiền mua thực phẩm hiện
                                    tại</label>
                                <input type="text" class="form-control" id="totalFoodPurchase" readonly>
                            </div>
                        </div>
                    </div>
                    @foreach ($menu->dishes as $index => $dish)
                        <div class="mb-3">
                            <div class="row mb-3">
                                <div class="col-md-5">
                                    <label for="dish_{{ $index }}" class="form-label h5">Món ăn</label>
                                    <input type="text" readonly class="form-control" id="dish_{{ $index }}"
                                        value="{{ $dish->DishName }}">
                                </div>
                                <div class="col-md-2">
                                    <label for="numberofportions_{{ $index }}" class="form-label">Số lượng
                                        suất</label>
                                    <input class="form-control soluong" type="text"
                                        id="numberofportions_{{ $index }}"
                                        value="{{ $dish->pivot->NumberOfPortions }}" readonly>
                                </div>
                                @php
                                    $totalEstimatedValue = 0;
                                    foreach ($dish->ingredients as $ingredient) {
                                        $totalEstimatedValue += $ingredient->Price * $ingredient->pivot->Amount;
                                    }
                                    $totalPrice = $totalEstimatedValue * $dish->pivot->NumberOfPortions / 10;
                                @endphp
                                <div class="col-md-2">
                                    <label for="price_{{ $index }}" class="form-label">Giá trị ước tính</label>
                                    <input class="form-control giatriuoctinh" type="text" id="price_{{ $index }}"
                                        value="{{ $totalEstimatedValue }}" readonly>
                                </div>
                                <div class="col-md-3">
                                    <label for="totalEstimatedValue_{{ $index }}" class="form-label">Tổng tiền
                                    </label>
                                    <input class="form-control ketqua" type="text"
                                        id="totalEstimatedValue_{{ $index }}"
                                        value="{{ $totalPrice }}" readonly>
                                </div>
                            </div>
                            @foreach ($dish->ingredients as $ingredient)
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label for="ingredient-list" class="form-label">Nguyên liệu tương ứng</label>
                                        <input class="form-control" type="text"
                                            value="{{ $ingredient->IngredientName }}" readonly>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="ingredient-list" class="form-label">Đơn giá</label>
                                        <input class="form-control" type="text" value="{{ $ingredient->Price }}"
                                            readonly>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="ingredient-list" class="form-label">Định lượng cho 10 suất</label>
                                        <input class="form-control" type="text" value="{{ $ingredient->pivot->Amount !== null ? $ingredient->pivot->Amount : 0 }}" readonly>
                                    </div>
                                    <div class="col-md-2">
                                        <label for="ingredient-list" class="form-label">Tổng cộng</label>
                                        <input class="form-control" type="text"
                                            value="{{ $ingredient->Price * $ingredient->pivot->Amount }}" readonly>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="text-center pb-2">
                <a href="{{ route('menus.index') }}" class="btn btn-warning"> Quay lại</a>
            </div>
        </div>
    </section>
@endsection

@section('script')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Lấy giá trị hiện tại của số lượng suất ăn
            var numberOfPortionsInput = document.getElementById('NumberOfTotalPortions');
            var numberOfPortions = numberOfPortionsInput.value;

            // Nếu có giá trị hợp lệ trong số lượng suất ăn, tính toán và hiển thị tổng số tiền tối đa dự kiến
            if (!isNaN(numberOfPortions) && numberOfPortions.trim() !== '') {
                var totalFoodCost = numberOfPortions * 25000 * 0.4;
                var totalFoodCostInput = document.getElementById('TotalFoodCost');
                totalFoodCostInput.value = totalFoodCost.toLocaleString('vi-VN', {
                    style: 'currency',
                    currency: 'VND'
                });
            }
        });
        var totalFoodPurchaseInput = document.getElementById('totalFoodPurchase');
        var totalPriceInputs = document.querySelectorAll('.ketqua');

        var totalFoodPurchase = 0;
        totalPriceInputs.forEach(function(input) {
            totalFoodPurchase += parseFloat(input.value.replace(/\D/g, ''));
        });

        totalFoodPurchaseInput.value = totalFoodPurchase.toLocaleString('vi-VN', {
            style: 'currency',
            currency: 'VND'
        });
    
    </script>
@endsection