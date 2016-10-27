<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\jui\AutoComplete;
use halumein\spending\models\Category;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model halumein\spending\models\Spending */
/* @var $form yii\bootstrap\ActiveForm */
?>

<div class="spending-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php echo $form->errorSummary($model); ?>

    <label class="control-label" for="spending-name">Наименование</label>

    <div class="row">
        <div class="col-sm-12 col-md-6">
        <?php
            echo $form->field($model, 'name')
            ->widget(AutoComplete::classname(), [
                'name' => 'name',
                'id' => 'ddd',
                'clientOptions' => [
                    'source' => $data,
                    'autoFill' => true,
                    'minLength' => '0',
                ],
                'options' => [
                   'class' => 'form-control',
                ],
            ])->label(false);
        ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12 col-md-6">
            <?= $form->field($model, 'category_id')
            ->widget(Select2::classname(), [
                'data' => Category::buildTextTree(null, 1),
                'language' => 'ru',
                'options' => ['placeholder' => 'Выберите категорию ...'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);
            ?>
        </div>
    </div>

    <!-- <div class="row">
        <div class="col-sm-12 col-md-6">
            <?php // echo $form->field($model, 'amount')->textInput(['maxlength' => true, 'placeholder' => '0.000']) ?>
        </div>
    </div> -->

    <div class="row">
        <div class="col-sm-12 col-md-6">
            <?php echo $form->field($model, 'cost')->textInput(['maxlength' => true, 'placeholder' => '0.00']) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12 col-md-6">
            <?php echo $form->field($model, 'cashbox_id')
                ->widget(Select2::classname(), [
                    'data' => ArrayHelper::map($activeCashboxes, 'id', 'nameWithCurrentBalance'),
                    'language' => 'ru',
                    'options' => ['placeholder' => 'Выберите кассу ...'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]);
            ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12 col-md-6">
            <?= $form->field($model, 'comment')->textArea() ?>
        </div>
    </div>


    <div class="form-group">
        <?php echo Html::submitButton($model->isNewRecord ? 'Добавить' : 'Изменить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
