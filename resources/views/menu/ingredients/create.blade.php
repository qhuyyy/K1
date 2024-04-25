@extends('base')

@section('title','Thêm nguyên liệu mới')
    
@section('main')
    <section class="slide-section">
        <div class="container border rounded border-secondary">
            <div class="container text-center pt-2">
                <h2>Thêm mới nguyên liệu</h2>
            </div>
            <div class="container">
                <form class="" method="POST" action="{{ route('ingredients.store') }}">
                    @csrf
                    <div class="row justify-content-center mx-auto" style="width:80%">
                        <div class="mb-3">
                            <label for="formGroupExampleInput" class="form-label">STT</label>
                            <input type="text" readonly class="form-control" id="formGroupExampleInput"
                                name="id" value="" placeholder="STT tự động tăng (không cần nhập)">
                        </div>
                        <div class="mb-3">
                            <label for="formGroupExampleInput2" class="form-label">Tên nguyên liệu</label>
                            <input type="text" class="form-control" id="formGroupExampleInput2" name="IngredientName"
                                value="" placeholder="Nhập họ tên đầy đủ của nhân viên">
                        </div>
                    </div>
                    <div class="container d-flex justify-content-center align-items-center">
                        <div class="text-center pb-2 mx-2">
                            <button type="button" onclick="goBack()" class="btn btn-primary">Quay lại</button>
                        </div>
                        <div class="text-center pb-2 mx-2">
                            <button type=submit class="btn btn-primary">Thêm mới</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
    
@endsection

@section('script')
    <script>
        function goBack() {
            window.history.back();
        }
    </script>
@endsection