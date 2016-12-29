<?php
namespace halumein\spending;

use halumein\cashbox\models\Cashbox;
use yii\base\Component;
use halumein\spending\models\Spending as SpendingModel;
use halumein\spending\interfaces\Spending as SpendingInterface;
use halumein\spending\models\Category;
use halumein\spending\events\SpendingEvent;


class Spending implements SpendingInterface
{
    public function init()
    {
        parent::init();
    }

    public function add($name, $cost, $category, $cashboxId, $params = null)
    {
        $model = new SpendingModel();

        $model->category_id = $category;
        $model->name        = $name;
        $model->cost        = $cost;
        $model->cashbox_id  = $cashboxId;
        $model->amount      = 1;
        $model->comment     = "";
        $model->model       = null;
        $model->item_id     = null;

        if (isset($params['amount'])) {
            $model->amount = $params['amount'];
        }

        if (isset($params['comment'])) {
            $model->comment = $params['comment'];
        }

        if (isset($params['model'])) {
            $model->model = $params['model'];
        }

        if (isset($params['item_id'])) {
            $model->item_id = $params['item_id'];
        }

        $model->user_id     = \Yii::$app->user->id;
        $model->date        = date("Y-m-d H:i:s");

        if ($model->save()) {

            $module = \Yii::$app->getModule('spending');
            $spendingEvent = new SpendingEvent(['model' => $model]);
            $module->trigger($module::EVENT_SPENDING_CEATE, $spendingEvent);

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

    public function rollbackSpendingByModelAndId($model, $itemId)
    {
        $model = SpendingModel::find()->where(['model' => $model, 'item_id' => $itemId])->one();

        if ($model) {
            $this->remove($model->id);
        } else {
            return true;
        }
    }

    public function remove($spendingId)
    {
        $model = SpendingModel::findOne($spendingId);

        if ($model) {
            $module = \Yii::$app->getModule('spending');
            $spendingEvent = new SpendingEvent(['model' => $model]);
            $module->trigger($module::EVENT_SPENDING_REMOVE, $spendingEvent);
            $model->deleted = date('Y-m-d H:i:m');
            return $model->save();
        } else {
            return true;
        }
    }

    public function getCategories()
    {
        return Category::find()->all();
    }

    /*
   Возвращает массив объектов ActiveRecord отобраный за заданный период.
   !!Дата передается в формате дд-мм-гггг или дд.мм.гггг!!
   Прим. параметр dateStop необязательный, если его нет то фильр отбирает записи
   только по dateStart
   */
    public function getAmountByPeriod($dateStart, $dateStop = null)
    {
        $spendingByPeriod = SpendingModel::find();

        $dateStart = date('Y-m-d H:i:s', strtotime($dateStart));
        if(!$dateStop) {
            $dateStop = date('Y-m-d H:i:s', strtotime($dateStart)+86399);
            $spendingByPeriod->andWhere('date >= :dateStart', [':dateStart' => $dateStart]);
            $spendingByPeriod->andWhere('date <= :dateStop', [':dateStop' => $dateStop]);
        } else {
            $dateStop = date('Y-m-d H:i:s', strtotime($dateStop)+86399);
            $spendingByPeriod->andWhere('date >= :dateStart', [':dateStart' => $dateStart]);
            $spendingByPeriod->andWhere('date <= :dateStop', [':dateStop' => $dateStop]);
        }
        $amountByPeriod = $spendingByPeriod->sum('amount');

        return $amountByPeriod;
    }

    /*
   Возвращает массив объектов ActiveRecord отобраный за заданный период.
   !!Дата передается в формате дд-мм-гггг или дд.мм.гггг!!
   Прим. параметр dateStop необязательный, если его нет то фильр отбирает записи
   только по dateStart
   */
    public function getSumByPeriod($dateStart, $dateStop = null)
    {
        $spendingByPeriod = SpendingModel::find();

        $dateStart = date('Y-m-d H:i:s', strtotime($dateStart));
        if(!$dateStop) {
            $dateStop = date('Y-m-d H:i:s', strtotime($dateStart)+86399);
            $spendingByPeriod->andWhere('date >= :dateStart', [':dateStart' => $dateStart]);
            $spendingByPeriod->andWhere('date <= :dateStop', [':dateStop' => $dateStop]);
        } else {
            $dateStop = date('Y-m-d H:i:s', strtotime($dateStop)+86399);
            $spendingByPeriod->andWhere('date >= :dateStart', [':dateStart' => $dateStart]);
            $spendingByPeriod->andWhere('date <= :dateStop', [':dateStop' => $dateStop]);
        }
        $sumByPeriod = $spendingByPeriod->sum('cost');

        return $sumByPeriod;
    }

    public function getAmountByCategory(Category $categoryModel, $dateStart = null, $dateStop = null)
    {
        $querySpendingByCategory = $categoryModel->getSpendings();
        if($dateStart){
            $dateStart = date('Y-m-d H:i:s', strtotime($dateStart));
            if(!$dateStop) {
                $dateStop = date('Y-m-d H:i:s', strtotime($dateStart)+86399);
                $querySpendingByCategory->andWhere('date >= :dateStart', [':dateStart' => $dateStart]);
                $querySpendingByCategory->andWhere('date <= :dateStop', [':dateStop' => $dateStop]);
            } else {
                $dateStop = date('Y-m-d H:i:s', strtotime($dateStop)+86399);
                $querySpendingByCategory->andWhere('date >= :dateStart', [':dateStart' => $dateStart]);
                $querySpendingByCategory->andWhere('date <= :dateStop', [':dateStop' => $dateStop]);
            }
        }

        $amountByCategory = $querySpendingByCategory->sum('amount');
        return $amountByCategory;
    }

    public function getSumByCategory(Category $categoryModel, $dateStart = null, $dateStop = null)
    {
        $querySpendingByCategory = $categoryModel->getSpendings();
        if($dateStart){
            $dateStart = date('Y-m-d H:i:s', strtotime($dateStart));
            if(!$dateStop) {
                $dateStop = date('Y-m-d H:i:s', strtotime($dateStart)+86399);
                $querySpendingByCategory->andWhere('date >= :dateStart', [':dateStart' => $dateStart]);
                $querySpendingByCategory->andWhere('date <= :dateStop', [':dateStop' => $dateStop]);
            } else {
                $dateStop = date('Y-m-d H:i:s', strtotime($dateStop)+86399);
                $querySpendingByCategory->andWhere('date >= :dateStart', [':dateStart' => $dateStart]);
                $querySpendingByCategory->andWhere('date <= :dateStop', [':dateStop' => $dateStop]);
            }
        }

        $sumByCategory = $querySpendingByCategory->sum('cost');
        return $sumByCategory;
    }

    public function getSumByCashbox($cashboxID, $dateStart = null, $dateStop = null)
    {
        $spendingByCashbox = SpendingModel::find()->where(['cashbox_id' => $cashboxID]);

        if($dateStart){
            $dateStart = date('Y-m-d H:i:s', strtotime($dateStart));
            if(!$dateStop) {
                $dateStop = date('Y-m-d H:i:s', strtotime($dateStart)+86399);
                $spendingByCashbox->andWhere('date >= :dateStart', [':dateStart' => $dateStart]);
                $spendingByCashbox->andWhere('date <= :dateStop', [':dateStop' => $dateStop]);
            } else {
                $dateStop = date('Y-m-d H:i:s', strtotime($dateStop)+86399);
                $spendingByCashbox->andWhere('date >= :dateStart', [':dateStart' => $dateStart]);
                $spendingByCashbox->andWhere('date <= :dateStop', [':dateStop' => $dateStop]);
            }
        }

        $sumByCashbox = $spendingByCashbox->sum('cost');
        return $sumByCashbox;
    }

    public function getAmountByCashbox($cashboxID, $dateStart = null, $dateStop = null)
    {
        $spendingByCashbox = SpendingModel::find()->where(['cashbox_id' => $cashboxID]);

        if($dateStart){
            $dateStart = date('Y-m-d H:i:s', strtotime($dateStart));
            if(!$dateStop) {
                $dateStop = date('Y-m-d H:i:s', strtotime($dateStart)+86399);
                $spendingByCashbox->andWhere('date >= :dateStart', [':dateStart' => $dateStart]);
                $spendingByCashbox->andWhere('date <= :dateStop', [':dateStop' => $dateStop]);
            } else {
                $dateStop = date('Y-m-d H:i:s', strtotime($dateStop)+86399);
                $spendingByCashbox->andWhere('date >= :dateStart', [':dateStart' => $dateStart]);
                $spendingByCashbox->andWhere('date <= :dateStop', [':dateStop' => $dateStop]);
            }
        }

        $amountByCashbox = $spendingByCashbox->sum('amount');
        return $amountByCashbox;
    }

    public function getSumByName($name)
    {
        $spendingByName = SpendingModel::find()->where(['name' => $name]);
        $sumByName = $spendingByName->sum('cost');
        return $sumByName;
    }

    public function getAmountByName($name)
    {
        $spendingByName = SpendingModel::find()->where(['name' => $name]);
        $amountByName = $spendingByName->sum('amount');
        return $amountByName;
    }
}
