<?php
namespace halumein\spending;

use yii;
use yii\base\BootstrapInterface;

class Bootstrap implements BootstrapInterface
{
    public function bootstrap($app)
    {
        if(!$app->has('spending')) {
            $app->set('spending', ['class' => 'halumein\spending\Spending']);
        }

    }
}
