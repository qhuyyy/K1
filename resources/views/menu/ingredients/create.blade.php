@extends('base')

@section('title','Thêm nguyên liệu mới')
    
@section('main')
    <section class="slide-section">
        <div class="container border rounded border-secondary">
            <div class="container text-center pt-2">
                <h2>Thêm mới nguyên liệu</h2>
            </div>
            <div class="container">
                <form class="" method="POST" action="{{ route('ingredients.store') }}">
                    @csrf
                    <div class="row justify-content-center mx-auto" style="width:80%">
                        <div class="mb-3">
                            <label for="formGroupExampleInput" class="form-label">STT</label>
                            <input type="text" readonly class="form-control" id="formGroupExampleInput"
                                name="id" value="" placeholder="STT tự động tăng (không cần nhập)">
                        </div>
                        <div class="mb-3">
                            <label for="formGroupExampleInput2" class="form-label">Tên nguyên liệu</label>
                            <input type="text" class="form-control" id="formGroupExampleInput2" name="IngredientName"
                                value="" placeholder="Nhập tên nguyên liệu">
                        </div>
                        <div class="mb-3">
                            <label for="formGroupExampleInput2" class="form-label">Đơn giá</label>
                            <input type="text" class="form-control" id="formGroupExampleInput2" name="Price"
                                value="" placeholder="Nhập đơn giá">
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
                    </div>
                    <div class="container d-flex justify-content-center align-items-center">
                        <div class="text-center pb-2 mx-2">
                            <button type="button" onclick="goBack()" class="btn btn-warning">Quay lại</button>
                        </div>
                        <div class="text-center pb-2 mx-2">
                            <button type=submit class="btn btn-warning">Thêm mới</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
    
@endsection

@section('script')
    <script>
        function goBack() {
            window.history.back();
        }
        function updateUnitId() {
            var select = document.getElementById("unit");
            var UnitIdInput = document.getElementById("unit_id");
            var selectedOption = select.options[select.selectedIndex];
            var unitID = selectedOption.getAttribute("data-unit-id");
            UnitIdInput.value = unitID;
        }
    </script>
@endsection