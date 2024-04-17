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
    <title>Chi tiết thông tin loại thực phẩm</title>
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
                <h2>Chi tiết thông tin loại thực phẩm</h2>
            </div>
            <div class="container">
                    <div class="row justify-content-center mx-auto" style="width:80%">
                        <div class="mb-3">
                            <label for="formGroupExampleInput" class="form-label">STT</label>
                            <input type="text" readonly class="form-control" id="formGroupExampleInput"
                                name="id" value="{{ $foodtype->id }}">
                        </div>
                        <div class="mb-3">
                            <label for="formGroupExampleInput2" class="form-label">Tên loại thực phẩm</label>
                            <input type="text" readonly class="form-control" id="formGroupExampleInput2"
                                name="FoodTypeName" value="{{ $foodtype->FoodTypeName }}">
                        </div>
                        <div class="mb-3">
                            <label for="formGroupExampleInput" class="form-label">Mô tả</label>
                            <input type="text" readonly class="form-control" id="formGroupExampleInput"
                                name="Description" value="{{ $foodtype->Description }}">
                        </div>
                    </div>
                    <div class="text-center pb-2">
                        <a href="{{ route('foodtypes.index') }}" class="btn btn-primary"> Quay lại</a>
                    </div>
            </div>
        </div>
    </section>
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
</body>

</html>
