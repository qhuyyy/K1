@extends('base')

@section('title','Danh sách nguyên liệu')
    
@section('main')
    <section class="slide-section pt-3">
        <div class="container text-center">
            <ul class="nav nav-tabs justify-content-center">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('menus.index') }}">Quản lý thực đơn</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('dishes.index') }}">Quản lý món ăn</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="{{ route('dishtypes.index') }}">Quản lý loại món ăn</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="{{ route('ingredients.index') }}">Quản lý nguyên liệu</a>
                </li>
            </ul>    
        </div> 
        <div class="text-center pb-2 pt-2">
            <h2>Danh sách nguyên liệu</h2>
        </div>
        <div class="container">
            <table class="table table-striped m-2" style="border: 2px solid; border-radius: 10px">
                <thead>
                    <tr>
                        <th scope="col">STT</th>
                        <th scope="col">Tên nguyên liệu</th>
                        <th scope="col">Đơn giá</th>
                        <th scope="col">Đơn vị tính</th>
                        <th scope="col">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($ingredients as $ingredient)
                        <tr>
                            <td>{{ $ingredient->id }}</td>
                            <td>{{ $ingredient->IngredientName }}</td>
                            <td>{{ number_format($ingredient->Price, 0, ',', '.') }}</td>
                            <td>{{ $ingredient->unit->UnitName}}</td>
                            <td>
                                <div class="mx-3">
                                    <a href="{{ route('ingredients.show', $ingredient->id) }}"><img
                                            src="{{ URL('images/ShowIcon.svg') }}" alt="Show Icon"></a>
                                    <a href="{{ route('ingredients.edit', $ingredient->id) }}"><img
                                            src="{{ URL('images/EditIcon.svg') }}" alt="Edit Icon"></a>
                                    <a href="{{ route('ingredients.destroy', $ingredient->id) }}" data-bs-toggle="modal"
                                        data-bs-target="#{{ $ingredient->id }}">
                                        <img src="{{ URL('images/DeleteIcon.svg') }}" alt="Delete Icon">
                                    </a>
                                </div>
                                <div class="modal fade" id="{{ $ingredient->id }}" tabindex="-1"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="exampleModalLabel">Xóa thông tin nguyên liệu
                                                </h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                Bạn có chắc chắn muốn xóa nguyên liệu này không?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Hủy</button>
                                                <form method="POST"
                                                    action="{{ route('ingredients.destroy', $ingredient->id) }}">
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
        <div class="container text-center pt-2 pb-2">
            <a href="{{route('ingredients.create')}}" class="btn btn-warning">Thêm mới nguyên liệu</a>
        </div>
    </section>
    
@endsection

