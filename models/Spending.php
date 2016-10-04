<?php

namespace halumein\spending\models;

use Yii;

/**
 * This is the model class for table "spending_spending".
 *
 * @property integer $id
 * @property string $date
 * @property integer $category_id
 * @property string $name
 * @property string $amount
 * @property string $cost
 * @property integer $cashbox_id
 * @property integer $user_id
 */
class Spending extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'spending_spending';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['date', 'category_id', 'name', 'user_id'], 'required'],
            [['date'], 'safe'],
            [['category_id', 'cashbox_id', 'user_id'], 'integer'],
            [['amount', 'cost'], 'number'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'date' => 'Дата',
            'category_id' => 'Категория',
            'name' => 'Наименование',
            'amount' => 'Кол-во',
            'cost' => 'Стоимость',
            'cashbox_id' => 'Касса',
            'user_id' => 'Пользователь',
        ];
    }

    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }

    public function getUser()
    {
        $userForSpending = Yii::$app->getModule('spending')->userForSpending;
        return $this->hasOne($userForSpending::className(), ['id' => 'user_id']);
    }

    public function getCashbox()
    {
        $cashboxModel = Yii::$app->getModule('spending')->cashboxModel;
        return $this->hasOne($cashboxModel::className(), ['id' => 'cashbox_id']);
    }
}
