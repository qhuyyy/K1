@extends('base')

@section('title', 'Thông tin nhân viên')

@section('main')
    <section class="slide-section pt-3">
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
                                    <a href="{{ route('employees.show', $employee->id) }}"><img
                                            src="{{ URL('images/ShowIcon.svg') }}" alt="Show Icon"></a>
                                    <a href="{{ route('employees.edit', $employee->id) }}"><img
                                            src="{{ URL('images/EditIcon.svg') }}" alt="Edit Icon"></a>
                                    <a href="{{ route('employees.destroy', $employee->id) }}" data-bs-toggle="modal"
                                        data-bs-target="#{{ $employee->id }}">
                                        <img src="{{ URL('images/DeleteIcon.svg') }}" alt="Delete Icon">
                                    </a>
                                </div>
                                <div class="modal fade" id="{{ $employee->id }}" tabindex="-1"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="exampleModalLabel">Xóa thông tin nhân viên
                                                </h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                Bạn có chắc chắn muốn xóa nhân viên này không?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Hủy</button>
                                                <form method="POST"
                                                    action="{{ route('employees.destroy', $employee->id) }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-primary"
                                                        data-bs-dismiss="modal">Xác
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
@endsection
