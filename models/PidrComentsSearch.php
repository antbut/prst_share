<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\PidrComents;

/**
 * PidrComentsSearch represents the model behind the search form of `app\models\PidrComents`.
 */
class PidrComentsSearch extends PidrComents
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'id_obj', 'date_create', 'id_creator'], 'integer'],
            [['coment'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
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
        $query = PidrComents::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'id_obj' => $this->id_obj,
            'date_create' => $this->date_create,
            'id_creator' => $this->id_creator,
        ]);

        $query->andFilterWhere(['like', 'coment', $this->coment]);

        return $dataProvider;
    }
}
