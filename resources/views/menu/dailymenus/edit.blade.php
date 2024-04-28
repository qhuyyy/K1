@extends('base')

@section('title','Chỉnh sửa thông tin thực đơn')
    
@section('main')
    <section class="slide-section">
        <div class="container border rounded border-secondary">
            <div class="container text-center pt-2">
                <h2>Chỉnh sửa thông tin thực đơn</h2>
            </div>
            <form method="POST" action="{{ route('dailymenus.update', $dailymenu) }}">
                @csrf
                @method('PUT')
                <div class="row justify-content-center mx-auto" style="width:80%">
                    <div class="mb-3">
                        <label for="formGroupExampleInput" class="form-label">STT</label>
                        <input type="text" readonly class="form-control" id="formGroupExampleInput" name="id"
                            value="{{ $dailymenu->id }}" title="Không thể chỉnh sửa STT">
                    </div>
                    <div class="mb-3">
                        <label for="formGroupExampleInput2" class="form-label">Ngày</label>
                        <input type="date" class="form-control" id="formGroupExampleInput2" name="Date"
                            value="{{ $dailymenu->Date }}">
                    </div>
                    <div class="mb-3">
                        <label for="formGroupExampleInput" class="form-label">Số lượng suất ăn</label>
                        <input type="text" class="form-control" id="formGroupExampleInput" name="NumberOfPortions"
                            value="{{ $dailymenu->NumberOfPortions }}" placeholder="Nhập số lượng suất ăn">
                    </div>
                    @for ($i = 1; $i <= 10; $i++)
                        <div class="mb-3">
                            <label for="dish{{ $i }}" class="form-label">Món {{ $i }}</label>
                            <select class="form-select" id="dish{{ $i }}" onchange="updateDishId('dish{{ $i }}', 'dish_id{{ $i }}')">
                                <option value="">Chọn món ăn</option>
                                @foreach ($dishes as $dish)
                                    <option value="{{ $dish->id }}" data-dish-id="{{ $dish->id }}" {{ $dailymenu->{'Dish'.$i.'_ID'} == $dish->id ? 'selected' : '' }}>
                                        {{ $dish->DishName }}
                                    </option>
                                @endforeach
                            </select>
                            <input type="hidden" id="dish_id{{ $i }}" name="Dish{{ $i }}_ID" value="{{ $dailymenu->{'Dish'.$i.'_ID'} }}">
                        </div>
                    @endfor    
                </div>
                <div class="container d-flex justify-content-center align-items-center pt-2">
                    <div class="text-center pb-2 mx-2">
                        <a href="{{ route('dailymenus.index') }}" class="btn btn-warning" style="width:98.89px"> Quay lại</a>
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
        function updateDishId(selectId, inputId) {
            var select = document.getElementById(selectId);
            var dishIdInput = document.getElementById(inputId);
            var selectedOption = select.options[select.selectedIndex];
            var dishId = selectedOption.getAttribute("data-dish-id");
            dishIdInput.value = dishId;
        }
    </script>
@endsection
    
