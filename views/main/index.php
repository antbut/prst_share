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
use app\models\DirScStatus;

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

            [
			//'header'=>'Дата <br> створення',
            
            'attribute' => 'date_create',
			'visible' =>Yii::$app->user->can('viev_show_bbi_table') ? false : true,				
            'value'=> function($data){
                return date('d.m.Y', $data->date_create);   
                 }
            ],
			
			[
			//'header'=>'Останнє <br> оновлення',
			'label'=>'Останнє оновлення',
			'attribute' => 'date_last_update',
			'visible' =>Yii::$app->user->can('view_date_update_obj'),
                'value'=> function($data){
                return ($data->date_last_update!=0 ? date('d.m.Y', $data->date_last_update) : 'Нема змін');   
                 }
            ],
            [
            'label'=>'Дата Оплати',
            'attribute' => 'date_payment',
                'value'=> function($data){
                return  $data->date_payment!=0 ? date('d.m.Y', $data->date_payment) : ' ';   
                 }
            ],
			
        //    'title:ntext',
			[
				'attribute' => 'title',
				'format' => 'raw',
				 'value'=>function ($data) {
					return Html::a(Html::encode($data->title),Url::to(['main/view','id'=>$data->id]));
				},
			],
            'adress:ntext',
            'n_dogoovor',

          //  'price_dogovor',
            [
				'header'  => 'Ціна Д',
        
                'attribute' => 'price_dogovor',
                'visible' => (Yii::$app->user->can('viewPrices_p')? (Yii::$app->user->can('viev_show_bbi_table') ? false : true) : false),
				
				
            ],
          //  'price_pidr',
            
            [
				'header'  => 'Ціна П <br> початкова',
                'attribute' => 'price_pidr',
                'visible' => (Yii::$app->user->can('viewPrices_p') ? (Yii::$app->user->can('viev_show_bbi_table') ? false : true) : false),
                
            ],

          
            
            [
				'header'  => 'Ціна Д <br> остаточна',
                'attribute' => 'price_dogovor_end',
                'visible' => (Yii::$app->user->can('viewPrices_d') ? (Yii::$app->user->can('viev_show_bbi_table') ? false : true): false),
            ],
            
         
            [
				'header'  => 'Ціна П <br> остаточна',
                'attribute' => 'price_pidr_end',
                'visible' => (Yii::$app->user->can('viewPrices_p') ? (Yii::$app->user->can('viev_show_bbi_table') ? false : true): false),
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
                'header' => 'Рішення <br> підрядника',
			  
                'attribute' => 'status_pidr',
                'format' => 'raw',
                'filter' => ArrayHelper::map(PidrStaus::find()->all(), 'id', 'title'),
                'visible' => Yii::$app->user->can('viewStatysPidryadnik'),
                'value' => function($data){
                    if($data->status_pidr==1)
                        return Html::tag('p', Html::encode(PidrStaus::findOne($data->status_pidr)->title), ['style' => 'color:green;']);
                    if($data->status_pidr==0)
                        return Html::tag('p', Html::encode(PidrStaus::findOne($data->status_pidr)->title), ['style' => 'color:#333333;']);
                },
				
            ],

            [
                'header' => 'Рішення <br> підрядника П2',
              
                'attribute' => 'status_pidr_pd',
                'format' => 'raw',
                'filter' => ArrayHelper::map(PidrStaus::find()->all(), 'id', 'title'),
                'visible' => Yii::$app->user->can('viewStatysPidryadnik'),
                'value' => function($data){
                    if($data->status_pidr_pd==1)
                        return Html::tag('p', Html::encode(PidrStaus::findOne($data->status_pidr_pd)->title), ['style' => 'color:green;']);
                    if($data->status_pidr_pd==0)
                        return Html::tag('p', Html::encode(PidrStaus::findOne($data->status_pidr_pd)->title), ['style' => 'color:#333333;']);
                },
                
            ],

            [
                'header' => 'Графік <br> робіт',
              
                'attribute' => 'status_dir_sc',
                'format' => 'raw',
                'filter' => ArrayHelper::map(DirScStatus::find()->all(), 'id', 'title'),
                'visible' => Yii::$app->user->can('viewStatysPidryadnik'),
                'value' => function($data){

                    if($data->status_dir_sc==1)
                        return Html::tag('p', Html::encode(DirScStatus::findOne($data->status_dir_sc)->title), ['style' => 'color:green;']);
                    if($data->status_dir_sc==0)
                        return Html::tag('p', Html::encode(DirScStatus::findOne($data->status_dir_sc)->title), ['style' => 'color:#333333;']);

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
                        'style' => ' width:25px; margin:0 auto; align:center;'
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
				'visible' =>Yii::$app->user->can('viev_show_bbi_table') ? false : true,
                'filter' => ArrayHelper::map(ProjektTupes::find()->all(), 'id', 'title'),
                'value'=> function($data){
                return  ProjektTupes::findOne($data->id_project_type)->title;   
                 }
            ],
			
			[
                'header' => 'час  на <br> Рішення підрядника',
                //'attribute' => 'status_pidr',
                'format' => 'raw',
                //'filter' => ArrayHelper::map(PidrStaus::find()->all(), 'id', 'title'),
                'visible' => Yii::$app->user->can('view_expiration_date'),
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
			
			
			['header'=>'Дата <br> прийняття підрядником <br>роботи',
              'visible' => (Yii::$app->user->can('view_expiration_date') ? Yii::$app->user->can('viev_show_bbi_table'): false),
                'value'=> function($data){
                  if($data->date_status_pidr==0){

                  }else{
                    return date('d.m.Y', $data->date_status_pidr);
                  }   
                 }
            ],
            
            ['header'=>'Підтверджено <br> отримання графіку <br>робіт',
              'visible' => Yii::$app->user->can('view_contractor_apruw_work') ? Yii::$app->user->can('viev_show_bbi_table'): false,
                'value'=> function($data){
                  if($data->date_status_dir_sc==0){

                  }else{
                    return date('d.m.Y', $data->date_status_dir_sc);
                  }   
                 }
            ],
			
			['header'=>'Нормативна дата <br>виконання роботи',
                'visible' => Yii::$app->user->can('view_contractor_apruw_work') ? Yii::$app->user->can('viev_show_bbi_table'): false,
                'value'=> function($data){
                  if($data->date_norm_run_work==0){

                  }else{
                    return date('d.m.Y', $data->date_norm_run_work);
                  }   
                 }
            ],
			['header'=>'Дата <br>додавання нового <br>ВОВР',
                'visible' => Yii::$app->user->can('view_contractor_apruw_work')? Yii::$app->user->can('viev_show_bbi_table'): false,
                'value'=> function($data){
                  if($data->date_add_vovr==0){

                  }else{
                    return date('d.m.Y', $data->date_add_vovr);
                  }   
                 }
            ],
			
			['header'=>'Дата <br> складання акту<br> виконаних робіт',
              'visible' => Yii::$app->user->can('view_contractor_apruw_work') ? Yii::$app->user->can('viev_show_bbi_table') : false,
                'value'=> function($data){
                  if($data->date_avr ==0){

                  }else{
                    return date('d.m.Y', $data->date_avr );
                  }   
                 }
            ],
			
			
			
			
			
            ['label'=>'Обленерго',
            'filter' => ArrayHelper::map(Organizations::find()->where(['tupe'=>1])->all(), 'id', 'title'),
            'attribute' => 'id_obl',
                'value'=> function($data){
                return  Organizations::findOne($data->id_obl)->title;   
                 },
                 
            ],
			
            
            ['class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {delete} {download_all_files_pidr}',

                'visibleButtons' =>
                    [
                    'update' => Yii::$app->user->can('EditProjects'),
                    'delete' => Yii::$app->user->can('admin'),
                    'download_all_files_pidr' => Yii::$app->user->can('download_all_files_pidr'),

                    ],

                'buttons' => [
                    'download_all_files_pidr' => function ($url, $model, $key) {
                        $iconName = "info-sign";

                        $iconName ="floppy-save";
                        
                        //Текст в title ссылки, что виден при наведении
                        $title = \Yii::t('yii', 'завантажити файли підрядника');
                        
                        $id = 'info-'.$key;
                        $options = [
                            'title' => $title,
                            'aria-label' => $title,
                            'data-pjax' => '0',
                            'id' => $id
                        ];
                        
                        $url = Url::current(['files/downloadzipfilepidr', 'id' => $key]);
                        
                        //Для стилизации используем библиотеку иконок
                        $icon = Html::tag('span', '', ['class' => "glyphicon glyphicon-$iconName"]);
                        
                        


                        

                        return Html::a($icon, $url, $options);
                    },
                ],

            ],
        ],
    ]); ?>


</div>
<?php
 //   echo LinkPager::widget(['pagination' => $pages,]);
?>