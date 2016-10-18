<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use halumein\spending\models\Category;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel halumein\spending\models\search\SpendingSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Затраты';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="spending-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>


    <div class="row">
        <div class="col-sm-4 col-md-3">
        <p>
            <?php echo Html::a('Добавить затрату', ['create'], ['class' => 'btn btn-success']) ?>
        </p>
        </div>
        <div class="col-sm-8 col-md-9" >
            <ul class="nav nav-pills pull-right">
                <li><a href="<?= Url::to(['/spending/category/index']) ?>">Категории</a></li>
                <li class="active"><a href="<?= Url::to(['/spending/spending/index']) ?>">Затраты</a></li>
            </ul>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <?php echo GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [

                    ['attribute' => 'id', 'filter' => false, 'options' => ['style' => 'width: 55px;']],
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
                    ['attribute' => 'amount', 'filter' => false, 'options' => ['style' => 'width: 70px;']],
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

                    //['class' => 'yii\grid\ActionColumn'],
                ],
            ]); ?>
        </div>
    </div>


</div>
