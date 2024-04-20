@extends('base')

@section('title','Chi tiết thực phẩm được nhập')
    
@section('main')
<section class="slide-section">
    <div class="container border rounded border-secondary">
        <div class="container text-center pt-2">
            <h2>Chi tiết thông tin thực phẩm</h2>
        </div>
        <div class="container">
                <div class="row justify-content-center mx-auto" style="width:80%">
                    <div class="mb-3">
                        <label for="formGroupExampleInput" class="form-label">STT</label>
                        <input type="text" readonly class="form-control" id="formGroupExampleInput"
                            name="id" value="{{ $received_food->id }}">
                    </div>
                    <div class="mb-3">
                        <label for="formGroupExampleInput2" class="form-label">Ngày</label>
                        <input type="text" readonly class="form-control" id="formGroupExampleInput2"
                            name="Date" value="{{ $received_food->Date }}">
                    </div>
                    <div class="mb-3">
                        <label for="formGroupExampleInput2" class="form-label">Loại thực phẩm</label>
                        <input type="text" readonly class="form-control" id="formGroupExampleInput2"
                            value="{{ $received_food->food_type->FoodTypeName }}">
                    </div>
                    <div class="mb-3">
                        <label for="formGroupExampleInput" class="form-label">Tên thực phẩm</label>
                        <input type="text" readonly class="form-control" id="formGroupExampleInput"
                            name="FoodName" value="{{ $received_food->FoodName }}">
                    </div>
                    <div class="mb-3">
                        <label for="formGroupExampleInput2" class="form-label">Đơn vị tính</label>
                        <input type="text" readonly class="form-control" id="formGroupExampleInput2"
                            value="{{ $received_food->unit->UnitName }}">
                    </div>
                    <div class="mb-3">
                        <label for="formGroupExampleInput2" class="form-label">Đơn giá</label>
                        <input type="text" readonly class="form-control" id="formGroupExampleInput2"
                            name="UnitPrice" value="{{ $received_food->UnitPrice }}">
                    </div>
                    <div class="mb-3">
                        <label for="formGroupExampleInput2" class="form-label">Số lượng</label>
                        <input type="text" readonly class="form-control" id="formGroupExampleInput2"
                            name="Quantity" value="{{ $received_food->Quantity }}">
                    </div><div class="mb-3">
                        <label for="formGroupExampleInput2" class="form-label">Tổng tiền</label>
                        <input type="text" readonly class="form-control" id="formGroupExampleInput2"
                            name="Total" value="{{ $received_food->Total }}">
                    </div>
                    <div class="mb-3">
                        <label for="formGroupExampleInput2" class="form-label">Ghi chú</label>
                        <input type="text" readonly class="form-control" id="formGroupExampleInput2"
                            name="Note" value="{{ $received_food->Note }}">
                    </div>
                </div>
                <div class="text-center pb-2">
                    <a href="{{ route('receivedfood.index') }}" class="btn btn-primary"> Quay lại</a>
                </div>
        </div>
    </div>
</section>
@endsection