@extends('base')

@section('title', 'Danh sách thực đơn')

@section('main')
    <section class="slide-section pt-3">   
        <div class="container text-center">
            <ul class="nav nav-tabs justify-content-center">
                <li class="nav-item">
                    <a class="nav-link active" href="{{ route('dailymenus.index') }}">Quản lý thực đơn</a>
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
                <div class="text-center pt-2">
                    <h2>Bộ lọc</h2>
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        <label for="date" class="form-label">Ngày</label>
                        <select class="form-select" name="date" id="date">
                            <option value="">Chọn ngày</option>
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
                        <th scope="col">Các món ăn</th>
                        <th scope="col">Nguyên liệu</th>
                        <th scope="col">Hành động</th>
                    </tr>
                </thead>
                <tbody id="t-body">
                    @foreach ($dailymenus as $dailymenu)
                        <tr>
                            <td>{{ $dailymenu->id }}</td>
                            <td>{{ $dailymenu->Date }}</td>
                            <td>{{ $dailymenu->NumberOfPortions }}</td>
                            <td>
                                <ul>
                                    @for ($i = 1; $i <= 10; $i++)
                                        @if (!is_null($dailymenu["Dish{$i}"]))
                                            <li>{{ $dailymenu["Dish{$i}"]->DishName }}</li>
                                        @endif
                                    @endfor
                                </ul>
                            </td>
                            <td>
                                <ul>
                                    @for ($i = 1; $i <= 10; $i++)
                                        @if (!is_null($dailymenu["Dish{$i}"]))
                                            @for ($j = 1; $j <= 5; $j++)
                                                @php
                                                    $ingredient_property = "Ingredient" . $j . "_ID";
                                                    if (!is_null($dailymenu["Dish{$i}"]->$ingredient_property)) {
                                                        $ingredient = App\Models\Ingredient::find($dailymenu["Dish{$i}"]->$ingredient_property);
                                                        echo "<li>{$ingredient->IngredientName}</li>";
                                                    }
                                                @endphp
                                            @endfor
                                        @endif
                                    @endfor
                                </ul>
                            </td>
                            <td>
                                <div class="mx-3">
                                    <a href="{{ route('dailymenus.show', $dailymenu->id) }}"><img src="{{ URL('images/ShowIcon.svg') }}"
                                            alt="Show Icon"></a>
                                    <a href="{{ route('dailymenus.edit', $dailymenu->id) }}"><img src="{{ URL('images/EditIcon.svg') }}"
                                            alt="Edit Icon"></a>
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $dailymenu->id }}"><img
                                            src="{{ URL('images/DeleteIcon.svg') }}" alt="Delete Icon"></a>
                                </div>
                            </td>
                        </tr>
                        <div class="modal fade" id="deleteModal{{ $dailymenu->id }}" tabindex="-1" aria-labelledby="deleteModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="deleteModalLabel">Xác nhận xóa thực đơn</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        Bạn có chắc chắn muốn xóa món ăn này không?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                                        <form method="POST" action="{{ route('dailymenus.destroy', $dailymenu->id) }}">
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
                <a href="{{ route('dailymenus.create') }}" class="btn btn-warning">Thêm mới thực đơn</a>
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
                url: "{{ route('filter.dailymenus') }}",
                type: "GET",
                data: {'date': date},
                success: function(data){
                    var dailymenus = data.dailymenus;
                    var html = '';
                    if (dailymenus.length > 0 ){
                        for(let i=0; i<dailymenus.length; i++){
                            html += '<tr>\
                                        <td>'+dailymenus[i]['id']+'</td>\
                                        <td>'+dailymenus[i]['Date']+'</td>\
                                        <td>'+dailymenus[i]['NumberOfPortions']+'</td>\
                                        <td>\
                                            <a href="/dailymenus/' + dailymenus[i]['id'] + '"><img src="/images/ShowIcon.svg" alt="Show Icon"></a>\
                                            <a href="/dailymenus/' + dailymenus[i]['id'] + '/edit"><img src="/images/EditIcon.svg" alt="Edit Icon"></a>\
                                            <a href="#" data-bs-toggle="modal" data-bs-target="#' +
                                            dailymenus[i]['id'] + '"><img src="/images/DeleteIcon.svg" alt="Delete Icon"></a>\
                                        </td>\
                                    </tr>';
                        }
                    }
                    else{
                        html += '<tr>\
                                    <td>Không tìm thấy thực đơn nào</td>\
                                </tr>';
                    }
                    $("#t-body").html(html);
                }
            });
        });
    });
    </script>
    
@endsection 