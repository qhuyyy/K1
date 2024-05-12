@extends('base')

@section('title', 'Danh sách các loại sản phẩm')

@section('main')
    <section class="slide-section pt-3">
        <div class="container text-center">
            <ul class="nav nav-tabs justify-content-center">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('bills.index') }}">Quản lý đơn bán hàng</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('products.index') }}">Quản lý sản phẩm</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="{{ route('producttypes.index') }}">Quản lý loại sản phẩm</a>
                </li>
            </ul>    
        </div> 
        <div class="text-center pb-2">
            <h2>Danh sách các loại sản phẩm</h2>
        </div>
        <div class="container">
            <table class="table table-striped m-2" style="border: 2px solid; border-radius: 10px">
                <thead>
                    <tr>
                        <th scope="col">STT</th>
                        <th scope="col">Tên loại sản phẩm</th>
                        <th scope="col">Ghi chú</th>
                        <th scope="col">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($producttypes as $producttype)
                        <tr>
                            <td>{{ $producttype->id }}</td>
                            <td>{{ $producttype->ProductTypeName }}</td>
                            <td>{{ $producttype->Note ?? 'Chưa có' }}</td>
                            <td>
                                <div>
                                    <a href="{{ route('producttypes.show', $producttype->id) }}"><img
                                            src="{{ URL('images/ShowIcon.svg') }}" alt="Show Icon"></a>
                                    <a href="{{ route('producttypes.edit', $producttype->id) }}"><img
                                            src="{{ URL('images/EditIcon.svg') }}" alt="Edit Icon"></a>
                                    <a href="{{ route('producttypes.destroy', $producttype->id) }}" data-bs-toggle="modal"
                                        data-bs-target="#{{ $producttype->id }}">
                                        <img src="{{ URL('images/DeleteIcon.svg') }}" alt="Delete Icon">
                                    </a>
                                </div>           
                            </td>
                        </tr>
                        <div class="modal fade" id="{{ $producttype->id }}" tabindex="-1"
                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Xóa thông tin loại sản phẩm
                                        </h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        Bạn có chắc chắn muốn xóa loại sản phẩm này không?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Hủy</button>
                                        <form method="POST"
                                            action="{{ route('producttypes.destroy', $producttype->id) }}">
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
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="container text-center pt-2">
            <a href="{{ route('producttypes.create') }}" class="btn btn-warning">Thêm mới loại sản phẩm</a>
        </div>
    </section>
@endsection
