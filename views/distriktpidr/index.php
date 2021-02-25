<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use app\models\Organizations;

/* @var $this yii\web\View */
/* @var $searchModel app\models\DistriktpidrSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Райони підрядників';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="distrikt-pidr-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Створити район', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'title:ntext',

            ['attribute'=>'id_pidr',
                'value'=> function($data){
                    return Organizations::findOne($data->id_pidr)->title;
                  
                 },
            'filter' => Html::activeDropDownList(
                    $searchModel,
                    'id_pidr',
                    ArrayHelper::map(Organizations::find()->where(['tupe'=>2])->all(), 'id', 'title'),
                    ['class' => 'form-control', 'prompt' => 'Всі']
                ),
            ],

             ['attribute'=>'id_obl',
                'value'=> function($data){
                    return Organizations::findOne($data->id_obl)->title;
                  
                 },
            'filter' => Html::activeDropDownList(
                    $searchModel,
                    'id_obl',
                    ArrayHelper::map(Organizations::find()->where(['tupe'=>1])->all(), 'id', 'title'),
                    ['class' => 'form-control', 'prompt' => 'Всі']
                ),
            ],
          //  'id_pidr',
          //'id_obl',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
