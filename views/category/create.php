<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model halumein\spending\models\Category */

$this->title = 'Добавить категорию';
$this->params['breadcrumbs'][] = ['label' => 'Затраты', 'url' => ['/spending/spending/index']];
$this->params['breadcrumbs'][] = ['label' => 'Категории', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-create">

    <?php echo $this->render('_form', [
        'model' => $model,
        'categories' => $categories,
    ]) ?>

</div>
