<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ObjektLog;
use app\models\User;
use app\models\ParentOrg; 

/**
 * ObjeklogSearch represents the model behind the search form of `app\models\ObjektLog`.
 */
class ObjeklogSearch extends ObjektLog
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'date', 'id_user', 'id_objekt', 'id_obl'], 'integer'],
            [['changet_colum', 'coment'], 'safe'],
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
        $query = ObjektLog::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=>[
                'defaultOrder'=>[
                     'id'=>SORT_DESC
                ]
            ],
            'pagination' => [
                'forcePageParam' => false,
                'pageSizeParam' => false,
                'pageSize' => 40
            ]
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
            'date' => $this->date,
            'id_user' => $this->id_user,
            'id_objekt' => $this->id_objekt,
            'id_obl' => $this->id_obl,
        ]);

        $query->andFilterWhere(['like', 'changet_colum', $this->changet_colum])
            ->andFilterWhere(['like', 'coment', $this->coment]);

        return $dataProvider;
    }

    public function search_obj_historu($id, $params)   //історія по конкретному обєкту
    {
        $query = ObjektLog::find()->where(['id_objekt'=>$id]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=>[
                'defaultOrder'=>[
                     'id'=>SORT_DESC
                ]
            ],
            'pagination' => [
                'forcePageParam' => false,
                'pageSizeParam' => false,
                'pageSize' => 40
            ]
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
            'date' => $this->date,
            'id_user' => $this->id_user,
            'id_objekt' => $this->id_objekt,
            'id_obl' => $this->id_obl,
        ]);

        $query->andFilterWhere(['like', 'changet_colum', $this->changet_colum])
            ->andFilterWhere(['like', 'coment', $this->coment]);

        return $dataProvider;
    }
    public function search_obl_historu( $params)
    {
        $query = ObjektLog::find()->where(['id_obl'=>User::findOne(Yii::$app->user->id)->id_organization]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=>[
                'defaultOrder'=>[
                     'id'=>SORT_DESC
                ]
            ],
            'pagination' => [
                'forcePageParam' => false,
                'pageSizeParam' => false,
                'pageSize' => 40
            ]
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
            'date' => $this->date,
            'id_user' => $this->id_user,
            'id_objekt' => $this->id_objekt,
            'id_obl' => $this->id_obl,
        ]);

        $query->andFilterWhere(['like', 'changet_colum', $this->changet_colum])
            ->andFilterWhere(['like', 'coment', $this->coment]);

        return $dataProvider;
    }

    public function search_pidr_historu($params)   // Для подрядчика
    {
        $query = ObjektLog::find()->where(['AND',['id_pidr'=>User::findOne(Yii::$app->user->id)->id_organization],  ['>','priority',0]]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=>[
                'defaultOrder'=>[
                     'id'=>SORT_DESC
                ]
            ],
            'pagination' => [
                'forcePageParam' => false,
                'pageSizeParam' => false,
                'pageSize' => 40
            ]
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
            'date' => $this->date,
            'id_user' => $this->id_user,
            'id_objekt' => $this->id_objekt,
            'id_obl' => $this->id_obl,
        ]);

        $query->andFilterWhere(['like', 'changet_colum', $this->changet_colum])
            ->andFilterWhere(['like', 'coment', $this->coment]);

        return $dataProvider;
    }
}
