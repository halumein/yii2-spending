<?php

namespace halumein\spending\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use halumein\spending\models\Spending;

/**
 * SpendingSearch represents the model behind the search form about `halumein\spending\models\Spending`.
 */
class SpendingSearch extends Spending
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'category_id', 'cashbox_id', 'user_id'], 'integer'],
            [['date', 'name'], 'safe'],
            [['amount', 'cost'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Spending::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'date' => $this->date,
            'category_id' => $this->category_id,
            'amount' => $this->amount,
            'cost' => $this->cost,
            'cashbox_id' => $this->cashbox_id,
            'user_id' => $this->user_id,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }
}
