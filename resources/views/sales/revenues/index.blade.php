@extends('base')

@section('title', 'Doanh thu')
    
@section('main')
<section class="slide-section">
    <div class="container">
        <div class="text-center pb-2">
            <h2>Doanh thu của nhà ăn</h2>
        </div>
        <div class="container">
            <label for="date" class="form-label">Ngày</label>
            <select class="form-select" name="date" id="date">
                <option value="">Chọn ngày</option>
                @foreach ($dates as $date)
                    <option value="{{ $date }}">{{ $date }}</option>
                @endforeach
            </select>                        
        <div class="container pb-4">
            <div class="row">
                <div class="col-md-4">
                    <?php
                        $totalRevenue = 0; 
                        
                        $currentMonth = date('Y-m'); 
                        $totalRevenueCurrentMonth = 0; 
                        
                        $currentMonthFirstDay = date('Y-m-01'); 
                        $lastMonthFirstDay = date('Y-m-01', strtotime('-1 month', strtotime($currentMonthFirstDay))); 
                        $lastMonth = date('Y-m', strtotime('-1 month', strtotime($currentMonth))); 

                        $totalRevenueLastMonth = 0; 
                        foreach ($revenues as $revenue) {
                            $totalRevenue += $revenue->Total; 

                            if (substr($revenue->Date, 0, 7) === $currentMonth) { 
                                $totalRevenueCurrentMonth += $revenue->Total; 
                            }

                            if (substr($revenue->Date, 0, 7) === $lastMonth) {
                                $totalRevenueLastMonth += $revenue->Total;
                            }
                        }
                    ?>
                    <label for="" class="form-label">Tổng doanh thu đến thời điểm hiện tại</label>
                    <input type="text" class="form-control" value="{{ $totalRevenue }}" readonly>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Tổng doanh thu tháng hiện tại</label>
                    <input type="text" class="form-control" value="{{ $totalRevenueCurrentMonth }}" readonly>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Tổng doanh thu tháng trước</label>
                    <input type="text" class="form-control" value="{{ $totalRevenueLastMonth }}" readonly>
                </div>
            </div>
        </div>
        <div class="container pb-2">
            <table class="table table-striped" style="border: 2px solid; border-radius: 10px">
                <thead>
                    <tr>
                        <th scope="col">STT</th>
                        <th scope="col">Ngày</th>
                        <th scope="col">Tiền cơm trưa</th>
                        <th scope="col">Tiền cơm tối</th>
                        <th scope="col">Tiền bán đồ ăn nhanh</th>
                        <th scope="col">Tiền chuyển khoản</th>
                        <th scope="col">Tổng cộng</th>
                        <th scope="col">Hành động</th>
                    </tr>
                </thead>
                <tbody id="t-body">
                    @foreach ($revenues as $revenue)
                        <tr>
                            <td>{{ $revenue->id }}</td>
                            <td>{{ $revenue->Date }}</td>
                            <td>{{ $revenue->Lunch }}</td>
                            <td>{{ $revenue->Dinner }}</td>
                            <td>{{ $revenue->FastFood }}</td>
                            <td>{{ $revenue->BankTransfer }}</td>
                            <td>{{ $revenue->Total }}</td>
                            <td>
                                <div class="mx-3">
                                    <a href="{{ route('revenues.show', $revenue->id) }}"><img
                                            src="{{ URL('images/ShowIcon.svg') }}" alt="Show Icon"></a>
                                    <a href="{{ route('revenues.edit', $revenue->id) }}"><img
                                            src="{{ URL('images/EditIcon.svg') }}" alt="Show Icon"></a>
                                    <a href="{{ route('revenues.destroy', $revenue->id) }}" data-bs-toggle="modal"
                                        data-bs-target="#{{ $revenue->id }}">
                                        <img src="{{ URL('images/DeleteIcon.svg') }}" alt="Delete Icon">
                                    </a>
                                </div>
                                <div class="modal fade" id="{{ $revenue->id }}" tabindex="-1"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="exampleModalLabel">Xóa
                                                    thông tin doanh thu</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                Bạn có chắc chắn muốn xóa doanh thu ngày đấy không?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Hủy</button>
                                                <form method="POST"
                                                    action="{{ route('revenues.destroy', $revenue->id) }}">
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
        <div class="container text-center">
            <a href="{{ route('revenues.create') }}" class="btn btn-warning">Thêm mới doanh thu</a>
        </div>
    </div>
</section>
@endsection

@section('script')
    <script>
        $(document).ready(function(){
            $("#date").on('change',function(){
                var date = $(this).val();
                $.ajax({
                    url:"{{ route ('filter.revenues')}}",
                    type: "GET",
                    data: {'date':date},
                    success:function(data){
                        var revenues = data.revenues;
                        var html = '';
                        if (revenues.length > 0){
                            for(let i =0; i<revenues.length; i++){
                                html += '<tr>\
                                        <td>'+revenues[i]['id']+'</td>\
                                        <td>'+revenues[i]['Date']+'</td>\
                                        <td>'+revenues[i]['Lunch']+'</td>\
                                        <td>'+revenues[i]['Dinner']+'</td>\
                                        <td>'+revenues[i]['FastFood']+'</td>\
                                        <td>'+revenues[i]['BankTransfer']+'</td>\
                                        <td>'+revenues[i]['Total']+'</td>\
                                        <td>\
                                            <div class="mx-3">\
                                                    <a href="/revenues/' + revenues[i]['id'] + '"><img src="{{ URL('images/ShowIcon.svg') }}" alt="Show Icon"></a>\
                                                    <a href="/revenues/' + revenues[i]['id'] + '/edit"><img src="{{ URL('images/EditIcon.svg') }}" alt="Edit Icon"></a>\
                                                    <a href="#" data-bs-toggle="modal" data-bs-target="#deleteModal' + revenues[i]['id'] + '"><img src="{{ URL('images/DeleteIcon.svg') }}" alt="Delete Icon"></a>\
                                                </div>\
                                            </td>\
                                    </tr>';
                            }
                        }
                        else{
                            html += '<tr>\
                                <td>Không tìm thấy bản ghi nào</td>\
                                </tr>';
                        }
                        $("#t-body").html(html);
                    }
                })
            })
        })
    </script>
    
@endsection