<?php

namespace halumein\spending;

class Module extends \yii\base\Module
{

    const EVENT_SPENDING_CEATE = 'create';


    public $userModel = '\common\models\User';
    public $adminRoles = ['superadmin', 'admin'];
    public $cashboxModel = '\halumein\cashbox\models\Cashbox';

    public function init()
    {
        parent::init();
    }
}
