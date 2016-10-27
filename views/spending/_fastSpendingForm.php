<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\jui\AutoComplete;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;

 ?>

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-sm-12 col-md-4">
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
                   'placeholder' => 'на что'
                ],
            ])->label(false);
        ?>
        </div>

        <div class="col-sm-12 col-md-3">
            <?php echo $form->field($model, 'cost')->textInput(['maxlength' => true, 'placeholder' => '0.00'])->label(false) ?>
        </div>

        <div class="col-sm-12 col-md-3">
            <?php echo $form->field($model, 'cashbox_id')
                ->widget(Select2::classname(), [
                    'data' => ArrayHelper::map($activeCashboxes, 'id', 'nameWithCurrentBalance'),
                    'language' => 'ru',
                    'options' => ['placeholder' => 'Выберите кассу ...'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ])->label(false);
            ?>
        </div>
        
        <div class="col-sm-2">
            <?php echo Html::submitButton('Добавить', ['class' =>'btn btn-success']) ?>
        </div>
    </div>


    <?php ActiveForm::end(); ?>
