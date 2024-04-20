@extends('base')

@section('title','Danh sách thực phẩm đã nhập')
    
@section('main')
<section class="slide-section pt-3">
    
    <div class="container">    
        <div class="row">
            <div class="col-md-3">
                <form action="">
                    <div class="text-center">
                        <h2>Bộ lọc</h2>
                    </div>
                    <div class="">
                        <label for="formGroupExampleInput2" class="form-label">Loại thực phẩm</label>
                        <select class="form-select" name="foodtype" id="foodtype">
                            <option value="">Chọn loại thực phẩm</option>
                            @foreach ($foodtypes as $foodtype)
                                <option value="{{ $foodtype['id']}}">{{$foodtype->FoodTypeName}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="pt-2">
                        <label for="formGroupExampleInput2" class="form-label">Ngày</label>
                        <select class="form-select" name="date" id="date">
                            <option value="">Chọn ngày</option>
                            @foreach ($dates as $date)
                                <option value="{{ $date }}">{{ $date }}</option>
                            @endforeach
                        </select>
                    </div>
                </form>
            </div>
            <div class="col-md-9">
                <div class="text-center pb-2">
                    <h2>Danh sách thực phẩm đã nhập tại nhà ăn</h2>
                </div>
                <table class="table table-striped m-2" style="border: 2px solid; border-radius: 10px">
                    <thead>
                        <tr>
                            <th scope="col">STT</th>
                            <th scope="col">Ngày</th>
                            <th scope="col">Loại thực phẩm</th>
                            <th scope="col">Tên thực phẩm</th>
                            <th scope="col">Đơn vị tính</th>
                            <th scope="col">Đơn giá</th>
                            <th scope="col">Số lượng</th>
                            <th scope="col">Tổng tiền</th>
                            <th scope="col">Hành động</th>
                        </tr>
                    </thead>
                    <tbody id="t-body">
                        @foreach ($received_food as $receivedfood)
                            <tr>
                                <td>{{ $receivedfood->id }}</td>
                                <td>{{ date('d-m-Y', strtotime($receivedfood->Date)) }}</td>
                                <td>{{ $receivedfood->food_type->FoodTypeName }}</td>
                                <td>{{ $receivedfood->FoodName }}</td>
                                <td>{{ $receivedfood->unit->UnitName }}</td>
                                <td>{{ number_format($receivedfood->UnitPrice, 0, ',', '.') }}</td>
                                <td>{{ $receivedfood->Quantity }}</td>
                                <td>{{ number_format($receivedfood->Total, 0, ',', '.') }}</td>
                                <td>
                                    <div class="mx-3">
                                        <a href="{{ route('receivedfood.show', $receivedfood->id) }}"><img
                                                src="{{ URL('images/ShowIcon.svg') }}" alt="Show Icon"></a>
                                        <a href="{{ route('receivedfood.edit', $receivedfood->id) }}"><img
                                                src="{{ URL('images/EditIcon.svg') }}" alt="Edit Icon"></a>
                                        <a href="{{ route('receivedfood.destroy', $receivedfood->id) }}" data-bs-toggle="modal"
                                            data-bs-target="#{{ $receivedfood->id }}">
                                            <img src="{{ URL('images/DeleteIcon.svg') }}" alt="Delete Icon">
                                        </a>
                                    </div>
                                    <div class="modal fade" id="{{ $receivedfood->id }}" tabindex="-1"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Xóa thông tin thực phẩm
                                                    </h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    Bạn có chắc chắn muốn xóa thực phẩm này không?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Hủy</button>
                                                    <form method="POST"
                                                        action="{{ route('receivedfood.destroy', $receivedfood->id) }}">
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
                <div class="container text-center pt-2">
                    <a href="{{ route('receivedfood.create') }}" class="btn btn-primary">Thêm mới thực phẩm</a>
                </div>
            </div>    
            
        </div>    
    </div>
    
</section>
@endsection

@section('script')
    <script>
        $(document).ready(function(){
            function filterReceivedFood() {
                var date = $("#date").val();
                var foodtype = $("#foodtype").val();
                $.ajax({
                    url:"{{ route('filter') }}",
                    type: "GET",
                    data: {'date': date, 'foodtype': foodtype},
                    success:function(data){
                        var received_food = data.received_food;
                        var html = '';
                        if (received_food.length > 0){
                            for (let i = 0; i < received_food.length; i++) {
                                html += '<tr>\
                                        <td>'+received_food[i]['id']+'</td>\
                                        <td>'+received_food[i]['Date']+'</td>\
                                        <td>'+ received_food[i]['food_type']['FoodTypeName'] +'</td>\
                                        <td>'+received_food[i]['FoodName']+'</td>\
                                        <td>'+received_food[i]['unit']['UnitName']+'</td>\
                                        <td>'+received_food[i]['UnitPrice']+'</td>\
                                        <td>'+received_food[i]['Quantity']+'</td>\
                                        <td>'+received_food[i]['Total']+'</td>\
                                        <td>\
                                            <a href="/receivedfood/'+received_food[i]['id']+'"><img src="/images/ShowIcon.svg" alt="Show Icon"></a>\
                                            <a href="/receivedfood/'+received_food[i]['id']+'/edit"><img src="/images/EditIcon.svg" alt="Edit Icon"></a>\
                                            <a href="/receivedfood/'+received_food[i]['id']+'/destroy" data-bs-toggle="modal" data-bs-target="#'+received_food[i]['id']+'"><img src="/images/DeleteIcon.svg" alt="Delete Icon"></a>\
                                            <div class="modal fade" id="'+ received_food[i]['id'] +'" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">\
                                                <div class="modal-dialog">\
                                                    <div class="modal-content">\
                                                        <div class="modal-header">\
                                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Xóa thông tin thực phẩm</h1>\
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>\
                                                        </div>\
                                                        <div class="modal-body">\
                                                            Bạn có chắc chắn muốn xóa thực phẩm này không?\
                                                        </div>\
                                                        <div class="modal-footer">\
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>\
                                                            <form method="POST" action="/receivedfood/'+received_food[i]['id']+'/destroy">\
                                                                @csrf\
                                                                @method('DELETE')\
                                                                <button type="submit" class="btn btn-primary" data-bs-dismiss="modal">Xác nhận</button>\
                                                            </form>\
                                                        </div>\
                                                    </div>\
                                                </div>\
                                            </div>\
                                        </td>\
                                    </tr>';
                                        console.log(html)
                            }   
                        }
                        else{
                            html += 'Không tìm thấy thực phẩm nào';
                        }
                        $("#t-body").html(html);
                    }
                });
            }
           
    // Gọi hàm filterReceivedFood() khi có thay đổi trong select box ngày hoặc select box loại thực phẩm
    $("#date, #foodtype").on('change', filterReceivedFood);
});
    </script>
@endsection