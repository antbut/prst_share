<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\ProjektTupes;
use app\models\Organizations;
use app\models\ObjektStatus;
use yii\helpers\Url;
use app\models\PidrStaus;
use yii\data\Pagination;
use yii\widgets\LinkPager;
use app\models\ParentOrg;

use yii\helpers\ArrayHelper;
use kartik\export\ExportMenu;

/* @var $this yii\web\View */
/* @var $searchModel app\models\MainSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Проекти');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="main-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php //var_dump(ParentOrg::GetCostemerObl(2));?>
<br>

    <p>
        <?php if(\Yii::$app->user->can('CreateNewProjects') ){ ?>
             <?= Html::a(Yii::t('app', 'Додати проект'), ['create'], ['class' => 'btn btn-success']) ?>
        <?php } ?>
		
		<?= Html::a(Yii::t('app', 'Загальна Корзина'), ['commonbasket'], ['class' => 'btn btn-primary']) ?>

         <?php if(\Yii::$app->user->can('admin') ){ ?>
             <?php
                /*    echo ExportMenu::widget([
                        'dataProvider' => $dataProvider,
                        'columns' => $gridColumns,
                    ]);

                        $gridColumns = [
                            ['class' => 'kartik\grid\SerialColumn'],
                            'id',
                            'name',
                            [
                                'attribute'=>'author_id',
                                'label'=>'Author',
                                'vAlign'=>'middle',
                                'width'=>'190px',
                                'value'=>function ($model, $key, $index, $widget) { 
                                    return Html::a($model->author->name, '#', []);
                                },
                                'format'=>'raw'
                            ],
                            'color',
                            'publish_date',
                            'status',
                            ['attribute'=>'buy_amount','format'=>['decimal',2], 'hAlign'=>'right', 'width'=>'110px'],
                            ['attribute'=>'sell_amount','format'=>['decimal',2], 'hAlign'=>'right', 'width'=>'110px'],
                            ['class' => 'kartik\grid\ActionColumn', 'urlCreator'=>function(){return '#';}]
                        ];*/
             ?>
        <?php } ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

           // 'id',
        //    'date_create',

            ['label'=>'Дата створення',
            
            'attribute' => 'date_create',
                'value'=> function($data){
                return date('d.m.Y', $data->date_create);   
                 }
            ],
			
			[
			'attribute' => 'date_last_update',
                'value'=> function($data){
                return ($data->date_last_update!=0 ? date('d.m.Y', $data->date_last_update) : 'Нема змін');   
                 }
            ],
			
            'title:ntext',
            'adress:ntext',
            'n_dogoovor',

          //  'price_dogovor',
            [
                'attribute' => 'price_dogovor',
                'visible' => Yii::$app->user->can('viewPrices'),
            ],
          //  'price_pidr',
            [
                'attribute' => 'price_pidr',
                'visible' => Yii::$app->user->can('viewPrices'),
            ],
           // 'pidr',
            [
                'attribute' => 'price_dogovor_end',
                'visible' => Yii::$app->user->can('viewPrices'),
            ],
          //  'price_pidr',
            [
                'attribute' => 'price_pidr_end',
                'visible' => Yii::$app->user->can('viewPrices'),
            ],
            ['label'=>'Підрядник',
                'attribute' => 'pidr',
                'filter' => ArrayHelper::map(Organizations::find()->where(['tupe'=>2])->all(), 'id', 'title'),
                'visible' => Yii::$app->user->can('viewPidryadnukObjekt'),
                'value'=> function($data){
                return  Organizations::findOne($data->pidr)->title;   
                 }
            ],
         //   'status_pidr',
            [
              //  'label' => 'Рішення підрядника',
                'attribute' => 'status_pidr',
                'format' => 'raw',
                'filter' => ArrayHelper::map(PidrStaus::find()->all(), 'id', 'title'),
                'visible' => Yii::$app->user->can('viewStatysPidryadnik'),
                'value' => function($data){
                    return Html::img(Url::toRoute(PidrStaus::findOne($data->status_pidr)->url),[
                        'alt'=>PidrStaus::findOne($data->status_pidr)->title,
                        'style' => 'width:25px; margin: auto;'
                    ]);
                },
            ],
           // 'status_objekt',

            [
                'label' => 'Статус Обєкта',
                'attribute' => 'status_objekt',
                'filter' => ArrayHelper::map(ObjektStatus::find()->all(), 'id', 'title'),
                'format' => 'raw',
                'visible' => Yii::$app->user->can('viewFullObjektStatus'),
                'value' => function($data){
                    return Html::img(Url::toRoute(ObjektStatus::findOne($data->status_objekt)->icon_url),[
                        'alt'=>ObjektStatus::findOne($data->status_objekt)->title,
                        'style' => 'width:25px; margin: auto;'
                    ]);
                },
                'contentOptions' => function ($data, $key, $index, $column) {
                     return ['style' => 'background-color:' 
                             . ObjektStatus::findOne($data->status_objekt)->color];
                        },
            ],
            //'id_obl',
            
            //'files_pojekt:ntext',
           // 'id_project_type',
            ['label'=>'Тип проекту',
                'attribute' => 'id_project_type',
                'filter' => ArrayHelper::map(ProjektTupes::find()->all(), 'id', 'title'),
                'value'=> function($data){
                return  ProjektTupes::findOne($data->id_project_type)->title;   
                 }
            ],
			
			[
                'label' => 'час на Рішення підрядника',
                //'attribute' => 'status_pidr',
                'format' => 'raw',
                //'filter' => ArrayHelper::map(PidrStaus::find()->all(), 'id', 'title'),
                'visible' => Yii::$app->user->can('viewStatysPidryadnik'),
                'value' => function($data){
					if ($data->data_add_dok_poj!=0){
						if(time()- $data->data_add_dok_poj<432000 ){
							
								$secs=  ($data->data_add_dok_poj+432000)- time();
								$res = array();
	
								$res['days'] = floor($secs / 86400);
								$secs = $secs % 86400;
								
								$res['hours'] = floor($secs / 3600);
								$secs = $secs % 3600;
							 
								$res['minutes'] = floor($secs / 60);
								$res['secs'] = $secs % 60;
							
							return $res['days'].' д '.$res['hours'].' г';
						}else{
							return 'Час вичерпано' ;
						}
					}else{
						return '' ;
					}
                    
                },/*
				'contentOptions' => function ($data, $key, $index, $column) {
							if(time()- $data->data_add_dok_poj>432000 ){
							//	return ['style' => 'background-color: red'] ;
							}
                        },*/
            ],
			
            ['label'=>'Обленерго',
            'filter' => ArrayHelper::map(Organizations::find()->where(['tupe'=>1])->all(), 'id', 'title'),
            'attribute' => 'id_obl',
                'value'=> function($data){
                return  Organizations::findOne($data->id_obl)->title;   
                 },
                 
            ],
			
            
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
<?php
 //   echo LinkPager::widget(['pagination' => $pages,]);
?>