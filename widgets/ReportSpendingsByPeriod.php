<?php
namespace halumein\spending\widgets;

use yii;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use halumein\spending\models\Spending;
use halumein\spending\models\search\SpendingSearch;

class ReportSpendingsByPeriod extends \yii\base\Widget
{
    public $dateStart;
    public $dateStop;
    public $simple = false;

    public function init()
    {
        if(!$this->dateStop) {
            $this->dateStop = date('Y-m-d H:i:s');
        }
        
        return parent::init();
    }

    public function run()
    {
        $searchModel = new SpendingSearch();
        $dataProvider = $searchModel->search(yii::$app->request->get());
        
        $dataProvider->query->andWhere('date >= :dateStart', [':dateStart' => $this->dateStart]);
        $dataProvider->query->andWhere('date <= :dateStop', [':dateStop' => $this->dateStop]);

        $userModelModel = yii::$app->getModule('spending')->userModel;
        $activeUsers = $userModelModel::find()->active()->all();

        $cashboxClassName = yii::$app->getModule('spending')->cashboxModel;
        $cashboxModel = new $cashboxClassName;
        $activeCashboxes = $cashboxModel->activeCashboxes;

        $dataProvider->query->orderBy(['id' => SORT_DESC]);

        return $this->render('reportSpendingsByPeriod', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'activeUsers' => $activeUsers,
            'activeCashboxes' => $activeCashboxes,
            'simple' => $this->simple,
        ]);
    }
}
