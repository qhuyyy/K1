@extends('base')

@section('title', 'Thông tin các món ăn')

@section('main')
    <section class="slide-section pt-3">  
        <div class="container text-center">
            <ul class="nav nav-tabs justify-content-center">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('menus.index') }}">Quản lý thực đơn</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="{{ route('dishes.index') }}">Quản lý món ăn</a>
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
                <div class="text-center pt-2">
                    <h2>Bộ lọc</h2>
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        <label for="dishtype" class="form-label">Loại món ăn</label>
                        <select class="form-select" name="dishtype" id="dishtype">
                            <option value="">Chọn loại món ăn</option>
                            @foreach ($dishtypes as $dishtype)
                                <option value="{{ $dishtype['id'] }}">{{ $dishtype->DishTypeName }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="text-center pb-2">
                <h2>Danh sách các món ăn</h2>
            </div>
            <table class="table table-striped m-2" style="border: 2px solid; border-radius: 10px">
                <thead>
                    <tr>
                        <th scope="col">STT</th>
                        <th scope="col">Tên món ăn</th>
                        <th scope="col">Loại món ăn</th>
                        <th scope="col">Danh sách nguyên liệu</th>
                        <th scope="col">Hành động</th>
                    </tr>
                </thead>
                <tbody id="t-body">
                    @foreach ($dishes as $dish)
                        <tr>
                            <td>{{ $dish->id }}</td>
                            <td>{{ $dish->DishName }}</td>
                            <td>{{ $dish->dish_type->DishTypeName }}</td>
                            <td>
                                <ul>
                                    @foreach($dish->ingredients()->orderBy('IngredientName')->get() as $ingredient)
                                        <li>{{ $ingredient->IngredientName }}</li>
                                    @endforeach
                                </ul>       
                            </td>
                            <td>
                                <div class="mx-3">
                                    <a href="{{ route('dishes.show', $dish->id) }}"><img src="{{ URL('images/ShowIcon.svg') }}"
                                            alt="Show Icon"></a>
                                    <a href="{{ route('dishes.edit', $dish->id) }}"><img src="{{ URL('images/EditIcon.svg') }}"
                                            alt="Edit Icon"></a>
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $dish->id }}"><img
                                            src="{{ URL('images/DeleteIcon.svg') }}" alt="Delete Icon"></a>
                                </div>
                            </td>
                        </tr>
                        <div class="modal fade" id="deleteModal{{ $dish->id }}" tabindex="-1" aria-labelledby="deleteModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="deleteModalLabel">Xác nhận xóa món ăn</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        Bạn có chắc chắn muốn xóa món ăn này không?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                                        <form method="POST" action="{{ route('dishes.destroy', $dish->id) }}">
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
                <a href="#" id="add-dish-link" class="btn btn-warning">Thêm mới món ăn</a>
            </div>
        </div>
    </section>
@endsection

@section('script')
    <script>
        $(document).ready(function(){
            $("#dishtype").on('change',function(){
                var dishtype = $(this).val();
                $.ajax({
                    url: "{{ route('filter.dishes')}}",
                    type: "GET",
                    data: {'dishtype':dishtype},
                    success:function(data){
                        var dishes = data.dishes;
                        var html = '';
                        if(dishes.length > 0){
                            for (let i = 0; i<dishes.length; i++){
                                var ingredientsHtml = '<ul>';
                                for (let j = 0; j < dishes[i].ingredients.length; j++) {
                                    ingredientsHtml += '<li>' + dishes[i].ingredients[j].IngredientName + '</li>';
                                }
                                ingredientsHtml += '</ul>';

                                html += '<tr>\
                                            <td>' + dishes[i]['id'] + '</td>\
                                            <td>' + dishes[i]['DishName'] + '</td>\
                                            <td>' + (dishes[i]['dish_type'] ? dishes[i]['dish_type']['DishTypeName'] : '') + '</td>\
                                            <td>' + ingredientsHtml + '</td>\
                                            <td>\
                                                <div class="mx-3">\
                                                    <a href="/dishes/' + dishes[i]['id'] + '"><img src="{{ URL('images/ShowIcon.svg') }}" alt="Show Icon"></a>\
                                                    <a href="/dishes/' + dishes[i]['id'] + '/edit"><img src="{{ URL('images/EditIcon.svg') }}" alt="Edit Icon"></a>\
                                                    <a href="#" data-bs-toggle="modal" data-bs-target="#deleteModal' + dishes[i]['id'] + '"><img src="{{ URL('images/DeleteIcon.svg') }}" alt="Delete Icon"></a>\
                                                </div>\
                                            </td>\
                                        </tr>';        
                            }
                        }
                        else{
                            html += '<tr>\
                                        <td>Không tìm thấy món nào</td>\
                                    </tr>';
                        }
                        $("#t-body").html(html);
                    }
                });
            })

            $("#add-dish-link").on('click', function() {
                var dishtype = $("#dishtype").val();
                
                if (!dishtype) {
                    window.location.href = "{{ route('dishes.createWithoutParams') }}";
                }
                else {
                    var url = "{{ route('dishes.create', ['dishtype' => ':dishtype']) }}";
                    url = url.replace(':dishtype', dishtype);
                    window.location.href = url;
                }
            });
        })
    </script>
    
@endsection