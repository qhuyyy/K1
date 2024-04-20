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
    <title>@yield('title')</title>
</head>
<body>
    <header>
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
                                <li><a class="dropdown-item" href="{{ route('receivedfood.index') }}">Quản lý nhập hàng</a></li>
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
    </header>
    <main>
        @yield('main')
    </main>
    <footer>

    </footer>
    @yield('script')
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>