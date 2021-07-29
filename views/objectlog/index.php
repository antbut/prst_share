<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use app\models\Organizations;
use app\models\Main;
use app\models\User;
use yii\data\Pagination;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ObjeklogSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Зміни по обєктам';
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
                'visible' => Yii::$app->user->can('admin'),
                'value'=> function($data){
                return User::findOne($data->id_user)->view_name;
                 }
            ],


          //  'id_objekt',

            ['label'=>'назва',
                'format' => 'raw',
                
                'value'=> function($data){
                
                return Html::a(Html::encode(Main::findOne($data->id_objekt)->title),Url::to(['main/view','id'=>$data->id_objekt]));
                 }
            ],

            ['label'=>'№ Договору',
                'format' => 'raw',
            'attribute' => 'id_objekt',
                'value'=> function($data){
                
                return Html::a(Html::encode(Main::findOne($data->id_objekt)->n_dogoovor),Url::to(['main/view','id'=>$data->id_objekt]));
                 }
            ],

            ['label'=>'Обленерго',
            'filter' => ArrayHelper::map(Organizations::find()->where(['tupe'=>1])->all(), 'id', 'title'),
            'attribute' => 'id_obl',
                'value'=> function($data){
                return  Organizations::findOne($data->id_obl)->title;   
                 },
                 
            ],



           // 'id_obl',
            

            ['label'=>'зміни',
            
            'attribute' => 'changet_colum',
                'value'=> function($data){
                    $text='';
                    if($data->coment==null){
                        if(strpos($data->changet_colum,'"pidr"')){
                            $text=$text.' змінено підрядника';
                        }
                        if(strpos($data->changet_colum,'"status_pidr"')){
                            $text=$text.' підрядник зробив свій вибір';
                        }
                        if(strpos($data->changet_colum,'price_dogovor')){
                            $text=$text.' змінено ціну договору початкову';
                        }
                        if(strpos($data->changet_colum,'price_dogovor_end')){
                            $text=$text.' змінено ціну договору остаточну';
                        }
                        if(strpos($data->changet_colum,'price_pidr')){
                            $text=$text.' змінено ціну підрядника початков';
                        }
                        if(strpos($data->changet_colum,'price_pidr_end')){
                            $text=$text.' змінено ціну підрядника остаточну';
                        }
                        if(strpos($data->changet_colum,'files_smeta')){
                            $text=$text.' додано файли смети';
                        }
                        if(strpos($data->changet_colum,'file_resoyrs_report')){
                            $text=$text.' додано файли відомості обєму робіт';
                        }
                        if(strpos($data->changet_colum,'files_pojekt')){
                            $text=$text.' додано файли проекту';
                        }
                        if(strpos($data->changet_colum,'title')){
                            $text=$text.' змінено назву обєкту';
                        }
                        if(strpos($data->changet_colum,'adress')){
                            $text=$text.' змінено адресу обєкту';
                        }
                        if(strpos($data->changet_colum,'id_district')){
                            $text=$text.' змінено район обєкту';
                        }
                        if(strpos($data->changet_colum,'date_payment')){
                            $text=$text.' змінено дату оплати';
                        }
                        if(strpos($data->changet_colum,'id_project_type')){
                            $text=$text.' змінено тип обєкту';
                        }

                        



                        if(strpos($data->changet_colum,'status_dir_sc')){
                            if(strpos($data->changet_colum,'pidr')){
                                $text=' Графік робіт не отримано';
                            }else{
                                $text=' Підтверджено отримання графіка робіт';
                            }
                            
                        }

                        if(strpos($data->changet_colum,'status_objekt')){
                            $text=$text.' змінено статус обєкту';
                        }

                        
                    }else{
                        $text=$data->coment;
                    }

                return $text;
                 }
            ],

          //  'changet_colum:ntext',
          //  'priority',
            [
            'attribute' => 'priority',
                'visible' => Yii::$app->user->can('admin'),
                'value'=> function($data){
                return $data->priority;
                 }
            ],

            [
            'attribute' => 'changet_colum',
                'visible' => Yii::$app->user->can('admin'),
                'value'=> function($data){
                return $data->changet_colum;
                 }
            ],

            //'coment:ntext',

            ['class' => 'yii\grid\ActionColumn',

                'template' => '{view}',
            ],
        ],
    ]); ?>


</div>
