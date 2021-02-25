<?php

namespace app\models;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Main;
use app\models\User;
use app\models\ParentOrg;   

/**
 * MainSearch represents the model behind the search form of `app\models\Main`.
 */
class MainSearch extends Main
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'pidr', 'status_pidr', 'status_dir_sc', 'status_objekt', 'id_obl',  'id_project_type'], 'integer'],
            [['title', 'adress', 'n_dogoovor', 'files_pojekt', 'file_resoyrs_report'], 'safe'],
            [['price_dogovor', 'price_pidr'], 'number'],
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
        $query = Main::find();

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
                'pageSize' => 20
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
            'price_dogovor' => $this->price_dogovor,
            'price_pidr' => $this->price_pidr,
            'pidr' => $this->pidr,
            'status_pidr' => $this->status_pidr,
            'status_dir_sc' => $this->status_dir_sc,
            'status_objekt' => $this->status_objekt,
            'id_obl' => $this->id_obl,
          //  'date_create' => $this->date_create,
            'id_project_type' => $this->id_project_type,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'adress', $this->adress])
            ->andFilterWhere(['like', 'n_dogoovor', $this->n_dogoovor])
            ->andFilterWhere(['like', 'files_pojekt', $this->files_pojekt])
            ->andFilterWhere(['like', 'file_resoyrs_report', $this->file_resoyrs_report]);

        return $dataProvider;
    }
    public function searchobl($params)  //сортировка обленрго
    {
        $query = Main::find()->where(['id_obl'=>User::findOne(Yii::$app->user->id)->id_organization]);

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
                'pageSize' => 20
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
            'price_dogovor' => $this->price_dogovor,
            'price_pidr' => $this->price_pidr,
            'pidr' => $this->pidr,
            'status_pidr' => $this->status_pidr,
            'status_objekt' => $this->status_objekt,
            'id_obl' => $this->id_obl,
            'date_create' => $this->date_create,
            'id_project_type' => $this->id_project_type,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'adress', $this->adress])
            ->andFilterWhere(['like', 'n_dogoovor', $this->n_dogoovor])
            ->andFilterWhere(['like', 'files_pojekt', $this->files_pojekt])
            ->andFilterWhere(['like', 'file_resoyrs_report', $this->file_resoyrs_report]);

        return $dataProvider;
    }
    public function searchpr($params)  //сортировка обленрго
    {
        $query = Main::find()->where(['id_obl'=>User::findOne(Yii::$app->user->id)->id_organization]);

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
                'pageSize' => 20
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
            'price_dogovor' => $this->price_dogovor,
            'price_pidr' => $this->price_pidr,
            'pidr' => $this->pidr,
            'status_pidr' => $this->status_pidr,
            'status_objekt' => $this->status_objekt,
            'id_obl' => $this->id_obl,
            'date_create' => $this->date_create,
            'id_project_type' => $this->id_project_type,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'adress', $this->adress])
            ->andFilterWhere(['like', 'n_dogoovor', $this->n_dogoovor])
            ->andFilterWhere(['like', 'files_pojekt', $this->files_pojekt])
            ->andFilterWhere(['like', 'file_resoyrs_report', $this->file_resoyrs_report]);

        return $dataProvider;
    }
    public function searchorg($params)  // сортировка для подрядчика
    {
     //   $query = Main::find()->where(['pidr'=>User::findOne(Yii::$app->user->id)->id_organization]);

       //  $query = Main::find()->where(['OR',['pidr'=>User::findOne(Yii::$app->user->id)->id_organization], ['status_pidr'=>2 ]]);

        $query = Main::find()->where(['OR',['pidr'=>User::findOne(Yii::$app->user->id)->id_organization], ['AND', ['id_obl'=>ParentOrg::GetOblPidr(User::findOne(Yii::$app->user->id)->id_organization)], ['status_pidr'=>2 ]]]);

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
                'pageSize' => 20
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
            'price_dogovor' => $this->price_dogovor,
            'price_pidr' => $this->price_pidr,
            'pidr' => $this->pidr,
            'status_pidr' => $this->status_pidr,
            'status_objekt' => $this->status_objekt,
            'id_obl' => $this->id_obl,
           // 'date_create' => $this->date_create,
            'id_project_type' => $this->id_project_type,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'adress', $this->adress])
            ->andFilterWhere(['like', 'n_dogoovor', $this->n_dogoovor])
            ->andFilterWhere(['like', 'files_pojekt', $this->files_pojekt])
            ->andFilterWhere(['like', 'file_resoyrs_report', $this->file_resoyrs_report]);

        return $dataProvider;
    }
	
	public function searcbasket($params)  // сортировка для корзины
    {
     //   $query = Main::find()->where(['pidr'=>User::findOne(Yii::$app->user->id)->id_organization]);

       //  $query = Main::find()->where(['OR',['pidr'=>User::findOne(Yii::$app->user->id)->id_organization], ['status_pidr'=>2 ]]);

        $obl=ParentOrg::GetOblPidr(User::findOne(Yii::$app->user->id)->id_organization);
        if(empty($obl)){
            $obl[]=User::findOne(Yii::$app->user->id)->id_organization;
            //echo "$obl";
        }

        $query = Main::find()->where(['AND', ['id_obl'=>$obl], ['OR',['status_pidr'=>2], ['status_pidr'=>4]]]);

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
                'pageSize' => 20
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
            'price_dogovor' => $this->price_dogovor,
            'price_pidr' => $this->price_pidr,
            'pidr' => $this->pidr,
            'status_pidr' => $this->status_pidr,
            'status_objekt' => $this->status_objekt,
            'id_obl' => $this->id_obl,
            'date_create' => $this->date_create,
            'id_project_type' => $this->id_project_type,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'adress', $this->adress])
            ->andFilterWhere(['like', 'n_dogoovor', $this->n_dogoovor])
            ->andFilterWhere(['like', 'files_pojekt', $this->files_pojekt])
            ->andFilterWhere(['like', 'file_resoyrs_report', $this->file_resoyrs_report]);

        return $dataProvider;
    }
	public function searcbasketadmin($params)  // сортировка для корзины админа
    {
     //   $query = Main::find()->where(['pidr'=>User::findOne(Yii::$app->user->id)->id_organization]);

       //  $query = Main::find()->where(['OR',['pidr'=>User::findOne(Yii::$app->user->id)->id_organization], ['status_pidr'=>2 ]]);

        $query = Main::find()->where(['OR',['status_pidr'=>2], ['status_pidr'=>4]]);

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
                'pageSize' => 20
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
            'price_dogovor' => $this->price_dogovor,
            'price_pidr' => $this->price_pidr,
            'pidr' => $this->pidr,
            'status_pidr' => $this->status_pidr,
            'status_objekt' => $this->status_objekt,
            'id_obl' => $this->id_obl,
            'date_create' => $this->date_create,
            'id_project_type' => $this->id_project_type,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'adress', $this->adress])
            ->andFilterWhere(['like', 'n_dogoovor', $this->n_dogoovor])
            ->andFilterWhere(['like', 'files_pojekt', $this->files_pojekt])
            ->andFilterWhere(['like', 'file_resoyrs_report', $this->file_resoyrs_report]);

        return $dataProvider;
    }
}
