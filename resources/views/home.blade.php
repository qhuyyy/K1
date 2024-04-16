<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@500&display=swap" rel="stylesheet">
    @vite(['resources/scss/main.scss'])
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
                            <li><a class="dropdown-item" href="#">Quản lý nhập hàng</a></li>
                            <li><a class="dropdown-item" href="employees">Quản lý nhân viên</a></li>
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
    <section class="p-7 slide-section">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-lg-8">
                    <h1 class="display-3 mb-5 fw-bold">
                        PHƯƠNG PHÁP QUẢN LÝ
                        <span class="d-block">ĐƠN GIẢN - HIỆU QUẢ</span>
                    </h1>
                    <div>
                        <p class="col-md-9 lh-lg fs-5 mb-5">
                            Chào mừng bạn đến với trang chủ của chúng tôi! Chúng tôi cung cấp giải pháp quản lý
                            nhà ăn tiện lợi và hiệu quả, giúp bạn tối ưu hóa doanh thu và nâng cao sự hài lòng của khách
                            hàng.
                        </p>
                    </div>
                    <div class="d-flex flex-column flex-lg-row gap-2">
                        <a href="#" class="btn btn-primary btn-lg px-5 py-3 fw-bold" style="width:200px">Giới
                            thiệu</a>
                        <a href="#" class="btn btn-outline-primary btn-1 btn-lg px-5 py-3 fw-bold"
                            style="width:200px">Liên hệ</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
</body>

</html>
