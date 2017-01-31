<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use halumein\spending\models\Category;
use yii\helpers\ArrayHelper;
use nex\datepicker\DatePicker;

if($dateStart = yii::$app->request->get('date_start')) {
    $dateStart = date('d.m.Y', strtotime($dateStart));
}

if($dateStop = yii::$app->request->get('date_stop')) {
    $dateStop = date('d.m.Y', strtotime($dateStop));
}
$totalSum = 0;
/* @var $this yii\web\View */
/* @var $searchModel halumein\spending\models\search\SpendingSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Затраты';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="spending-index">

    <div class="row">
        <div class="col-sm-4 col-md-3">
        <p>
            <?php // echo Html::a('Добавить затрату', ['create'], ['class' => 'btn btn-success']) ?>
        </p>
        </div>
        <div class="col-sm-8 col-md-9" >
            <ul class="nav nav-pills pull-right">
                <li><a href="<?= Url::to(['/spending/category/index']) ?>">Категории</a></li>
                <li class="active"><a href="<?= Url::to(['/spending/spending/index']) ?>">Затраты</a></li>
            </ul>
        </div>
    </div>
    <br>
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title"><a href="#" onclick="$('.spending-add-body').toggleClass('hidden'); return false;">Добавить затрату</a></h3>
        </div>
        <div class="spending-add-body panel-body hidden">
            <?php echo $this->render('_form', [
                'model' => $newSpendingModel,
                'data' => $data,
                'activeCashboxes' => $activeCashboxes,
            ]) ?>
        </div>
    </div>

    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title"><a href="#" onclick="$('.spending-search-body').toggleClass('hidden'); return false;">Поиск</a></h3>
        </div>
        <div class="panel-body spending-search-body <?= $showSearch ? '' : 'hidden' ?>">
            <form class="row search">
                <input type="hidden" name="SpendingSearch[name]" value="" />
                <div class="col-md-4">
                    <div class="row">
                        <div class="col-md-6">
                            <?= DatePicker::widget([
                                'name' => 'date_start',
                                'addon' => false,
                                'value' => $dateStart,
                                'size' => 'sm',
                                'language' => 'ru',
                                'placeholder' => yii::t('order', 'Date from'),
                                'clientOptions' => [
                                    'format' => 'L',
                                    'minDate' => '2015-01-01',
                                    'maxDate' => date('Y-m-d'),
                                ],
                                'dropdownItems' => [
                                    ['label' => 'Yesterday', 'url' => '#', 'value' => \Yii::$app->formatter->asDate('-1 day')],
                                    ['label' => 'Tomorrow', 'url' => '#', 'value' => \Yii::$app->formatter->asDate('+1 day')],
                                    ['label' => 'Some value', 'url' => '#', 'value' => 'Special value'],
                                ],
                            ]);?>
                        </div>
                        <div class="col-md-6">
                            <?= DatePicker::widget([
                                'name' => 'date_stop',
                                'addon' => false,
                                'value' => $dateStop,
                                'size' => 'sm',
                                'placeholder' => yii::t('order', 'Date to'),
                                'language' => 'ru',
                                'clientOptions' => [
                                    'format' => 'L',
                                    'minDate' => '2015-01-01',
                                    'maxDate' => date('Y-m-d'),
                                ],
                                'dropdownItems' => [
                                    ['label' => yii::t('order', 'Yesterday'), 'url' => '#', 'value' => \Yii::$app->formatter->asDate('-1 day')],
                                    ['label' => yii::t('order', 'Tomorrow'), 'url' => '#', 'value' => \Yii::$app->formatter->asDate('+1 day')],
                                    ['label' => yii::t('order', 'Some value'), 'url' => '#', 'value' => 'Special value'],
                                ],
                            ]);?>
                        </div>
                    </div>
                </div>

                <div class="col-md-2">
                    <input class="form-control btn-success" type="submit" value="Поиск" />
                </div>

                <div class="col-md-3">
                    <a class="btn btn-default form-control text-center" href="<?= Url::to(['/spending/spending/index']) ?>">Cбросить все фильтры</a>
                </div>
            </form>
        </div>
    </div>

    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title"><a href="#" onclick="$('.spending-statistics-body').toggleClass('hidden'); return false;"><?=yii::t('order', 'Statistics');?></a></h3>
        </div>
        <div class="spending-statistics-body panel-body hidden">
            <table class="table table-stripped table-bordered">
                <thead>
                    <th>Категория</th>
                    <th>Сумма за период</th>
                </thead>
                <tbody>
                    <?php foreach ($statistic['totals'] as $key => $total) { ?>
                        <?php if ((int)$total['sum'] > 0){ ?>
                            <?php $totalSum += (int)$total['sum']; ?>
                            <tr>
                                <td><?= $total['name'] ?></td>
                                <td><?= $total['sum'] ?></td>
                            </tr>
                        <?php } ?>
                    <?php } ?>
                    <tr>
                        <td><strong>Итого за период:</strong></td>
                        <td><strong><?= $totalSum ?></strong></td>
                    </tr>

                </tbody>
            </table>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
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
                    [
                        'attribute' => 'date',
                        'filter' => false,
                        'format' => 'raw',
                        'value' => function($model) {
                            return date('d.m.Y H:i:s', strtotime($model->date));
                        }
                    ],
                    // ['attribute' => 'amount', 'filter' => false, 'options' => ['style' => 'width: 70px;']],
                    [
                        'attribute' => 'cost',
                        'filter' => false,
                        'footer' => $statistic['costSumByPage'],
                        'options' => ['style' => 'width: 100px;'],
                    ],
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
                    [
                        'attribute' => 'deleted',
                        'content' => function($model) {
                            if ($model->deleted != null) {
                                return 'операция отменена';
                            } else {
                                if(empty($model->model)) {
                                    return '<a href="'.Url::toRoute(['/spending/spending/delete', 'id' => $model->id]).'" class="btn btn-danger" title="Отменить" aria-label="Отменить" data-pjax="0" data-confirm="Вы уверены, что хотите отменить эту операцию?" data-method="post"><i class="glyphicon glyphicon-remove-sign" /></a>';
                                }
                                return "";
                            }
                        }
                    ],
                    //['class' => 'yii\grid\ActionColumn'],
                ],
                'showFooter'=>true,
            ]); ?>

        </div>
    </div>


</div>
