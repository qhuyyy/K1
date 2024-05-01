@extends('base')

@section('title','Thêm món ăn mới')
    
@section('main')
    <section class="slide-section">
        <div class="container border rounded border-secondary">
            <div class="container text-center pt-2">
                <h2>Thêm mới món ăn</h2>
            </div>
            <div class="container">
                <form class="" method="POST" action="{{ route('dishes.store') }}">
                    @csrf
                    <div class="row justify-content-center mx-auto" style="width:80%">
                        <div class="mb-3">
                            <label for="formGroupExampleInput" class="form-label">STT</label>
                            <input type="text" readonly class="form-control" id="formGroupExampleInput"
                                name="id" value="" placeholder="STT tự động tăng (không cần nhập)">
                        </div>
                        <div class="mb-3">
                            <label for="formGroupExampleInput2" class="form-label">Tên món ăn</label>
                            <input type="text" class="form-control" id="formGroupExampleInput2" name="DishName"
                                value="" placeholder="Nhập tên món ăn">
                        </div>
                        <div class="mb-3">
                            <label for="dishtype" class="form-label">Loại món ăn</label>
                            <select class="form-select" id="dishtype" name="dishtype">
                                <option value="">- Chọn loại món ăn -</option>
                                @foreach ($dishtypes as $dishtype)
                                    <option value="{{ $dishtype->id }}" data-dishtype-id="{{ $dishtype->id }}" {{ request()->dishtype == $dishtype->id ? 'selected' : '' }}>
                                        {{ $dishtype->DishTypeName }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div id="ingredients-container">
                            <div class="mb-3">
                                <div class="row">
                                    <div class="col-md-7">
                                        <label for="ingredient" class="form-label">Nguyên liệu</label>
                                        <select class="form-select" id="ingredient" name="ingredient[]">
                                            <option value="">- Chọn nguyên liệu -</option>
                                            @foreach ($ingredients as $ingredient)
                                                <option value="{{ $ingredient->id }}" data-unit-name="{{ $ingredient->unit->UnitName }}">{{ $ingredient->IngredientName }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="amount" class="form-label">Định lượng cho 10 suất</label>
                                        <input class="form-control" type="text" name="amount[]" id="amount">
                                    </div>
                                    <div class="col-md-2">
                                        <label for="unit" class="form-label">Đơn vị tính</label>
                                        <input class="form-control" type="text" id="unit" name="unit" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row d-flex justify-content-center align-items-center pt-2 text-center">
                            <div class="col-md-3">
                                <button type="button" id="add-ingredient" class="btn btn-info">Thêm nguyên liệu</button>
                            </div>
                            <div class="col-md-3">
                                <button type="button" id="remove-ingredient" class="btn btn-danger">Bớt nguyên liệu</button>
                            </div>
                        </div>
                    </div>
                    <div class="text-center">
                        <span>Không có nguyên liệu bạn cần ?</span>
                        <a href="{{ route('ingredients.index') }}">Xem danh sách nguyên liệu bạn có</a>
                    </div>
                    <div class="container d-flex justify-content-center align-items-center pt-2">
                        <div class="text-center pb-2 mx-2">
                            <a href="{{ route('dishes.index') }}" class="btn btn-warning" style="width:98.89px">
                                Quay lại</a>
                        </div>
                        <div class="text-center pb-2 mx-2">
                            <button type=submit class="btn btn-warning">Thêm mới</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection

@section('script')
    <script>
        document.getElementById('add-ingredient').addEventListener('click', function() {
            var container = document.getElementById('ingredients-container');
            var div = document.createElement('div');
            div.classList.add('mb-3');
            div.innerHTML = `
                <div class="row">
                    <div class="col-md-7">
                        <label for="ingredient" class="form-label">Nguyên liệu</label>
                        <select class="form-select" name="ingredient[]" onchange="updateUnit(this)">
                            <option value="">- Chọn nguyên liệu -</option>
                            @foreach ($ingredients as $ingredient)
                                <option value="{{ $ingredient->id }}" data-unit-name="{{ $ingredient->unit->UnitName }}">{{ $ingredient->IngredientName }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="amount" class="form-label">Định lượng cho 10 suất</label>
                        <input class="form-control" type="text" name="amount[]" id="amount">
                    </div>
                    <div class="col-md-2">
                        <label for="unit" class="form-label">Đơn vị tính</label>
                        <input class="form-control" type="text" name="unit[]" id="unit" readonly>
                    </div>
                </div>
            `;
            container.appendChild(div);
        });

        document.getElementById('remove-ingredient').addEventListener('click', function() {
            var container = document.getElementById('ingredients-container');
            var children = container.getElementsByClassName('mb-3');
            if (children.length > 1) {
                container.removeChild(children[children.length - 1]);
            }
        });

        function updateUnit(select) {
            var selectedOption = select.options[select.selectedIndex];
            var unitName = selectedOption.getAttribute('data-unit-name');
            var unitInput = select.parentElement.nextElementSibling.nextElementSibling.querySelector('#unit');
            unitInput.value = unitName || '';
        }     

        document.getElementById('ingredient').addEventListener('change', function() {
            var select = document.getElementById('ingredient');
            var selectedOption = select.options[select.selectedIndex];
            var unitName = selectedOption.getAttribute('data-unit-name');

            document.getElementById('unit').value = unitName || '';
        });
    </script>
@endsection
    

