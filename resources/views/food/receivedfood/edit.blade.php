@extends('base')

@section('title','Chỉnh sửa thông tin thực phẩm')
    
@section('main')
<section class="slide-section">
    <div class="container border rounded border-secondary">
        <div class="container text-center pt-2">
            <h2>Chỉnh sửa thông tin thực phẩm</h2>
        </div>
        <form method="POST" action="{{ route('receivedfood.update', $received_food) }}">
            @csrf
            @method('PUT')
            <div class="row justify-content-center mx-auto" style="width:80%">
                <div class="mb-3">
                    <label for="formGroupExampleInput" class="form-label">STT</label>
                    <input type="text" readonly class="form-control" id="formGroupExampleInput" name="id"
                        value="{{ $received_food->id }}" title="Không thể chỉnh sửa STT">
                </div>
                <div class="mb-3">
                    <label for="formGroupExampleInput2" class="form-label">Ngày</label>
                    <input type="date" class="form-control" id="formGroupExampleInput2" name="Date"
                        value="{{ $received_food->Date }}" placeholder="Chọn ngày">
                </div>
                <div class="mb-3">
                    <label for="foodtype" class="form-label">Loại thực phẩm</label>
                    <select class="form-select" id="foodtype" onchange="updateFoodTypeId()">
                        <option value="">Chọn loại thực phẩm</option>
                        @foreach ($foodtypes as $foodtype)
                            <option value="{{ $foodtype->id }}" data-foodtype-id="{{ $foodtype->id }}"
                                @if ($received_food->food_type->FoodTypeName == $foodtype->FoodTypeName) selected @endif>{{ $foodtype->FoodTypeName }}
                            </option>
                        @endforeach
                    </select>
                    <input type="hidden" id="foodtype_id" name="FoodType_ID"
                        value="{{ $foodtype->FoodType_ID }}">
                </div>
                <div class="mb-3">
                    <label for="formGroupExampleInput2" class="form-label">Tên thực phẩm</label>
                    <input type="text" class="form-control" id="formGroupExampleInput2" name="FoodName"
                        value="{{ $received_food->FoodName }}" placeholder="Nhập tên thực phẩm">
                </div>
                <div class="mb-3">
                    <label for="unit" class="form-label">Đơn vị tính</label>
                    <select class="form-select" id="unit" onchange="updateUnitId()">
                        <option value="">Chọn loại thực phẩm</option>
                        @foreach ($units as $unit)
                            <option value="{{ $unit->id }}" data-unit-id="{{ $unit->id }}"
                                @if ($received_food->unit->UnitName == $unit->UnitName) selected @endif>{{ $unit->UnitName }}
                            </option>
                        @endforeach
                    </select>
                    <input type="hidden" id="unit_id" name="Unit_ID"
                        value="{{ $unit->Unit_ID }}">
                </div>
                <div class="mb-3">
                    <label for="formGroupExampleInput3" class="form-label">Đơn giá</label>
                    <input type="text" class="form-control" id="formGroupExampleInput3" name="UnitPrice"
                        value="{{ $received_food->UnitPrice }}" placeholder="Nhập đơn giá" oninput="calculateTotal()">
                </div>
                <div class="mb-3">
                    <label for="formGroupExampleInput4" class="form-label">Số lượng</label>
                    <input type="text" class="form-control" id="formGroupExampleInput4" name="Quantity"
                        value="{{ $received_food->Quantity }}" placeholder="Nhập số lượng" oninput="calculateTotal()">
                </div>
                <div class="mb-3">
                    <label for="totalPrice" class="form-label">Tổng tiền</label>
                    <input type="text" class="form-control" id="totalPrice" name="Total" value="{{ $received_food->Total }}"
                        placeholder="Tổng tiền sẽ tự động cập nhật" readonly>
                </div>
                <div class="mb-3">
                    <label for="formGroupExampleInput2" class="form-label">Ghi chú</label>
                    <input type="text" class="form-control" id="formGroupExampleInput2" name="Note"
                        value="{{ $received_food->Note }}" placeholder="Nhập ghi chú">
                </div>
            </div>
            <div class="container d-flex justify-content-center align-items-center">
                <div class="text-center pb-2 mx-2">
                    <a href="{{ route('receivedfood.index') }}" class="btn btn-primary" style="width:98.89px"> Quay lại</a>
                </div>
                <div class="text-center pb-2 mx-2">
                    <button type=submit class="btn btn-primary">Cập nhật</button>
                </div>
            </div>
        </form>
    </div>
    </div>
</section>
@endsection

@section('script')
<script>
    document.addEventListener("DOMContentLoaded", function() {
    // Gọi hàm updateFoodTypeId() khi trang web được tải lần đầu tiên
    updateFoodTypeId();
    });
    document.addEventListener("DOMContentLoaded", function() {
    // Gọi hàm updateFoodTypeId() khi trang web được tải lần đầu tiên
    updateUnitId();
});
    function updateFoodTypeId() {
        var select = document.getElementById("foodtype");
        var FoodTypeIdInput = document.getElementById("foodtype_id");
        var selectedOption = select.options[select.selectedIndex];
        var foodtypeID = selectedOption.getAttribute("data-foodtype-id");
        FoodTypeIdInput.value = foodtypeID;
    }
    function updateUnitId() {
        var select = document.getElementById("unit");
        var UnitIdInput = document.getElementById("unit_id");
        var selectedOption = select.options[select.selectedIndex];
        var unitID = selectedOption.getAttribute("data-unit-id");
        UnitIdInput.value = unitID;
    }
    function calculateTotal() {
    var unitPrice = parseFloat(document.getElementById('formGroupExampleInput3').value);
    var quantity = parseFloat(document.getElementById('formGroupExampleInput4').value);

    var totalPrice = unitPrice * quantity;
    document.getElementById('totalPrice').value = totalPrice;
}
</script>
@endsection