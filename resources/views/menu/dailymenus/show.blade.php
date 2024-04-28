@extends('base')

@section('title','Chi tiết thông tin thực đơn')
    
@section('main')
    <section class="slide-section">
        <div class="container border rounded border-secondary">
            <div class="container text-center pt-2">
                <h2>Chi tiết thông tin thực đơn</h2>
            </div>
            <div class="container">
                <div class="row justify-content-center mx-auto" style="width:80%">
                    <div class="mb-3">
                        <label for="formGroupExampleInput" class="form-label">STT</label>
                        <input type="text" readonly class="form-control" id="formGroupExampleInput"
                            name="id" value="{{ $dailymenu->id }}">
                    </div>
                    <div class="mb-3">
                        <label for="formGroupExampleInput2" class="form-label">Tên món ăn</label>
                        <input type="text" readonly class="form-control" id="formGroupExampleInput2"
                            name="Date" value="{{ $dailymenu->Date }}">
                    </div>
                    <div class="mb-3">
                        <label for="formGroupExampleInput2" class="form-label">Số lượng suất</label>
                        <input type="text" readonly class="form-control" id="formGroupExampleInput2"
                            value="{{ $dailymenu->NumberOfPortions }}">
                    </div>
                    <div class="mb-3">
                        <?php
                        $unique_ingredients = [];
                        for ($i = 1; $i <= 10; $i++) {
                            $dish_property = "Dish" . $i . "_ID";
                            if ($dailymenu->$dish_property !== null) {
                                for ($j = 1; $j <= 5; $j++) {
                                    $ingredient_property = "Ingredient" . $j . "_ID";
                                    if ($dailymenu->{'dish'.$i}->$ingredient_property !== null) {
                                        $ingredient = App\Models\Ingredient::find($dailymenu->{'dish'.$i}->$ingredient_property);
                                        $unique_ingredients[$ingredient->IngredientName] = $ingredient->IngredientName;
                                    }
                                }
                            }
                        }
                        $all_ingredients = implode("\n", $unique_ingredients);
                        ?>

                        <div class="row">
                            <div class="col-md-6">
                                <?php for ($i = 1; $i <= 10; $i++): ?>
                                    <?php $dish_property = "Dish" . $i . "_ID"; ?>
                                    <?php if ($dailymenu->$dish_property !== null): ?>
                                        <div class="mb-3">
                                            <label for="dish<?php echo $i; ?>" class="form-label">Món <?php echo $i; ?>:</label>
                                            <input type="text" readonly class="form-control" id="dish<?php echo $i; ?>" name="dish<?php echo $i; ?>" value="{{ $dailymenu->{'dish'.$i}->DishName ?? '' }}">
                                        </div>
                                    <?php endif; ?>
                                <?php endfor; ?>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="ingredientTextArea" class="form-label">Danh sách nguyên liệu:</label>
                                    <textarea readonly class="form-control" id="ingredientTextArea" rows="10"><?php echo $all_ingredients; ?></textarea>
                                </div>
                            </div>
                        </div>
                    </div>   
                </div>
                <div class="text-center pb-2">
                    <a href="{{ route('dailymenus.index') }}" class="btn btn-warning"> Quay lại</a>
                </div>    
            </div>
        </div>
    </section>
@endsection
    

