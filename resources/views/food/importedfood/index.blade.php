@extends('base')

@section('title', 'Danh sách thực phẩm đã nhập')

@section('main')
    <section class="slide-section pt-3">
        <div class="container">
            <div class="row">
                <div class="text-center">
                    <h2>Bộ lọc</h2>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="foodtype" class="form-label">Loại thực phẩm</label>
                        <select class="form-select" name="foodtype" id="foodtype">
                            <option value="">Chọn loại thực phẩm</option>
                            @foreach ($foodtypes as $foodtype)
                                <option value="{{ $foodtype['id'] }}">{{ $foodtype->FoodTypeName }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
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
                        <th scope="col">Ghi chú</th>
                        <th scope="col">Hành động</th>
                    </tr>
                </thead>
                <tbody id="t-body">
                    @foreach ($imported_food as $importedfood)
                        <tr>
                            <td>{{ $importedfood->id }}</td>
                            <td>{{ date('d-m-Y', strtotime($importedfood->Date)) }}</td>
                            <td>{{ $importedfood->food_type->FoodTypeName }}</td>
                            <td>{{ $importedfood->FoodName }}</td>
                            <td>{{ $importedfood->unit->UnitName }}</td>
                            <td>{{ number_format($importedfood->UnitPrice, 0, ',', '.') }}</td>
                            <td>{{ $importedfood->Quantity }}</td>
                            <td>{{ number_format($importedfood->Total, 0, ',', '.') }}</td>
                            <td>{{ $importedfood->Note }}</td>
                            <td>
                                <div class="mx-3">
                                    <a href="{{ route('importedfood.show', $importedfood->id) }}"><img
                                            src="{{ URL('images/ShowIcon.svg') }}" alt="Show Icon"></a>
                                    <a href="{{ route('importedfood.edit', $importedfood->id) }}"><img
                                            src="{{ URL('images/EditIcon.svg') }}" alt="Edit Icon"></a>
                                    <a href="{{ route('importedfood.destroy', $importedfood->id) }}" data-bs-toggle="modal"
                                        data-bs-target="#{{ $importedfood->id }}">
                                        <img src="{{ URL('images/DeleteIcon.svg') }}" alt="Delete Icon">
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <div class="modal fade" id="{{ $importedfood->id }}" tabindex="-1"
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
                                            action="{{ route('importedfood.destroy', $importedfood->id) }}">
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
            <div class="container text-center pt-2">
                <a href="{{ route('foodtypes.index') }}" class="btn btn-warning">Quản lý loại thực phẩm</a>
                <a href="#" id="add-food-link" class="btn btn-warning">Thêm mới thực phẩm</a>
            </div>
        </div>
    </section>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            function filterImportedFood() {
                var date = $("#date").val();
                var foodtype = $("#foodtype").val();
                $.ajax({
                    url: "{{ route('filter.imported_food') }}",
                    type: "GET",
                    data: {
                        'date': date,
                        'foodtype': foodtype
                    },
                    success: function(data) {
                        var imported_food = data.imported_food;
                        var html = '';
                        if (imported_food.length > 0) {
                            for (let i = 0; i < imported_food.length; i++) {
                                html += '<tr>\
                                            <td>' + imported_food[i]['id'] + '</td>\
                                            <td>' + imported_food[i]['Date'] + '</td>\
                                            <td>' + imported_food[i]['food_type']['FoodTypeName'] + '</td>\
                                            <td>' + imported_food[i]['FoodName'] + '</td>\
                                            <td>' + imported_food[i]['unit']['UnitName'] + '</td>\
                                            <td>' + imported_food[i]['UnitPrice'] + '</td>\
                                            <td>' + imported_food[i]['Quantity'] + '</td>\
                                            <td>' + imported_food[i]['Total'] + '</td>\
                                            <td>' + (imported_food[i]['Note'] !== null ? imported_food[i]['Note'] : '') + '</td>\
                                            <td>\
                                                <a href="/importedfood/' + imported_food[i]['id'] + '"><img src="/images/ShowIcon.svg" alt="Show Icon"></a>\
                                                <a href="/importedfood/' + imported_food[i]['id'] + '/edit"><img src="/images/EditIcon.svg" alt="Edit Icon"></a>\
                                                <a href="#" data-bs-toggle="modal" data-bs-target="#' +
                                                imported_food[i]['id'] + '"><img src="/images/DeleteIcon.svg" alt="Delete Icon"></a>\
                                            </td>\
                                        </tr>';
                            }
                        } else {
                            html += 'Không tìm thấy thực phẩm nào';
                        }
                        $("#t-body").html(html);
                    }
                });
            }
            document.getElementById('add-food-link').addEventListener('click', function() {
                var foodtype = document.getElementById('foodtype').value;
                var date = document.getElementById('date').value;
                
                if (!foodtype && !date) {
                    window.location.href = "{{ route('importedfood.createWithoutParams') }}";
                }
                else if (!date) {
                    alert('Vui lòng chọn ngày trước khi thêm mới.');
                } 
                else if (!foodtype) {
                    alert('Vui lòng chọn loại thực phẩm trước khi thêm mới.');
                } 
                else {
                    var url = "{{ route('importedfood.create', ['foodtype' => ':foodtype', 'date' => ':date']) }}";
                    url = url.replace(':foodtype', foodtype);
                    url = url.replace(':date', date);
                    window.location.href = url;
                }
            });

            $("#date, #foodtype").on('change', filterImportedFood);
        });
    </script>
@endsection
