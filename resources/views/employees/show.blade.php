@extends('base')

@section('title','Chi tiết thông tin nhân viên')
    
@section('main')
    <section class="slide-section">
        <div class="container border rounded border-secondary">
            <div class="container text-center pt-2">
                <h2>Chi tiết thông tin nhân viên</h2>
            </div>
            <div class="container">
                <div class="row justify-content-center mx-auto" style="width:80%">
                    <div class="mb-3">
                        <label for="formGroupExampleInput" class="form-label">STT</label>
                        <input type="text" readonly class="form-control" id="formGroupExampleInput"
                            name="id" value="{{ $employee->id }}">
                    </div>
                    <div class="mb-3">
                        <label for="formGroupExampleInput2" class="form-label">Họ tên</label>
                        <input type="text" readonly class="form-control" id="formGroupExampleInput2"
                            name="Name" value="{{ $employee->Name }}">
                    </div>
                    <div class="mb-3">
                        <label for="formGroupExampleInput" class="form-label">Ngày sinh</label>
                        <input type="date" readonly class="form-control" id="formGroupExampleInput"
                            name="DateOfBirth" value="{{ $employee->DateOfBirth }}">
                    </div>
                    <div class="mb-3">
                        <label for="formGroupExampleInput2" class="form-label">CCCD</label>
                        <input type="text" readonly class="form-control" id="formGroupExampleInput2"
                            name="CICN" value="{{ $employee->CICN }}">
                    </div>
                    <div class="mb-3">
                        <label for="formGroupExampleInput2" class="form-label">Số điện thoại</label>
                        <input type="text" readonly class="form-control" id="formGroupExampleInput2"
                            name="PhoneNumber" value="{{ $employee->PhoneNumber }}">
                    </div>
                    <div class="mb-3">
                        <label for="formGroupExampleInput2" class="form-label">Vị trí công việc</label>
                        <input type="text" readonly class="form-control" id="formGroupExampleInput2"
                            value="{{ $employee->position->PositionName }}">
                    </div>
                </div>
                <div class="text-center pb-2">
                    <a href="{{ route('employees.index') }}" class="btn btn-primary"> Quay lại</a>
                </div>    
            </div>
        </div>
    </section>
@endsection
    

