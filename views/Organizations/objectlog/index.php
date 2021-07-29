<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use app\models\Organizations;
use app\models\Main;
use app\models\Users;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ObjeklogSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Objekt Logs';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="objekt-log-index">

    <h1><?= Html::encode($this->title) ?></h1>

    

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

          //  'id',
           // 'date',
            ['label'=>'Дата',
            
            'attribute' => 'date',
                'value'=> function($data){
                return date('d.m.Y', $data->date);   
                 }
            ],
           // 'id_user',
            ['label'=>'Хто',
            
            'attribute' => 'id_user',
                'value'=> function($data){
                return Users::findOne($data->id_user)->title;
                 }
            ],


          //  'id_objekt',
            ['label'=>'№ Договору',
            
            'attribute' => 'id_objekt',
                'value'=> function($data){
                return Main::findOne($data->id_objekt)->n_dogoovor;
                 }
            ],



           // 'id_obl',
            'changet_colum:ntext',
            //'coment:ntext',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
