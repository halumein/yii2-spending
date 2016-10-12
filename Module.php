<?php

namespace halumein\spending;

class Module extends \yii\base\Module
{
    public $userModel = '\common\models\User';
    public $adminRoles = ['superadmin', 'admin'];
    public $cashboxModel = '\halumein\cashbox\models\Cashbox';

    public function init()
    {
        parent::init();

    }
}
