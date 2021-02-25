<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Organizations;
use app\models\User;
use yii\helpers\ArrayHelper;
use app\models\SysParam;
use app\models\KoeficOrder;


/* @var $this yii\web\View */
/* @var $searchModel app\models\KoeficOrderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Коефіціенти для обленерго');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="koefic-order-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Задати новий коефіціент'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <h4>Встановлені коефіціенти</h4><br>
    <table>
    <tr><td>Віницяобленерго </td><td> <? echo KoeficOrder::findOne(SysParam::GetParam('id_kurent_koef_VOE'))->value; ?></td></tr>
    <tr><td>Cумиобленерго  </td><td><? echo KoeficOrder::findOne(SysParam::GetParam('id_kurent_koef_SOE'))->value; ?></td></tr>
    <tr><td>Чернігівобленерго </td><td> <? echo KoeficOrder::findOne(SysParam::GetParam('id_kurent_koef_CHOE'))->value; ?></td></tr>
    <tr><td>Луганськобленерго </td><td> <? echo KoeficOrder::findOne(SysParam::GetParam('id_kurent_koef_LG'))->value; ?></td></tr>
    <tr><td>Центральна енергокомпанія </td><td> <? echo KoeficOrder::findOne(SysParam::GetParam('id_kurent_koef_CEK'))->value; ?></td></tr>
    </table><br>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

           // 'id',
          //  'date_create',
            ['label'=>'Дата створення',
                'attribute'=>'date_create',
                'value'=> function($data){
                return date('d.m.Y', $data->date_create);   
                 }
            ],
            ['label'=>'Обленерго',
            'attribute'=>'id_obl',
            'filter' => ArrayHelper::map(Organizations::find()->where(['tupe'=>1])->all(), 'id', 'title'),
                'value'=> function($data){
                return  Organizations::findOne($data->id_obl)->title;   
                 }
            ],
            'value',
            
           // 'id_creator',
            ['label'=>'Задав',
                'attribute'=>'id_creator',
                'value'=> function($data){
                return  User::findOne($data->id_creator)->view_name;   
                 }
            ],
            

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
