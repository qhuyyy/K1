@extends('base')

@section('title', 'Danh sách loại món ăn')

@section('main')
    <section class="slide-section">
        <div class="container">
            <div class="text-center pb-2">
                <h2>Các loại món ăn hiện có tại nhà ăn</h2>
            </div>
            <div class="container">
                <table class="table table-striped m-2" style="border: 2px solid; border-radius: 10px">
                    <thead>
                        <tr>
                            <th scope="col">STT</th>
                            <th scope="col">Tên loại món ăn</th>
                            <th scope="col">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($dishtypes as $dishtype)
                            <tr>
                                <td>{{ $dishtype->id }}</td>
                                <td>{{ $dishtype->DishTypeName }}</td>
                                <td>
                                    <div class="mx-3">
                                        <a href="{{ route('dishtypes.show', $dishtype->id) }}"><img
                                                src="{{ URL('images/ShowIcon.svg') }}" alt="Show Icon"></a>
                                        <a href="{{ route('dishtypes.edit', $dishtype->id) }}"><img
                                                src="{{ URL('images/EditIcon.svg') }}" alt="Show Icon"></a>
                                        <a href="{{ route('dishtypes.destroy', $dishtype->id) }}" data-bs-toggle="modal"
                                            data-bs-target="#{{ $dishtype->id }}">
                                            <img src="{{ URL('images/DeleteIcon.svg') }}" alt="Delete Icon">
                                        </a>
                                    </div>
                                </td>
                                <div class="modal fade" id="{{ $dishtype->id }}" tabindex="-1"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="exampleModalLabel">Xóa
                                                    thông tin loại món ăn</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                Bạn có chắc chắn muốn xóa loại món ăn này không?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Hủy</button>
                                                <form method="POST"
                                                    action="{{ route('dishtypes.destroy', $dishtype->id) }}">
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
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="container text-center pt-2">
                <a href="{{ route('dishes.index') }}" class="btn btn-primary">Quản lý món ăn</a>
                <a href="{{ route('dishtypes.create') }}" class="btn btn-primary">Thêm mới loại món ăn</a>
            </div>
        </div>
    </section>
@endsection
