<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Thông tin nhân viên</title>
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
    <section class="slide-section pt-5">
        <div class="text-center pb-2">
            <h2>Danh sách nhân viên đang làm việc tại nhà ăn</h2>
        </div>
        <div class="container">
            <table class="table table-striped m-2" style="border: 2px solid; border-radius: 10px">
                <thead>
                    <tr>
                        <th scope="col">STT</th>
                        <th scope="col">Họ tên</th>
                        <th scope="col">Ngày sinh</th>
                        <th scope="col">CCCD</th>
                        <th scope="col">Số điện thoại</th>
                        <th scope="col">Vị trí</th>
                        <th scope="col">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($employees as $employee)
                        <tr>
                            <td>{{ $employee->id }}</td>
                            <td>{{ $employee->Name }}</td>
                            <td>{{ date('d-m-Y', strtotime($employee->DateOfBirth)) }}</td>
                            <td>{{ $employee->CICN }}</td>
                            <td>{{ $employee->PhoneNumber }}</td>
                            <td>{{ $employee->position->PositionName }}</td>
                            <td>
                                <div class="mx-3">
                                    <a href="{{ route('employees.show', $employee->id) }}"><svg xmlns="http://www.w3.org/2000/svg"
                                        width="16" height="16" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                                        <path
                                            d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13 13 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5s3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5s-3.879-1.168-5.168-2.457A13 13 0 0 1 1.172 8z" />
                                        <path
                                            d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0" />
                                    </svg></a>
                                <a href="{{ route('employees.edit', $employee->id) }}"><svg xmlns="http://www.w3.org/2000/svg"
                                        width="16" height="16" fill="currentColor" class="bi bi-pencil"
                                        viewBox="0 0 16 16">
                                        <path
                                            d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325" />
                                    </svg></a>
                                <a href="{{ route('employees.destroy', $employee->id) }}" data-bs-toggle="modal"
                                    data-bs-target="#{{ $employee->id }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                        class="bi bi-trash2" viewBox="0 0 16 16">
                                        <path
                                            d="M14 3a.7.7 0 0 1-.037.225l-1.684 10.104A2 2 0 0 1 10.305 15H5.694a2 2 0 0 1-1.973-1.671L2.037 3.225A.7.7 0 0 1 2 3c0-1.105 2.686-2 6-2s6 .895 6 2M3.215 4.207l1.493 8.957a1 1 0 0 0 .986.836h4.612a1 1 0 0 0 .986-.836l1.493-8.957C11.69 4.689 9.954 5 8 5s-3.69-.311-4.785-.793" />
                                    </svg>
                                </a>
                                </div>
                                <div class="modal fade" id="{{ $employee->id }}" tabindex="-1"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="exampleModalLabel">Xóa thông tin nhân viên</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                Bạn có chắc chắn muốn xóa nhân viên này không?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Hủy</button>
                                                <form method="POST" action="{{ route('employees.destroy', $employee->id) }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-primary" data-bs-dismiss="modal">Xác
                                                        nhận</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                            </td>
                            
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="container text-center pt-2">
            <a href="{{ route('employees.create') }}" class="btn btn-primary">Thêm mới nhân viên</a>
        </div>
    </section>
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
</body>

</html>
