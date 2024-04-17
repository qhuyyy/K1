<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite(['resources/scss/main.scss'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@500&display=swap" rel="stylesheet">
    <title>Thêm mới nhân viên</title>
</head>
<body>
    <nav class="navbar navbar-expand-lg bg-transparent mb-4">
        <div class="container">
            <a class="navbar-brand" href="/">
                <img src="{{ URL('images/PrimaryLogo.svg') }}" alt="Logo K1" width="288px" height="50px" />
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup"
                aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNavAltMarkup">
                <div class="navbar-nav">
                    <a class="nav-link active" aria-current="page" href="/">Trang chủ</a>
                    <a class="nav-link" href="#">Hướng dẫn</a>
                    <li class="nav-item dropdown">
                        <a class="nav-link" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                            <span>Quản lý</span>
                            <img src="{{ URL('images/ArrowDown.svg') }}" alt="Logo K1" width="16px" height="16px"
                                style="background-image: none;" />
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Quản lý bán hàng</a></li>
                            <li><a class="dropdown-item" href="{{ route('foodtypes.index') }}">Quản lý nhập hàng</a></li>
                            <li><a class="dropdown-item" href="{{ route('employees.index') }}">Quản lý nhân viên</a></li>
                            <li><a class="dropdown-item" href="#">Quản lý thực đơn</a></li>
                        </ul>
                    </li>
                    <a class="btn btn-primary d-flex align-items-center gap-2">
                        <img src="{{ URL('images/LoginIcon.svg') }}" alt="Logo Login" width="18.75px"
                            height="18.75px" />
                        <span>Người dùng</span>
                    </a>
                </div>
            </div>
        </div>
    </nav>
    <section class="slide-section">
        <div class="container border rounded border-secondary">
            <div class="container text-center pt-2">
                <h2>Thêm mới nhân viên</h2>
            </div>
            <div class="container">
                <form class="" method="POST" action="{{ route('employees.store')}}">
                    @csrf
                    <div class="row justify-content-center mx-auto" style="width:80%">
                        <div class="mb-3">
                            <label for="formGroupExampleInput" class="form-label">STT</label>
                            <input type="text" readonly class="form-control" id="formGroupExampleInput" name="id" value="" placeholder="STT tự động tăng (không cần nhập)">
                        </div>
                        <div class="mb-3">
                            <label for="formGroupExampleInput2" class="form-label">Họ tên</label>
                            <input type="text" class="form-control" id="formGroupExampleInput2" name="Name" value="" placeholder="Nhập họ tên đầy đủ của nhân viên">
                        </div>
                        <div class="mb-3">
                            <label for="formGroupExampleInput" class="form-label">Ngày Sinh</label>
                            <input type="date" class="form-control" id="formGroupExampleInput" name="DateOfBirth" value="" placeholder="Nhập ngày tháng năm sinh">
                        </div>
                        <div class="mb-3">
                            <label for="formGroupExampleInput2" class="form-label">CCCD</label>
                            <input type="text" class="form-control" id="formGroupExampleInput2" name="CICN" value="" placeholder="Nhập số căn cước công dân" pattern="[0-9]+" title="Chỉ cho phép nhập số">
                        </div>
                        <div class="mb-3">
                            <label for="formGroupExampleInput2" class="form-label">Số điện thoại</label>
                            <input type="text" class="form-control" id="formGroupExampleInput2" name="PhoneNumber" value="" placeholder="Nhập số điện thoại" pattern="[0-9]+" title="Chỉ cho phép nhập số">
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
                            <a href="{{ route('employees.index') }}" class="btn btn-primary" style="width:98.89px"> Quay lại</a>
                        </div>
                        <div class="text-center pb-2 mx-2">
                            <button type=submit class="btn btn-primary">Thêm mới</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <script>
        function updatePositionId() {
            var select = document.getElementById("position");
            var positionIdInput = document.getElementById("position_id");
            var selectedOption = select.options[select.selectedIndex];
            var positionId = selectedOption.getAttribute("data-position-id");
            positionIdInput.value = positionId;
        }
    </script>
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>