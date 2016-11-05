<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use halumein\spending\models\Category;
use yii\helpers\ArrayHelper;
use yii\widgets\Pjax;
?>
<div class="spending-widget-index">
    <div class="row">
        <div class="col-sm-12">
            <?php Pjax::begin(); ?>
            <div class="total">
                <p>Итого: <?=$dataProvider->query->sum('cost');?></p>
            </div>
            <?php echo GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'rowOptions' => function ($model, $key, $index, $grid) {
                    if($model->deleted != null) {
                        return ['class' => 'danger'];
                    }
                },
                'columns' => [

                    ['attribute' => 'id', 'filter' => true, 'options' => ['style' => 'width: 55px;']],
                    'name',
                    [
                        'attribute' => 'category_id',
                        'filter' => Html::activeDropDownList(
                            $searchModel,
                            'category_id',
                            Category::buildTextTree(),
                            ['class' => 'form-control', 'prompt' => 'Все категории']
                        ),
                        'value' => 'category.name'
                    ],
                    ['attribute' => 'date', 'filter' => false],
                    // ['attribute' => 'amount', 'filter' => false, 'options' => ['style' => 'width: 70px;']],
                    ['attribute' => 'cost', 'filter' => false, 'options' => ['style' => 'width: 100px;']],
                    [
                        'attribute' => 'cashbox_id',
                        'filter' => Html::activeDropDownList(
                            $searchModel,
                            'cashbox_id',
                            ArrayHelper::map($activeCashboxes, 'id', 'name'),
                            ['class' => 'form-control', 'prompt' => 'Все кассы']
                        ),
                        'value' => 'cashbox.name'
                    ],
                    [
                        'attribute' => 'user_id',
                        'filter' => Html::activeDropDownList(
                            $searchModel,
                            'user_id',
                            ArrayHelper::map($activeUsers, 'id', 'name'),
                            ['class' => 'form-control', 'prompt' => 'Все сотрудники']
                        ),
                        'value' => 'user.fullName'
                    ],
                    'comment:ntext',
                    //['class' => 'yii\grid\ActionColumn'],
                ],
            ]); ?>
            <?php Pjax::end(); ?>
        </div>
    </div>
</div>
