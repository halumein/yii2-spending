<?php
namespace halumein\spending;

use yii\base\Component;
use halumein\spending\models\Spending as SpendingModel;
use halumein\spending\interfaces\Spending as SpendingInterface;

class Spending implements SpendingInterface
{
    public function init()
    {
        parent::init();
    }

    public function add($params)
    {
        $model = new SpendingModel();

        $model->category_id = $params['category_id'];
        $model->cashbox_id  = $params['cashbox_id'];
        $model->name        = $params['name'];
        $model->amount      = $params['amount'];
        $model->cost        = $params['cost'];
        $model->user_id     = \Yii::$app->user->id;
        $model->date        = date("Y-m-d H:i:s");

        if ($model->save()) {
            return [
                'status' => 'success'
            ];
        } else {
            return [
                'status' => 'error',
                'error' => $model->errors
            ];
        }
    }
}
