<?php

namespace halumein\spending;

class Module extends \yii\base\Module
{

    const EVENT_SPENDING_CEATE = 'create';
    const EVENT_SPENDING_REMOVE = 'remove';


    public $userModel = '\common\models\User';
    public $adminRoles = ['superadmin', 'admin'];
    public $cashboxModel = '\halumein\cashbox\models\Cashbox';
    public $salaryCategory = 2;

    public function init()
    {
        parent::init();
    }
}
