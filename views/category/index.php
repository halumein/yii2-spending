<?php

use yii\helpers\Html;
use yii\grid\GridView;
use halumein\spending\models\Category;

/* @var $this yii\web\View */
/* @var $searchModel halumein\spending\models\search\CategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Категории';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php echo Html::a('Добавить категорию', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [

            ['attribute' => 'id', 'filter' => false, 'options' => ['style' => 'width: 55px;']],
            'name',
            [
                'attribute' => 'parent_id',
                'filter' => Html::activeDropDownList(
                    $searchModel,
                    'parent_id',
                    Category::buildTextTree(),
                    ['class' => 'form-control', 'prompt' => 'Все категории']
                ),
                'value' => 'parentName'
            ],

            ['class' => 'yii\grid\ActionColumn', 'template' => '{update} {delete}',  'buttonOptions' => ['class' => 'btn btn-default'], 'options' => ['style' => 'width: 105px;']],
        ],
    ]); ?>

</div>
