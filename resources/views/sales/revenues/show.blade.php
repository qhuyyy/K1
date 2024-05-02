@extends('base')

@section('title','Chi tiết thông tin doanh thu')
    
@section('main')
<section class="slide-section">
    <div class="container border rounded border-secondary">
        <div class="container text-center pt-2">
            <h2>Chi tiết thông tin doanh thu</h2>
        </div>
        <div class="container">
                <div class="row justify-content-center mx-auto" style="width:80%">
                    <div class="mb-3">
                        <label for="formGroupExampleInput" class="form-label">STT</label>
                        <input type="text" readonly class="form-control" id="formGroupExampleInput"
                            name="id" value="{{ $revenue->id }}">
                    </div>
                    <div class="mb-3">
                        <label for="formGroupExampleInput2" class="form-label">Ngày</label>
                        <input type="text" readonly class="form-control" id="formGroupExampleInput2"
                            name="Date" value="{{ $revenue->Date }}">
                    </div>
                    <div class="mb-3">
                        <label for="formGroupExampleInput" class="form-label">Tiền cơm trưa</label>
                        <input type="text" readonly class="form-control" id="formGroupExampleInput"
                            name="Lunch" value="{{ $revenue->Lunch }}">
                    </div>
                    <div class="mb-3">
                        <label for="formGroupExampleInput" class="form-label">Tiền cơm tối</label>
                        <input type="text" readonly class="form-control" id="formGroupExampleInput"
                            name="Dinner" value="{{ $revenue->Dinner }}">
                    </div>
                    <div class="mb-3">
                        <label for="formGroupExampleInput" class="form-label">Tiền bán đồ ăn nhanh</label>
                        <input type="text" readonly class="form-control" id="formGroupExampleInput"
                            name="FastFood" value="{{ $revenue->FastFood }}">
                    </div>
                    <div class="mb-3">
                        <label for="formGroupExampleInput" class="form-label">Tiền chuyển khoản</label>
                        <input type="text" readonly class="form-control" id="formGroupExampleInput"
                            name="BankTransfer" value="{{ $revenue->BankTransfer }}">
                    </div>
                    <div class="mb-3">
                        <label for="formGroupExampleInput" class="form-label">Tổng cộng</label>
                        <input type="text" readonly class="form-control" id="formGroupExampleInput"
                            name="Total" value="{{ $revenue->Total }}">
                    </div>
                </div>
                <div class="text-center pb-2">
                    <a href="{{ route('revenues.index') }}" class="btn btn-warning"> Quay lại</a>
                </div>
        </div>
    </div>
</section>
@endsection
    

