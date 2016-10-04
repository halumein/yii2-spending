<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model halumein\spending\models\Spending */

$this->title = 'Update Spending: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Spendings', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="spending-update">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
