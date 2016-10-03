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
        ],
        //...
    ]
```

