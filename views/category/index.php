<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use halumein\spending\models\Category;

/* @var $this yii\web\View */
/* @var $searchModel halumein\spending\models\search\CategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Категории';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <div class="row">
        <div class="col-sm-4 col-md-3">
            <p>
                <?php echo Html::a('Добавить категорию', ['create'], ['class' => 'btn btn-success']) ?>
            </p>
        </div>
        <div class="col-sm-8 col-md-9" >
            <ul class="nav nav-pills pull-right">
                <li class="active"><a href="<?= Url::to(['/spending/category/index']) ?>">Категории</a></li>
                <li><a href="<?= Url::to(['/spending/spending/index']) ?>">Затраты</a></li>
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
                    [
                        'attribute' => 'parent_id',
                        'filter' => Html::activeDropDownList(
                            $searchModel,
                            'parent_id',
                            Category::buildTextTree(),
                            ['class' => 'form-control', 'prompt' => 'Все категории']
                        ),
                        'value' => 'parent.name'
                        // 'format' => 'raw',
                    ],
                    'name',
                    ['class' => 'yii\grid\ActionColumn', 'template' => '{update} {delete}',  'buttonOptions' => ['class' => 'btn btn-default'], 'options' => ['style' => 'width: 105px;']],
                ],
            ]); ?>
        </div>
    </div>


</div>
