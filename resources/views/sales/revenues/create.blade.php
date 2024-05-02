@extends('base')

@section('title','Thêm doanh thu mới')
    
@section('main')
<section class="slide-section">
    <div class="container border rounded border-secondary">
        <div class="container text-center pt-2">
            <h2>Thêm mới doanh thu</h2>
        </div>
        <div class="container">
            <form class="" method="POST" action="{{ route('revenues.store')}}">
                @csrf
                <div class="row justify-content-center mx-auto" style="width:80%">
                    <div class="mb-3">
                        <label for="formGroupExampleInput" class="form-label">STT</label>
                        <input type="text" readonly class="form-control" id="formGroupExampleInput" name="id" value="" placeholder="STT tự động tăng (không cần nhập)">
                    </div>
                    <div class="mb-3">
                        <label for="formGroupExampleInput2" class="form-label">Date</label>
                        <input type="date" class="form-control" id="formGroupExampleInput2" name="Date" value="" placeholder="Chọn ngày">
                    </div>
                    <div class="mb-3">
                        <label for="formGroupExampleInput" class="form-label">Tiền cơm trưa</label>
                        <input type="text" class="form-control" id="lunchInput" name="Lunch" value="" placeholder="Nhập tiền bán cơm trưa">
                    </div>
                    <div class="mb-3">
                        <label for="formGroupExampleInput" class="form-label">Tiền cơm tối</label>
                        <input type="text" class="form-control" id="dinnerInput" name="Dinner" value="" placeholder="Nhập tiền bán cơm tối">
                    </div>
                    <div class="mb-3">
                        <label for="formGroupExampleInput" class="form-label">Tiền bán đồ ăn nhanh</label>
                        <input type="text" class="form-control" id="fastFoodInput" name="FastFood" value="" placeholder="Nhập tiền bán đồ ăn nhanh">
                    </div>
                    <div class="mb-3">
                        <label for="formGroupExampleInput" class="form-label">Tiền chuyển khoản</label>
                        <input type="text" class="form-control" id="bankTransferInput" name="BankTransfer" value="" placeholder="Nhập tiền được thanh toán bằng chuyển khoản">
                    </div>
                    <div class="mb-3">
                        <label for="formGroupExampleInput" class="form-label">Tổng cộng</label>
                        <input type="text" class="form-control" id="totalInput" name="Total" value="" placeholder="Tổng được tự động cập nhật" readonly>
                    </div>
                </div> 
                <div class="container d-flex justify-content-center align-items-center">
                    <div class="text-center pb-2 mx-2">
                        <a href="{{ route('revenues.index') }}" class="btn btn-warning" style="width:98.89px"> Quay lại</a>
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
        // Lấy các ô nhập liệu
        var lunchInput = document.getElementById('lunchInput');
        var dinnerInput = document.getElementById('dinnerInput');
        var fastFoodInput = document.getElementById('fastFoodInput');
        var bankTransferInput = document.getElementById('bankTransferInput');
        var totalInput = document.getElementById('totalInput');

        // Lưu trữ giá trị tổng trước đó
        var previousTotal = 0;

        // Theo dõi sự kiện input và cập nhật tổng tự động
        lunchInput.addEventListener('input', updateTotal);
        dinnerInput.addEventListener('input', updateTotal);
        fastFoodInput.addEventListener('input', updateTotal);
        bankTransferInput.addEventListener('input', updateTotal);

        function updateTotal() {
            // Lấy giá trị từ các ô nhập liệu
            var lunch = parseFloat(lunchInput.value) || 0;
            var dinner = parseFloat(dinnerInput.value) || 0;
            var fastFood = parseFloat(fastFoodInput.value) || 0;
            var bankTransfer = parseFloat(bankTransferInput.value) || 0;

            // Tính tổng mới
            var total = lunch + dinner + fastFood + bankTransfer;

            // Cập nhật giá trị tổng và hiển thị trên ô input tổng cộng
            totalInput.value = total;

            // Lưu giá trị tổng mới vào biến previousTotal
            previousTotal = total;
        }
    </script>
@endsection