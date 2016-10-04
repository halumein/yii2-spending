<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model halumein\spending\models\Spending */

$this->title = 'Добавить затраты';
$this->params['breadcrumbs'][] = ['label' => 'Затраты', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="spending-create">

    <?php echo $this->render('_form', [
        'model' => $model,
        'data' => $data,
        'activeCashboxes' => $activeCashboxes,
    ]) ?>

</div>
