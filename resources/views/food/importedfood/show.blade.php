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
                            name="id" value="{{ $imported_food->id }}">
                    </div>
                    <div class="mb-3">
                        <label for="formGroupExampleInput2" class="form-label">Ngày</label>
                        <input type="text" readonly class="form-control" id="formGroupExampleInput2"
                            name="Date" value="{{ $imported_food->Date }}">
                    </div>
                    <div class="mb-3">
                        <label for="formGroupExampleInput2" class="form-label">Loại thực phẩm</label>
                        <input type="text" readonly class="form-control" id="formGroupExampleInput2"
                            value="{{ $imported_food->food_type->FoodTypeName }}">
                    </div>
                    <div class="mb-3">
                        <label for="formGroupExampleInput" class="form-label">Tên thực phẩm</label>
                        <input type="text" readonly class="form-control" id="formGroupExampleInput"
                            name="FoodName" value="{{ $imported_food->FoodName }}">
                    </div>
                    <div class="mb-3">
                        <label for="formGroupExampleInput2" class="form-label">Đơn vị tính</label>
                        <input type="text" readonly class="form-control" id="formGroupExampleInput2"
                            value="{{ $imported_food->unit->UnitName }}">
                    </div>
                    <div class="mb-3">
                        <label for="formGroupExampleInput2" class="form-label">Đơn giá</label>
                        <input type="text" readonly class="form-control" id="formGroupExampleInput2"
                            name="UnitPrice" value="{{ $imported_food->UnitPrice }}">
                    </div>
                    <div class="mb-3">
                        <label for="formGroupExampleInput2" class="form-label">Số lượng</label>
                        <input type="text" readonly class="form-control" id="formGroupExampleInput2"
                            name="Quantity" value="{{ $imported_food->Quantity }}">
                    </div><div class="mb-3">
                        <label for="formGroupExampleInput2" class="form-label">Tổng tiền</label>
                        <input type="text" readonly class="form-control" id="formGroupExampleInput2"
                            name="Total" value="{{ $imported_food->Total }}">
                    </div>
                    <div class="mb-3">
                        <label for="formGroupExampleInput2" class="form-label">Ghi chú</label>
                        <input type="text" readonly class="form-control" id="formGroupExampleInput2"
                            name="Note" value="{{ $imported_food->Note }}">
                    </div>
                </div>
                <div class="text-center pb-2">
                    <a href="{{ route('importedfood.index') }}" class="btn btn-warning"> Quay lại</a>
                </div>
        </div>
    </div>
</section>
@endsection