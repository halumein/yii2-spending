Yii2-spending
==========


Модуль учта затрат


```
php composer require halumein/yii2-spending "*"
```

миграция:

```
php yii migrate --migrationPath=vendor/halumein/yii2-spending/migrations
```

В конфигурационный файл приложения добавить модуль test

```php
    'modules' => [
        'spending' => [
            'class' => 'halumein\spending\Module',
            'userModel' => 'app\models\User',
            'adminRoles' => ['superadmin', 'administrator'],
            'on create' => function($event) {
                \Yii::$app->cashbox->addTransaction('outcome', $event->model->cost, $event->model->cashbox_id);
            },
        ],
        //...
    ]
```
