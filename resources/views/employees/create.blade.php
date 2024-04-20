@extends('base')

@section('title','Thêm nhân viên mới')
    
@section('main')
<section class="slide-section">
    <div class="container border rounded border-secondary">
        <div class="container text-center pt-2">
            <h2>Thêm mới nhân viên</h2>
        </div>
        <div class="container">
            <form class="" method="POST" action="{{ route('employees.store') }}">
                @csrf
                <div class="row justify-content-center mx-auto" style="width:80%">
                    <div class="mb-3">
                        <label for="formGroupExampleInput" class="form-label">STT</label>
                        <input type="text" readonly class="form-control" id="formGroupExampleInput"
                            name="id" value="" placeholder="STT tự động tăng (không cần nhập)">
                    </div>
                    <div class="mb-3">
                        <label for="formGroupExampleInput2" class="form-label">Họ tên</label>
                        <input type="text" class="form-control" id="formGroupExampleInput2" name="Name"
                            value="" placeholder="Nhập họ tên đầy đủ của nhân viên">
                    </div>
                    <div class="mb-3">
                        <label for="formGroupExampleInput" class="form-label">Ngày sinh</label>
                        <input type="date" class="form-control" id="formGroupExampleInput" name="DateOfBirth"
                            value="" placeholder="Nhập ngày tháng năm sinh">
                    </div>
                    <div class="mb-3">
                        <label for="formGroupExampleInput2" class="form-label">CCCD</label>
                        <input type="text" class="form-control" id="formGroupExampleInput2" name="CICN"
                            value="" placeholder="Nhập số căn cước công dân" pattern="[0-9]+"
                            title="Chỉ cho phép nhập số">
                    </div>
                    <div class="mb-3">
                        <label for="formGroupExampleInput2" class="form-label">Số điện thoại</label>
                        <input type="text" class="form-control" id="formGroupExampleInput2"
                            name="PhoneNumber" value="" placeholder="Nhập số điện thoại" pattern="[0-9]+"
                            title="Chỉ cho phép nhập số">
                    </div>
                    <div class="mb-3">
                        <label for="position" class="form-label">Vị trí công việc</label>
                        <select class="form-select" id="position" onchange="updatePositionId()">
                            <option value="">Chọn vị trí công việc</option>
                            @foreach ($positions as $position)
                                <option value="{{ $position->id }}" data-position-id="{{ $position->id }}">{{ $position->PositionName }}</option>
                            @endforeach
                        </select>
                        <input type="hidden" id="position_id" name="Position_ID">
                    </div>
                </div>
                <div class="container d-flex justify-content-center align-items-center">
                    <div class="text-center pb-2 mx-2">
                        <a href="{{ route('employees.index') }}" class="btn btn-primary" style="width:98.89px">
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
    function updatePositionId() {
        var select = document.getElementById("position");
        var positionIdInput = document.getElementById("position_id");
        var selectedOption = select.options[select.selectedIndex];
        var positionId = selectedOption.getAttribute("data-position-id");
        positionIdInput.value = positionId;
    }
</script>
@endsection
    

