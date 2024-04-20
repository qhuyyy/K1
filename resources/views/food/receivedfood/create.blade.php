@extends('base')

@section('title','Thêm mới thực phẩm')
    
@section('main')
<section class="slide-section">
    <div class="container border rounded border-secondary">
        <div class="container text-center pt-2">
            <h2>Thêm mới thực phẩm</h2>
        </div>
        <div class="container">
            <form class="" method="POST" action="{{ route('receivedfood.store') }}">
                @csrf
                <div class="row justify-content-center mx-auto" style="width:80%">
                    <div class="mb-3">
                        <label for="formGroupExampleInput2" class="form-label">Ngày</label>
                        <input type="date" class="form-control" id="formGroupExampleInput2" name="Date" 
                               value="<?php echo date('Y-m-d'); ?>" placeholder="Chọn ngày">
                    </div>
                    <div class="mb-3">
                        <label for="foodtype" class="form-label">Loại thực phẩm</label>
                        <select class="form-select" id="foodtype" onchange="updateFoodTypeId()">
                            <option value="">- Chọn loại thực phẩm -</option>
                            @foreach ($foodtypes as $foodtype)
                                <option value="{{ $foodtype->id }}" data-foodtype-id="{{ $foodtype->id }}">{{ $foodtype->FoodTypeName }}</option>
                            @endforeach
                        </select>
                        <input type="hidden" id="foodtype_id" name="FoodType_ID">
                    </div>
                    <div class="mb-3">
                        <label for="formGroupExampleInput" class="form-label">Tên thực phẩm</label>
                        <input type="text" class="form-control" id="formGroupExampleInput" name="FoodName"
                            value="" placeholder="Nhập tên thực phẩm">
                    </div>
                    <div class="mb-3">
                        <label for="unit" class="form-label">Đơn vị tính</label>
                        <select class="form-select" id="unit" onchange="updateUnitId()">
                            <option value="">- Chọn đơn vị tính -</option>
                            @foreach ($units as $unit)
                                <option value="{{ $unit->id }}" data-unit-id="{{ $unit->id }}">{{ $unit->UnitName }}</option>
                            @endforeach
                        </select>
                        <input type="hidden" id="unit_id" name="Unit_ID">
                    </div>
                    <div class="mb-3">
                        <label for="unitPrice" class="form-label">Đơn giá</label>
                        <input type="text" class="form-control" id="unitPrice" name="UnitPrice" value=""
                            placeholder="Nhập đơn giá" pattern="[0-9.]+" title="Chỉ cho phép nhập số và dấu chấm"
                            oninput="calculateTotal()">
                    </div>
                    <div class="mb-3">
                        <label for="quantity" class="form-label">Số lượng</label>
                        <input type="number" step="0.01" class="form-control" id="quantity" name="Quantity" value=""
                            placeholder="Nhập số lượng" pattern="[0-9]+(\.[0-9]+)?" title="Chỉ cho phép nhập số"
                            oninput="calculateTotal()">
                    </div>
                    <div class="mb-3">
                        <label for="totalPrice" class="form-label">Tổng tiền</label>
                        <input type="text" class="form-control" id="totalPrice" name="Total" value=""
                            placeholder="Tổng tiền sẽ tự động cập nhật" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="formGroupExampleInput" class="form-label">Ghi chú</label>
                        <input type="text" class="form-control" id="formGroupExampleInput" name="Note"
                               value="" placeholder="Thêm ghi chú">
                    </div>
                </div>
                <div class="container d-flex justify-content-center align-items-center">
                    <div class="text-center pb-2 mx-2">
                        <a href="{{ route('receivedfood.index') }}" class="btn btn-primary" style="width:98.89px">
                            Quay lại</a>
                    </div>
                    <div class="text-center pb-2 mx-2">
                        <button type=submit class="btn btn-primary">Thêm mới</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection

@section('script')
<script>
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
        var unitPrice = document.getElementById("unitPrice").value;
        var quantity = document.getElementById("quantity").value;
        var totalPrice = unitPrice * quantity;
        document.getElementById("totalPrice").value = totalPrice;
    }
</script>
@endsection