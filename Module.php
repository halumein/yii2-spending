<?php

namespace halumein\spending;

class Module extends \yii\base\Module
{
    public $userForSpending = '\common\models\User';
    public $cashboxModel = '\halumein\cashbox\models\Cashbox';

    public function init()
    {
        parent::init();

    }
}
