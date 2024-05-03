@extends('base')

@section('title', 'Danh sách thực đơn')

@section('main')
    <section class="slide-section pt-3">   
        <div class="container text-center">
            <ul class="nav nav-tabs justify-content-center">
                <li class="nav-item">
                    <a class="nav-link active" href="{{ route('menus.index') }}">Quản lý thực đơn</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('dishes.index') }}">Quản lý món ăn</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="{{ route('dishtypes.index') }}">Quản lý loại món ăn</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('ingredients.index') }}">Quản lý nguyên liệu</a>
                </li>
            </ul>    
        </div> 
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <div class="mb-3">
                        <label for="date" class="form-label">Ngày</label>
                        <select class="form-select" name="date" id="date">
                            <option value="">Tất cả các ngày</option>
                            @foreach ($dates as $date)
                                <option value="{{ $date }}">{{ $date }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="text-center pb-2">
                <h2>Danh sách các thực đơn</h2>
            </div>
            <table class="table table-striped m-2" style="border: 2px solid; border-radius: 10px">
                <thead>
                    <tr>
                        <th scope="col">STT</th>
                        <th scope="col">Ngày</th>
                        <th scope="col">Số lượng suất ăn dự kiến</th>
                        <th scope="col">Các món ăn - Số lượng suất</th>
                        <th scope="col">Hành động</th>
                    </tr>
                </thead>
                <tbody id="t-body">
                    @foreach ($menus as $menu)
                        <tr>
                            <td>{{ $menu->id }}</td>
                            <td>{{ $menu->Date }}</td>
                            <td>{{ $menu->NumberOfTotalPortions }}</td>
                            <td>
                                <ul>
                                    @foreach($menu->dishes()->orderBy('DishName')->get() as $dish)
                                        <li>{{ $dish->DishName }} - {{ $dish->pivot->NumberOfPortions }}</li>
                                    @endforeach
                                </ul>       
                            </td>
                            <td>
                                <div class="mx-3">
                                    <a href="{{ route('menus.show', $menu->id) }}"><img src="{{ URL('images/ShowIcon.svg') }}"
                                            alt="Show Icon"></a>
                                    <a href="{{ route('menus.edit', $menu->id) }}"><img src="{{ URL('images/EditIcon.svg') }}"
                                            alt="Edit Icon"></a>
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $menu->id }}"><img
                                            src="{{ URL('images/DeleteIcon.svg') }}" alt="Delete Icon"></a>
                                </div>
                            </td>
                        </tr>
                        <div class="modal fade" id="deleteModal{{ $menu->id }}" tabindex="-1" aria-labelledby="deleteModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="deleteModalLabel">Xác nhận xóa thực đơn</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        Bạn có chắc chắn muốn xóa thực đơn này không?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                                        <form method="POST" action="{{ route('menus.destroy', $menu->id) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Xóa</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </tbody>
            </table>
            <div class="container text-center pt-2">
                <a href="#" id="add-menu-link" class="btn btn-warning">Thêm mới thực đơn</a>
            </div>
        </div>
    </section>
@endsection

@section('script')
    <script>
        $(document).ready(function(){
            $("#date").on('change', function(){
                var date = $(this).val();
                $.ajax({
                    url: "{{ route('filter.menus') }}",
                    type: "GET",
                    data: {'date': date},
                    success: function(data){
                        var menus = data.menus;
                        var html = '';
                        if (menus.length > 0) {
                            for (let i = 0; i < menus.length; i++){
                                var menu = menus[i];
                                var dishesHtml = '<ul>';
                                for (let j = 0; j < menu.dishes.length; j++) {
                                    dishesHtml += '<li>' + menu.dishes[j].DishName + ' - ' + menu.dishes[j].pivot.NumberOfPortions + '</li>';
                                }
                                dishesHtml += '</ul>';
                                html += '<tr>\
                                            <td>' + menu.id + '</td>\
                                            <td>' + menu.Date + '</td>\
                                            <td>' + menu.NumberOfTotalPortions + '</td>\
                                            <td>' + dishesHtml + '</td>\
                                            <td>\
                                                <a href="/menus/' + menu.id + '"><img src="{{ URL('images/ShowIcon.svg') }}" alt="Show Icon"></a>\
                                                <a href="/menus/' + menu.id + '/edit"><img src="{{ URL('images/EditIcon.svg') }}" alt="Edit Icon"></a>\
                                                <a href="#" data-bs-toggle="modal" data-bs-target="#deleteModal' + menu.id + '"><img src="{{ URL('images/DeleteIcon.svg') }}" alt="Delete Icon"></a>\
                                            </td>\
                                        </tr>';
                            }
                        } else {
                            html += '<tr>\
                                        <td colspan="5">Không tìm thấy thực đơn nào</td>\
                                    </tr>';
                        }
                        $("#t-body").html(html);
                    }
                });
            });

            $("#add-menu-link").on('click', function() {
                var date = $("#date").val();
                
                if (!date) {
                    window.location.href = "{{ route('menus.createWithoutParams') }}";
                }
                else {
                    var url = "{{ route('menus.create', ['date' => ':date']) }}";
                    url = url.replace(':date', date);
                    window.location.href = url;
                }
            });
        });
    </script>
@endsection