@extends('base')

@section('title', 'Bán hàng')

@section('main')
    <section class="slide-section">
        <div class="container text-center">
            <ul class="nav nav-tabs justify-content-center">
                <li class="nav-item">
                    <a class="nav-link active" href="{{ route('bills.index') }}">Quản lý đơn bán hàng</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('products.index') }}">Quản lý sản phẩm</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('producttypes.index') }}">Quản lý loại sản phẩm</a>
                </li>
            </ul>
        </div>
        <div class="container">
            <div class="text-center pb-2">
                <h2>Doanh thu bán hàng</h2>
            </div>
            <div class="container">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="date" class="form-label h5">Ngày</label>
                        <select class="form-select" name="date" id="date">
                            <option value="">Tất cả các ngày</option>
                            @foreach ($dates as $date)
                                <option value="{{ $date }}">{{ $date }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="" class="form-label h5">Tổng doanh thu</label>
                        <input type="text" class="form-control" name="total-revenue">
                    </div>
                </div>
                <div class="row mb-3 justify-content-between">
                    @foreach ($products as $index => $product)
                        @if ($product->product_type->ProductTypeName == 'Cơm suất')
                            <div class="col-md-3">
                                <label for="product-type-{{ $index + 1 }}"
                                    class="form-label h5">{{ $product->ProductName }}</label>
                                <input type="text" class="form-control" id="product-type-{{ $index + 1 }}"
                                    name="product-type-{{ $index + 1 }}" readonly placeholder="0">
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
            <div class="container pb-2">
                <table class="table table-striped" style="border: 2px solid">
                    <thead>
                        <tr>
                            <th scope="col">STT</th>
                            <th scope="col">Ngày</th>
                            <th scope="col">Các sản phẩm - Số lượng</th>
                            <th scope="col">Tổng</th>
                            <th scope="col">Hành động</th>
                        </tr>
                    </thead>
                    <tbody id="t-body">
                        @foreach ($bills as $bill)
                            <tr>
                                <td>{{ $bill->id }}</td>
                                <td>{{ $bill->Date }}</td>
                                <td>
                                    <ul>
                                        @foreach ($bill->products as $product)
                                            <li>{{ $product->ProductName }} - {{ $product->pivot->Quantity }}</li>
                                        @endforeach
                                    </ul>
                                </td>
                                <td>{{ $bill->Total }}</td>
                                <td>
                                    <div>
                                        <a href="{{ route('bills.show', $bill->id) }}"><img
                                                src="{{ URL('images/ShowIcon.svg') }}" alt="Show Icon"></a>
                                        <a href="{{ route('bills.edit', $bill->id) }}"><img
                                                src="{{ URL('images/EditIcon.svg') }}" alt="Show Icon"></a>
                                        <a href="#" data-bs-toggle="modal"
                                            data-bs-target="#deleteModal{{ $bill->id }}"><img
                                                src="{{ URL('images/DeleteIcon.svg') }}" alt="Delete Icon"></a>
                                    </div>
                                </td>
                            </tr>
                            <div class="modal fade" id="deleteModal{{ $bill->id }}" tabindex="-1"
                                aria-labelledby="deleteModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="deleteModalLabel">Xác nhận xóa đơn cơm suất</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            Bạn có chắc chắn muốn đơn cơm suất này không?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Hủy</button>
                                            <form method="POST" action="{{ route('bills.destroy', $bill->id) }}">
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
            </div>
            <div class="container text-center d-flex justify-content-center">
                <a href="#" id="add-bill-link" class="btn btn-warning">Thêm đơn mới</a>
            </div>
        </div>
    </section>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            function numberWithCommas(x) {
                return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            }

            // Hàm cập nhật số lượng loại suất
            function updateProductQuantities(bills) {
                var productQuantities = {};

                // Tính tổng doanh thu và thống kê số lượng từng loại suất
                for (let i = 0; i < bills.length; i++) {
                    var bill = bills[i];
                    for (let j = 0; j < bill.products.length; j++) {
                        var product = bill.products[j];
                        // Kiểm tra xem producttypeid của sản phẩm có bằng 1 hay không
                        if (product.ProductType_ID === 1) {
                            var productName = product.ProductName;
                            var quantity = product.pivot.Quantity;
                            // Nếu loại suất đã tồn tại, cộng thêm vào số lượng hiện có, nếu không, khởi tạo số lượng mới
                            if (productQuantities.hasOwnProperty(productName)) {
                                productQuantities[productName] += quantity;
                            } else {
                                productQuantities[productName] = quantity;
                            }
                        }
                    }
                }

                // Cập nhật giá trị của các input loại suất
                var inputCount = 0;
                for (const [productName, quantity] of Object.entries(productQuantities)) {
                    inputCount++;
                    if (inputCount <= 3) {
                        $("#product-type-" + inputCount).val(quantity);
                    }
                }
            }

            // Tính tổng doanh thu và cập nhật số lượng loại suất khi trang được khởi tạo
            $.ajax({
                url: "{{ route('filter.bills') }}",
                type: "GET",
                success: function(data) {
                    var bills = data.bills;
                    var totalRevenue = 0;

                    // Tính tổng doanh thu từ các hóa đơn
                    for (let i = 0; i < bills.length; i++) {
                        var bill = bills[i];
                        totalRevenue += parseFloat(bill.Total);
                    }

                    // Cập nhật tổng doanh thu
                    $("input[name='total-revenue']").val(numberWithCommas(Math.round(totalRevenue)));

                    // Cập nhật số lượng loại suất
                    updateProductQuantities(bills);

                    // Cập nhật các hóa đơn vào tbody
                    var html = '';
                    for (let i = 0; i < bills.length; i++) {
                        var bill = bills[i];
                        var productsHtml = '<ul>';
                        for (let j = 0; j < bill.products.length; j++) {
                            productsHtml += '<li>' + bill.products[j].ProductName +
                                ' - ' + bill.products[j].pivot.Quantity + '</li>';
                        }
                        productsHtml += '</ul>';
                        html += '<tr>\
                                    <td>' + bill.id + '</td>\
                                    <td>' + bill.Date + '</td>\
                                    <td>' + productsHtml + '</td>\
                                    <td>' + bill.Total + '</td>\
                                    <td>\
                                        <a href="/bills/' + bill.id + '"><img src="{{ URL('images/ShowIcon.svg') }}" alt="Show Icon"></a>\
                                        <a href="/bills/' + bill.id + '/edit"><img src="{{ URL('images/EditIcon.svg') }}" alt="Edit Icon"></a>\
                                        <a href="#" data-bs-toggle="modal" data-bs-target="#deleteModal' + bill.id + '"><img src="{{ URL('images/DeleteIcon.svg') }}" alt="Delete Icon"></a>\
                                    </td>\
                                </tr>';
                    }
                    $("#t-body").html(html);
                }
            });

            // Xử lý sự kiện khi người dùng thay đổi ngày
            $("#date").on('change', function() {
                var date = $(this).val();
                $.ajax({
                    url: "{{ route('filter.bills') }}",
                    type: "GET",
                    data: {
                        'date': date
                    },
                    success: function(data) {
                        var bills = data.bills;
                        var totalRevenue = 0;

                        // Tính tổng doanh thu từ các hóa đơn
                        for (let i = 0; i < bills.length; i++) {
                            var bill = bills[i];
                            totalRevenue += parseFloat(bill.Total);
                        }

                        // Cập nhật tổng doanh thu
                        $("input[name='total-revenue']").val(numberWithCommas(Math.round(
                            totalRevenue)));

                        // Xóa giá trị cũ trong input hiển thị thống kê số lượng suất
                        $("input[name^='product-type-']").val('');

                        // Cập nhật số lượng loại suất
                        updateProductQuantities(bills);

                        // Cập nhật các hóa đơn vào tbody
                        var html = '';
                        for (let i = 0; i < bills.length; i++) {
                            var bill = bills[i];
                            var productsHtml = '<ul>';
                            for (let j = 0; j < bill.products.length; j++) {
                                productsHtml += '<li>' + bill.products[j].ProductName +
                                    ' - ' + bill.products[j].pivot.Quantity + '</li>';
                            }
                            productsHtml += '</ul>';
                            html += '<tr>\
                                        <td>' + bill.id + '</td>\
                                        <td>' + bill.Date + '</td>\
                                        <td>' + productsHtml + '</td>\
                                        <td>' + bill.Total + '</td>\
                                        <td>\
                                            <a href="/bills/' + bill.id + '"><img src="{{ URL('images/ShowIcon.svg') }}" alt="Show Icon"></a>\
                                            <a href="/bills/' + bill.id + '/edit"><img src="{{ URL('images/EditIcon.svg') }}" alt="Edit Icon"></a>\
                                            <a href="#" data-bs-toggle="modal" data-bs-target="#deleteModal' + bill.id + '"><img src="{{ URL('images/DeleteIcon.svg') }}" alt="Delete Icon"></a>\
                                        </td>\
                                    </tr>';
                        }
                        $("#t-body").html(html);
                    }
                });
            });

            // Xử lý sự kiện khi người dùng nhấn vào link "Thêm mới đơn cơm suất"
            document.getElementById('add-bill-link').addEventListener('click', function() {
                var date = document.getElementById('date').value;

                if (!date) {
                    window.location.href = "{{ route('bills.createWithoutParams') }}";
                } else {
                    var url = "{{ route('bills.create', ['date' => ':date']) }}";
                    url = url.replace(':date', date);
                    window.location.href = url;
                }
            });
        });
    </script>
@endsection
