@extends('base')

@section('title','Chỉnh sửa thông tin nguyên liệu ')
    
@section('main')
    <section class="slide-section">
        <div class="container border rounded border-secondary">
            <div class="container text-center pt-2">
                <h2>Chỉnh sửa thông tin nguyên liệu</h2>
            </div>
            <form method="POST" action="{{ route('ingredients.update', $ingredient) }}">
                @csrf
                @method('PUT')
                <div class="row justify-content-center mx-auto" style="width:80%">
                    <div class="mb-3">
                        <label for="formGroupExampleInput" class="form-label">STT</label>
                        <input type="text" readonly class="form-control" id="formGroupExampleInput" name="id"
                            value="{{ $ingredient->id }}" title="Không thể chỉnh sửa STT">
                    </div>
                    <div class="mb-3">
                        <label for="formGroupExampleInput2" class="form-label">Tên nguyên liệu</label>
                        <input type="text" class="form-control" id="formGroupExampleInput2" name="IngredientName"
                            value="{{ $ingredient->IngredientName }}" placeholder="Nhập tên nguyên liệu">
                    </div>
                    <div class="mb-3">
                        <label for="formGroupExampleInput2" class="form-label">Đơn giá</label>
                        <input type="text" class="form-control" id="formGroupExampleInput2" name="Price"
                            value="{{ $ingredient->Price }}" placeholder="Nhập đơn giá">
                    </div>
                    <div class="mb-3">
                        <label for="unit" class="form-label">Đơn vị tính</label>
                        <select class="form-select" id="unit" onchange="updateUnitId()">
                            <option value="">Chọn loại thực phẩm</option>
                            @foreach ($units as $unit)
                                <option value="{{ $unit->id }}" data-unit-id="{{ $unit->id }}"
                                    @if ($ingredient->unit->UnitName == $unit->UnitName) selected @endif>{{ $unit->UnitName }}
                                </option>
                            @endforeach
                        </select>
                        <input type="hidden" id="unit_id" name="Unit_ID"
                            value="{{ $unit->Unit_ID }}">
                    </div>
                </div>
                <div class="container d-flex justify-content-center align-items-center">
                    <div class="text-center pb-2 mx-2">
                        <a href="{{ route('ingredients.index') }}" class="btn btn-warning"> Quay lại</a>
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
        window.onload = function() {
            updateUnitId();
        };
        function updateUnitId() {
            var select = document.getElementById("unit");
            var UnitIdInput = document.getElementById("unit_id");
            var selectedOption = select.options[select.selectedIndex];
            var unitID = selectedOption.getAttribute("data-unit-id");
            UnitIdInput.value = unitID;
        }
    </script>
    
@endsection


    
