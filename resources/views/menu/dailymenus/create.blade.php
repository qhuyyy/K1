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
                                value="" placeholder="Nhập ngày">
                        </div>
                        <div class="mb-3">
                            <label for="formGroupExampleInput" class="form-label">Số lượng suất ăn</label>
                            <input type="text" class="form-control" id="formGroupExampleInput"
                                name="NumberOfPortions" value="" placeholder="Nhập số lượng suất ăn">
                        </div>
                        @for ($i = 1; $i <= 10; $i++)
                            <div class="mb-3">
                                <label for="dish{{ $i }}" class="form-label">Món {{ $i }}</label>
                                <select class="form-select" id="dish{{ $i }}" onchange="updateDishId('dish{{ $i }}', 'dish_id{{ $i }}')">
                                    <option value="">Chọn món ăn</option>
                                    @foreach ($dishes as $dish)
                                        <option value="{{ $dish->id }}" data-dish-id="{{ $dish->id }}">{{ $dish->DishName }}</option>
                                    @endforeach
                                </select>
                                <input type="hidden" id="dish_id{{ $i }}" name="Dish{{ $i }}_ID">
                            </div>
                        @endfor
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
        function updateDishId(selectId, inputId) {
            var select = document.getElementById(selectId);
            var dishIdInput = document.getElementById(inputId);
            var selectedOption = select.options[select.selectedIndex];
            var dishId = selectedOption.getAttribute("data-dish-id");
            dishIdInput.value = dishId;
        }
    </script>
@endsection
