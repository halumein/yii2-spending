<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use halumein\spending\models\Category;


$categories = Category::find()->where("id != :id AND parent_id = 0 OR parent_id IS NULL", [':id' => $model->id])->all();
$categories = ArrayHelper::map($categories, 'id', 'name');
$parentCategories = array_merge(['0' => 'Нет'], $categories);
?>

<div class="category-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php echo $form->errorSummary($model); ?>

    <?php echo $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'parent_id')
        ->widget(Select2::classname(), [
            'data' => Category::buildTextTree(null, 1, [$model->id]),
            'language' => 'ru',
            'options' => ['placeholder' => 'Выберите категорию ...'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]); ?>

    <div class="form-group">
        <?php echo Html::submitButton($model->isNewRecord ? 'Добавить' : 'Изменить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
