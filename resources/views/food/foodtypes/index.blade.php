@extends('base')

@section('title', 'Danh sách loại thực phẩm')

@section('main')
    <section class="slide-section">
        <div class="container">
            <div class="text-center pb-2">
                <h2>Các loại thực phẩm hiện có tại nhà ăn</h2>
            </div>
            <div class="container">
                <table class="table table-striped m-2" style="border: 2px solid; border-radius: 10px">
                    <thead>
                        <tr>
                            <th scope="col">STT</th>
                            <th scope="col">Tên loại thực phẩm</th>
                            <th scope="col">Mô tả</th>
                            <th scope="col">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($foodtypes as $foodtype)
                            <tr>
                                <td>{{ $foodtype->id }}</td>
                                <td>{{ $foodtype->FoodTypeName }}</td>
                                <td>{{ $foodtype->Description }}</td>
                                <td>
                                    <div class="mx-3">
                                        <a href="{{ route('foodtypes.show', $foodtype->id) }}"><img
                                                src="{{ URL('images/ShowIcon.svg') }}" alt="Show Icon"></a>
                                        <a href="{{ route('foodtypes.edit', $foodtype->id) }}"><img
                                                src="{{ URL('images/EditIcon.svg') }}" alt="Show Icon"></a>
                                        <a href="{{ route('foodtypes.destroy', $foodtype->id) }}" data-bs-toggle="modal"
                                            data-bs-target="#{{ $foodtype->id }}">
                                            <img src="{{ URL('images/DeleteIcon.svg') }}" alt="Delete Icon">
                                        </a>
                                    </div>
                                    <div class="modal fade" id="{{ $foodtype->id }}" tabindex="-1"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Xóa
                                                        thông tin loại thực phẩm</h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    Bạn có chắc chắn muốn xóa loại thực phẩm này không?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Hủy</button>
                                                    <form method="POST"
                                                        action="{{ route('foodtypes.destroy', $foodtype->id) }}">
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
                <a href="{{ route('importedfood.index') }}" class="btn btn-warning">Quản lý thực phẩm</a>
                <a href="{{ route('foodtypes.create') }}" class="btn btn-warning">Thêm mới loại thực phẩm</a>
            </div>
        </div>
    </section>
@endsection
