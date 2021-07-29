<?php

namespace app\controllers;

use Yii;
use app\models\Main;
use app\models\MainSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;
use app\models\User;
use app\models\Organizations;
use yii\web\Linkable;
use yii\data\Pagination;
use app\models\SysParam;
use app\models\Files;
use app\models\UploadForm;
use yii\web\UploadedFile;
use app\models\KoeficOrder;
use kartik\mpdf\Pdf;
use kartik\export\ExportMenu;
use app\models\PidrStaus;
use app\models\ObjektStatus;
use app\models\ProjektTupes;
use yii\helpers\Html;
use yii\helpers\Url;
use app\models\DistriktPidr;
use app\models\Mail;

use kekaadrenalin\imap;
use kekaadrenalin\imap\Mailbox;

/**
 * MainController implements the CRUD actions for Main model.
 */
class MainController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['ViewProjects'],
                    ],
                    [
                        'actions' => ['view'],
                        'allow' => true,
                        'roles' => ['ViewProjects'],
                    ],
					[
                        'actions' => ['commonbasket'],
                        'allow' => true,
                        'roles' => ['ViewProjects'],
                    ],
                    [
                        'actions' => ['create'],
                        'allow' => true,
                        'roles' => ['CreateNewProjects'],
                    ],
                    [
                        'actions' => ['update'],
                        'allow' => true,
                        'roles' => ['EditProjects'],
                    ],
                    [
                        'actions' => ['delete'],
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                    [
                        'actions' => ['uploadprojektfile'],
                        'allow' => true,
                        'roles' => ['uploadProjectFiles','uploadProjectFiles_Report_obl'],
                    ],
                    [
                        'actions' => ['addpidrinfo'],
                        'allow' => true,
                        'roles' => ['setPriсes'],
                    ],
                    [
                        'actions' => ['addobjectprice'],
                        'allow' => true,
                        'roles' => ['uploadProjectFiles'],
                    ],
                    [
                        'actions' => ['addobjectpricep'],
                        'allow' => true,
                        'roles' => ['uploadProjectFiles'],
                    ],
					[
                        'actions' => ['sendmail'],
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                    [
                        'actions' => ['viewpdf'],
                        'allow' => true,
                        'roles' => ['viewpdf'],
                    ],
                    [
                        'actions' => ['exportobj'],
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                    [
                        'actions' => ['droppidrfromobject'],
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
					[
                        'actions' => ['contactorchange'],
                        'allow' => true,
                        'roles' => ['admin'],
                    ],

                    [
                        'actions' => ['settupeprodj'],
                        'allow' => true,
                        'roles' => ['dir_dep_pkv'],
                    ],
                    
                ],
            ]
        ];
    }

    /**
     * Lists all Main models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MainSearch();

        Mail::GetMail_Resourse();
        if(\Yii::$app->user->can('admin') ){ 
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        }elseif(\Yii::$app->user->can('view_prod_all') ){ 
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        }elseif(\Yii::$app->user->can('dir_dep_pkv') ){ 
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        }elseif(\Yii::$app->user->can('contractor') ){ 
            $dataProvider = $searchModel->searchorg(Yii::$app->request->queryParams);
        }elseif(\Yii::$app->user->can('top_manager') ){
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        }elseif(\Yii::$app->user->can('Projektant') ){
            $dataProvider = $searchModel->searchpr(Yii::$app->request->queryParams);
        }else{
            $dataProvider = $searchModel->searchobl(Yii::$app->request->queryParams);
        }

        $gridColumns = [
            ['class' => 'yii\grid\SerialColumn'],
            ['label'=>'Дата створення',
            
            'attribute' => 'date_create',
                'value'=> function($data){
                return date('d.m.Y', $data->date_create);   
                 }
            ],
                                
                                
            [
                'attribute' => 'title',
                'width' => '160px',  
            ],
        //    'title:ntext',
          //  'adress:ntext',
            [
                'attribute' => 'adress',
                'width' => '100px',  
            ],
            'n_dogoovor',

            [
                'attribute' => 'price_dogovor',
                'visible' => Yii::$app->user->can('viewPrices'),
                'width' => '30px',  
            ],
         
            [
                'attribute' => 'price_pidr',
                'visible' => Yii::$app->user->can('viewPrices'),
            ],
          
            [
                'attribute' => 'price_dogovor_end',
                'visible' => Yii::$app->user->can('viewPrices'),
            ],
          
            [
                'attribute' => 'price_pidr_end',
                'visible' => Yii::$app->user->can('viewPrices'),
            ],
            ['label'=>'Підрядник',
                'attribute' => 'pidr',
                'filter' => ArrayHelper::map(Organizations::find()->where(['tupe'=>2])->all(), 'id', 'title'),
                'visible' => Yii::$app->user->can('viewPrices'),
                'value'=> function($data){
                return  Organizations::findOne($data->pidr)->title;   
                 }
            ],
        
            [
                'attribute' => 'status_pidr',
                'format' => 'raw',
                'filter' => ArrayHelper::map(PidrStaus::find()->all(), 'id', 'title'),
                'visible' => Yii::$app->user->can('viewStatysPidryadnik'),
                'value' => function($data){
                    return PidrStaus::findOne($data->status_pidr)->title;
                },
            ],
           

            [
                'label' => 'Статус Обєкта',
                'attribute' => 'status_objekt',
                'filter' => ArrayHelper::map(ObjektStatus::find()->all(), 'id', 'title'),
                'format' => 'raw',
                'visible' => Yii::$app->user->can('viewFullObjektStatus'),
                'value' => function($data){
                    return  ObjektStatus::findOne($data->status_objekt)->title;
                },
                'contentOptions' => function ($data, $key, $index, $column) {
                     return ['style' => 'background-color:' 
                             . ObjektStatus::findOne($data->status_objekt)->color];
                        },
            ],
          
            ['label'=>'Тип проекту',
                'attribute' => 'id_project_type',
                'filter' => ArrayHelper::map(ProjektTupes::find()->all(), 'id', 'title'),
                'value'=> function($data){
                return  ProjektTupes::findOne($data->id_project_type)->title;   
                 }
            ],
            
                        
            ['label'=>'Обленерго',
            'filter' => ArrayHelper::map(Organizations::find()->where(['tupe'=>1])->all(), 'id', 'title'),
            'attribute' => 'id_obl',
                'value'=> function($data){
                return  Organizations::findOne($data->id_obl)->title;   
                 },
                 
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ];


        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'pages' => $pages,
            'gridColumns' => $gridColumns,
        ]);
    }
	
	public function actionCommonbasket()
    {
        $searchModel = new MainSearch();


			if(\Yii::$app->user->can('admin') ){ 
				$dataProvider = $searchModel->searcbasketadmin(Yii::$app->request->queryParams);
			}elseif(\Yii::$app->user->can('top_manager') ){
				$dataProvider = $searchModel->searcbasketadmin(Yii::$app->request->queryParams);
			}elseif(\Yii::$app->user->can('dir_dep_pkv') ){ 
				$dataProvider = $searchModel->searcbasketadmin(Yii::$app->request->queryParams);
			}else{
				$dataProvider = $searchModel->searcbasket(Yii::$app->request->queryParams);
			}
        

        $gridColumns = [
            ['class' => 'yii\grid\SerialColumn'],
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
                'visible' => Yii::$app->user->can('viewPrices'),
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
                    return PidrStaus::findOne($data->status_pidr)->title;
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
                    return  ObjektStatus::findOne($data->status_objekt)->title;
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
            
                        
            ['label'=>'Обленерго',
            'filter' => ArrayHelper::map(Organizations::find()->where(['tupe'=>1])->all(), 'id', 'title'),
            'attribute' => 'id_obl',
                'value'=> function($data){
                return  Organizations::findOne($data->id_obl)->title;   
                 },
                 
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ];


        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'pages' => $pages,
        ]);
    }

    /**
     * Displays a single Main model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model=$this->findModel($id);
       

                

                 

        return $this->render('view', [
            'model' => $model, 
        ]);
    }

    /**
     * Creates a new Main model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Main();


        $id_obl=User::findOne(Yii::$app->user->id)->id_organization;

        // $number_pp=0;



         switch ($id_obl){
            case 2:
                $name_param_obl='voe_kill_obj';
                $name_param_obl2='id_kurent_koef_VOE';
            break;   
            case 3:
                $name_param_obl='soe_kill_obj';
                $name_param_obl2='id_kurent_koef_SOE';

            break;
            case 5:
                $name_param_obl='choe_kill_obj';
                $name_param_obl2='id_kurent_koef_LG';
                
            break;
            case 4:
                $name_param_obl='lg_kill_obj';
                $name_param_obl2='id_kurent_koef_CHOE';
                
            break;
            case 6:
                $name_param_obl='cek_kill_obj';
                $name_param_obl2='id_kurent_koef_CEK';
            break;

            default:
                 $name_param_obl=0;
                 $number_pp=0;
            break;
         }

         

        $number_pp=SysParam::GetParam($name_param_obl);
        
        
        $n_dogov=date('Y').'/'.date('m').'/'.$id_obl.'/'. $number_pp.'/ПКВ';

       

        if ($model->load(Yii::$app->request->post()) ) {

           

            $model->n_dogoovor=$n_dogov;
            $model->date_create=time();
			$model->date_last_update=time();
            $model->id_obl=$id_obl;
            $model->id_koef=SysParam::GetParam($name_param_obl2);
            $model->id_creator=Yii::$app->user->id;

            $model->pidr=DistriktPidr::findOne($model->id_district)->id_pidr;
            $model->date_payment=strtotime(Yii::$app->request->post('data'));
            

            if($model->save()){
                
                  SysParam::SetParam($name_param_obl, SysParam::GetParam($name_param_obl)+1);
                    
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }
        //echo "$id_obl";
        return $this->render('create', [
            'model' => $model, 'id_obl' => $id_obl, 'n_dogov'=>$n_dogov,
        ]);
    }

    /**
     * Updates an existing Main model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
		
		$id_obl=$model->id_obl;
		
		$model->pidr=DistriktPidr::findOne($model->id_district)->id_pidr;
		$model->date_payment=strtotime(Yii::$app->request->post('data'));
		
		if ($model->load(Yii::$app->request->post()) ) {
			$model->date_last_update=time();
			
			if ( $model->save()) {
				return $this->redirect(['view', 'id' => $model->id]);
			}
		}

        return $this->render('update', [
            'model' => $model, 'id_obl' => $id_obl,
        ]);
    }

    /**
     * Deletes an existing Main model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Main model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Main the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Main::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'Запрошена вами сторінка не знайдена.'));
    }

//завантаження всіх файлів
    public function actionUploadprojektfile($id_project, $type_file, $smeta_tupe='p'){


        /*
            типи файлів
            1 - технічні умови
            2 - проекти
            3 - смети
            4 - відомість обєму робіт
            5 - Скан КБ3

            типи смет
            p - для підрядника
            d - для договору
            end - остаточні для підрядника
        */

            $model = $this->findModel($id_project);
            $model_f = new UploadForm();

            switch ($type_file){
                case 1:
                    $title="Додати файли технічних умов";
                break;
                case 2:
                    $title="Додати файли проекту";
                break;
                case 3:
                    $title="Додати файли смети";
                break;
                case 4:
                    $title="Додати файли відомість обєму робіт";
                break;

            }

                if (Yii::$app->request->isPost) {
                    $model_f->file = UploadedFile::getInstances($model_f, 'file');

                    $basePath= Yii::$app->params['BaseFilePath'];
                    $fullPath=$basePath.'/'.$id_project.'/'.$type_file.'/';

                    if(!file_exists($basePath.'/'.$id_project)){
                         mkdir($basePath.'/'.$id_project, 0774);
                    }
                    if(!file_exists($basePath.'/'.$id_project.'/'.$type_file.'/')){
                         mkdir($basePath.'/'.$id_project.'/'.$type_file, 0774);
                    }

                    $data_file=array();
                    foreach ($model_f->file as $fill) {
                            $filename=mt_rand(100000,999000);

                            $fill->saveAs($fullPath . $filename . '.' . $fill->extension);

                            $dowmFile= new Files();
                            $dowmFile->name = $fill->baseName . '.' . $fill->extension;
                            $dowmFile->url = $id_project.'/'.$type_file.'/'. $filename . '.' . $fill->extension;
                            $dowmFile->data_create= time();
                            $dowmFile->id_creator=Yii::$app->user->id;
                            $dowmFile->save(false);
                            unset($dowmFile);
                            if($type_file==2 ){
                                $data_file=json_decode($model->files_pojekt, true);
                                $data_file[]=['id'=>Files::findOne(['url'=>$id_project.'/'.$type_file.'/'. $filename . '.' . $fill->extension])->id, 'name'=> $fill->baseName , 'p_type'=>$smeta_tupe];}
                            elseif($type_file==3 ){
                                 $data_file=json_decode($model->files_smeta, true);
                                $data_file[]=['id'=>Files::findOne(['url'=>$id_project.'/'.$type_file.'/'. $filename . '.' . $fill->extension])->id, 'name'=> $fill->baseName , 's_type'=>$smeta_tupe];
                            }elseif($type_file==4){
                                $data_file=json_decode($model->file_resoyrs_report, true);
                                $data_file[]=['id'=>Files::findOne(['url'=>$id_project.'/'.$type_file.'/'. $filename . '.' . $fill->extension])->id, 'name'=> $fill->baseName , 'r_type'=>$smeta_tupe];
                            }else{
                                    $data_file[]=['id'=>Files::findOne(['url'=>$id_project.'/'.$type_file.'/'. $filename . '.' . $fill->extension])->id, 'name'=> $fill->baseName ];
                                }
                    }

                    switch ($type_file){
                        case 1:
                            $model->files_ty=json_encode($data_file);
                        break;
                        case 2:
                            $model->files_pojekt =json_encode($data_file);
                        break;
                        case 3:
                            $model->files_smeta=json_encode($data_file);
                        break;
                        case 4:
                            $model->file_resoyrs_report=json_encode($data_file);

                        break;
                        case 5:   //Загрузи КБ3
                            $model->files_kb=json_encode($data_file);
                            $model->status_objekt=7;

                            $model->close_objekt=1;    // мітка що обєкт закрито
                        break;

                    }


                     // якщо завантажено Проект і вор
                    if( $model->files_pojekt!=null && $model->file_resoyrs_report!==null && $model->status_objekt==0){
                            $model->status_objekt=1;
                            $model->data_add_dok_poj=time();
                    }


                    //  якшо проектант завантажив ВОР новий і новий проект

                    if($model->status_objekt==3){
                        foreach (json_decode($model->files_pojekt, true) as $key => $value) {
                            if($value['p_type']=='p_d2'){  // загружена новая версия проекта
                                foreach (json_decode($model->file_resoyrs_report, true) as $key => $value) {
                                    if($value['r_type']=='d'){  // загружена ведомость обема работ реальна
                                        $model->status_objekt=4;
                                        $model->status_vor=2;
                                        break;
                                    }
                                } 
                                    
                                break;
                            }
                        }

                    }

                    // якщо сметчик загрузив смету П Д і ціну

                    if($model->status_objekt==4 && $model->files_smeta!=null && $model->price_pidr!=0 && $model->price_dogovor!=0 ){

                        foreach (json_decode($model->files_smeta, true) as $key => $value) {
                            if($value['s_type']=='p'){
                                foreach (json_decode($model->files_smeta, true) as $key => $value) {
                                    if($value['s_type']=='d'){
                                            $model->status_objekt=5;
                                        break;
                                    }
                                }
                                break;
                            }
                        }

                    }


/*
                    // якщо завантажено все з пункту 1
                    if( $model->files_pojekt!=null &&  $model->files_smeta!=null && $model->price_pidr!=0 && $model->pidr!=0 && $model->status_objekt==0 && $model->price_dogovor!=0 && $model->file_resoyrs_report!= null && $model->status_objekt==0){

                         // добавить проверку по смете П и Д
                  

                              $model->status_objekt=1;
							  $model->data_add_dok_poj=time();
						
                        
                    }
					
					
					
					
					// загрузка совмещенного проекта
					
					if($model->status_objekt>1 && $model->status_objekt<5 && $model->file_resoyrs_report!==null){
							foreach (json_decode($model->files_pojekt, true) as $key => $value) {
								if($value['p_type']=='p_d2'){
									$model->status_objekt=5;
									
									break;
								}
							}
					}
					
					if($model->status_objekt == 5){
						foreach (json_decode($model->files_smeta, true) as $key => $value) {
                            if($value['s_type']=='end'){		//загружена окончательная смета п
								if($model->price_dogovor_end!=0){	// цена договора окончательная
									foreach (json_decode($model->files_smeta, true) as $key => $value) { // смета Д  
										if($value['s_type']=='d_d2'){
											
											$model->status_objekt=6;
											$model->tupe_prodj_work!=2;
											break;                                
										}
									}
								}
							
							}
						}
						
					}
                    
                     // якщо завантажени відомість обему робіт фінальна
                    if( $model->file_resoyrs_report!==null && $model->status_objekt==2){                                         
                      
                        foreach (json_decode($model->file_resoyrs_report, true) as $key => $value) {
                            if($value['r_type']=='d'){
                                $model->status_objekt=3;
                                $model->status_vor=2;
                                break;
                            }
                        } 
                    }


                    // якщо завантажуємо оcтаточну версію П2 змінить статус обєкта
                    if($model->price_pidr_end!=0 && $model->status_objekt==5 && $model->tupe_prodj_work!=2){
                        foreach (json_decode($model->files_smeta, true) as $key => $value) {
                            if($value['s_type']=='end'){
                               foreach (json_decode($model->files_pojekt, true) as $key => $value) {
                                   // if($value['p_type']=='end'){
                                       
                                        $model->status_objekt=6;
                                        
                                        $model->status_pidr=0;
                                        
                                   // }
                                }
                                break;
                            }
                        }
                    }


                    // загрузка смета Д2 по д1
                    if($model->status_objekt==4 && $model->tupe_prodj_work!=2){
                        if($model->price_dogovor_end!=0){
                            foreach (json_decode($model->files_smeta, true) as $key => $value) {
                                if($value['s_type']=='d'){
                                            $model->status_objekt=5;
                                            break;                                
                                }
                            }
                        }
                    }

                    // Загрузка по Д2 маршруту
                    if($model->status_objekt==4 && $model->tupe_prodj_work==2){
                    //    Yii::$app->session->setFlash('info', 'файли ');
                        foreach (json_decode($model->files_pojekt, true) as $key => $value) {
                            if($value['p_type']=='p_d2'){
                         //       Yii::$app->session->setFlash('warning', 'файли проекту');
                               foreach (json_decode($model->files_smeta, true) as $key => $value_s) {
                                    if($value_s['s_type']=='p_d2'){
                                  //      Yii::$app->session->setFlash('info ', 'файли смета П');
                                        foreach (json_decode($model->files_smeta, true) as $key => $value_ss) {
                                            if($value_ss['s_type']=='d_d2'){
                                        //        Yii::$app->session->setFlash('danger', 'файли смета Д');
                                                $model->status_objekt=20;
                                                break;
                                            }
                                        }
                                        break;  
                                    }
                                }
                                break;
                            }
                        }
                        
                    }

                    */

					$model->date_last_update=time();
                    $model->save(false);
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            return $this->render('downloadfile', [
                'model' => $model, 'title'=>$title ,'model_f'=>$model_f
            ]);
    }

    public function actionAddpidrinfo($id){
         $model = $this->findModel($id);

         if ($model->load(Yii::$app->request->post()) ) {

            if( $model->files_pojekt!=null &&  $model->files_smeta!=null && $model->price_pidr!=0 && $model->pidr!=0 && $model->price_dogovor!=0 && $model->file_resoyrs_report!= null){
                  //  $model->status_objekt=1;
					$model->data_add_dok_poj=time();
                }

                switch ($model->id_obl){
                    case 2:
                        $name_param_obl='id_kurent_koef_VOE';
                    break;
                    case 3:
                        $name_param_obl='id_kurent_koef_SOE';
                    break;
                    case 5:
                        $name_param_obl='id_kurent_koef_LG';
                    break;
                    case 4:
                        $name_param_obl='id_kurent_koef_CHOE';
                    break;
                    case 6:
                        $name_param_obl='id_kurent_koef_CEK';
                    break;
                }

              //   $koef=KoeficOrder::findOne(SysParam::GetParam($name_param_obl))->value;


             //   $model->price_dogovor= $model->price_pidr*$koef;

				$model->date_last_update=time();
            if($model->save()){
                
                                     
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }
        if(Yii::$app->request->isAjax){
             return $this->renderAjax('addpidrinfo', [
                'model' => $model, 
            ]);
        }else{
            return $this->render('addpidrinfo', [
                'model' => $model, 
            ]);
        }

    }

    public function actionAddobjectpricep($id){
         $model = $this->findModel($id);

         if ($model->load(Yii::$app->request->post()) ) {


                $model->date_last_update=time();
            if($model->save()){
                
                                     
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }
        if(Yii::$app->request->isAjax){
             return $this->renderAjax('addprice', [
                'model' => $model, 
            ]);
        }else{
            return $this->render('addprice', [
                'model' => $model, 
            ]);
        }

    }

    public function actionAddobjectprice($id, $tupe=0){

        /*
            $tupe=0     price_pidr_end          окончательная цена подрядчика
            $tupe=1     price_dogovor_end       окончательная цена договора
            $tupe=2     price_dogovor              цена договора

        */
         $model = $this->findModel($id);
         $title =" задати";



        if ($model->load(Yii::$app->request->post()) ) {

            if($tupe==0){
                            
            }elseif ($tupe==1) { //задать окнчательную цену договора

                $procent= KoeficOrder::findOne($model->id_koef)->value*0.05;

                    
                if($model->price_pidr==0){

                    Yii::$app->session->setFlash('danger', 'Ще не задана ціна підрядника');
                    $model->price_dogovor_end='не задана ціна підрядника';
                    return $this->render('addprice', [
                                'model' => $model, 
                        ]);
                }
            
                if($model->price_dogovor/$model->price_pidr> KoeficOrder::findOne($model->id_koef)->value-0.051 && $model->price_dogovor /$model->price_pidr < KoeficOrder::findOne($model->id_koef)->value+0.051){
                    
                            
                }else{

                    Yii::$app->session->setFlash('danger', 'ціна не вписуєця в коефіціент даний коефіціент '.$model->price_dogovor/$model->price_pidr);
                    $model->price_dogovor_end='предложена ціна '. ($model->price_pidr*KoeficOrder::findOne($model->id_koef)->value) ;

                    return $this->render('addprice', [
                                'model' => $model, 
                                'tupe' =>$tupe,
                            ]);
                }
            }elseif ($tupe==2) {
                    # code...
            }
                
            
			$model->date_last_update=time();
            
            if($model->save()){                                     
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } 
            switch ($tupe) {
                case '1':
                     $title = 'Задати ціну договору';
                    break;
                    
                default:
                    $title = 'Задати ціну ';
                    break;
            }    

        if(Yii::$app->request->isAjax){
             return $this->renderAjax('addprice', [
                'model' => $model, 
                'tupe' => $tupe,
                'title_o' =>  $title,
            ]);
        }else{
            return $this->render('addprice', [
                'model' => $model, 
                'tupe' => $tupe,
                'title_o' =>  $title,
            ]);
        }
    }

    public function  actionViewpdf($id){

        $model=$this->findModel($id);
              //  $content = $this->renderPartial('_reportView');
        $content =$this->render('viewpdf', ['model'=>$model]);
    
        // setup kartik\mpdf\Pdf component
        $pdf = new Pdf([
            // set to use core fonts only
            'mode' =>Pdf::MODE_UTF8, 
            // A4 paper format
            'format' => Pdf::FORMAT_A4, 
            // portrait orientation
            'orientation' => Pdf::ORIENT_PORTRAIT, 
            // stream to browser inline
            'destination' => Pdf::DEST_BROWSER, 
            // your html content input
            'content' => $content,  
            // format content from your own css file if needed or use the
            // enhanced bootstrap css built by Krajee for mPDF formatting 
          //  'cssFile' => '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.min.css',
            // any css to be embedded if required
          //  'cssInline' => '.kv-heading-1{font-size:18px}', 
             // set mPDF properties on the fly
            'options' => ['title' => 'Звіт по обєкту № '.$model->n_dogoovor],
             // call mPDF methods on the fly
            'methods' => [ 
                'SetHeader'=>['Звіт по обєкту № '.$model->n_dogoovor], 
                'SetFooter'=>['{PAGENO}'],
            ]
        ]);
        
        // return the pdf output as per the destination setting
        return $pdf->render(); 

    }

	public function  actionSendmail($id){
        
        $SendTo=['a.butenko@oe.net.ua', /*'v.lisovyi@info-prime.com.ua', 'a.solomka@info-prime.com.ua', 'n.bezginskaya@info-prime.com.ua', 'a.rogova@dits.com.ua'*/];
        
		
		$model = $this->findModel($id);
		
		if($model->status_objekt==1){
			
		}
		
  
				//		$send='a.butenko@oe.net.ua';
            
                foreach ($SendTo as $send){
                    $message[$send] =Yii::$app->mailer->compose();
                    $message[$send]->setFrom('ppryednyanna@gmail.com');
                    $message[$send]->setTo($send);
                    $message[$send]->setSubject('Стандартні приєднання');
                    $message[$send]->setTextBody('Ви маєте нові повідомлення на порталі');
					
                    $message[$send]->setHtmlBody("<b>У вкладеному файлі ви знайдете ");
              //      $message[$send]->attach('/var/www/html/temp_data/'.$key.' '.$month.'.pdf');
                    $message[$send]->send();
                
                //  unset($message);
                
					
				
                    echo "Mail is send  $send \n";
                }
            
            
                //unlink('/var/www/html/temp_data/'.$idoblwialon.'.pdf'); 
        
            
        //        return ExitCode::OK;
    }

    public function  actionExportobj(){

        $searchModel = new MainSearch();


        
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $gridColumns = [
            ['class' => 'yii\grid\SerialColumn'],
            ['label'=>'Дата створення',
            
            'attribute' => 'date_create',
                'value'=> function($data){
                return date('d.m.Y', $data->date_create);   
                 }
            ],
                                
                                
            [
                'attribute' => 'title',
                'width' => '160px',  
            ],
        //    'title:ntext',
          //  'adress:ntext',
            [
                'attribute' => 'adress',
                'width' => '100px',  
            ],
            'n_dogoovor',

            [
                'attribute' => 'price_dogovor',
                'visible' => Yii::$app->user->can('viewPrices'),
                'width' => '30px',  
            ],
         
            [
                'attribute' => 'price_pidr',
                'visible' => Yii::$app->user->can('viewPrices'),
            ],
          
            [
                'attribute' => 'price_dogovor_end',
                'visible' => Yii::$app->user->can('viewPrices'),
            ],
          
            [
                'attribute' => 'price_pidr_end',
                'visible' => Yii::$app->user->can('viewPrices'),
            ],
            ['label'=>'Підрядник',
                'attribute' => 'pidr',
                'filter' => ArrayHelper::map(Organizations::find()->where(['tupe'=>2])->all(), 'id', 'title'),
                'visible' => Yii::$app->user->can('viewPrices'),
                'value'=> function($data){
                return  Organizations::findOne($data->pidr)->title;   
                 }
            ],
        
            [
                'attribute' => 'status_pidr',
                'format' => 'raw',
                'filter' => ArrayHelper::map(PidrStaus::find()->all(), 'id', 'title'),
                'visible' => Yii::$app->user->can('viewStatysPidryadnik'),
                'value' => function($data){
                    return PidrStaus::findOne($data->status_pidr)->title;
                },
            ],
           

            [
                'label' => 'Статус Обєкта',
                'attribute' => 'status_objekt',
                'filter' => ArrayHelper::map(ObjektStatus::find()->all(), 'id', 'title'),
                'format' => 'raw',
                'visible' => Yii::$app->user->can('viewFullObjektStatus'),
                'value' => function($data){
                    return  ObjektStatus::findOne($data->status_objekt)->title;
                },
                'contentOptions' => function ($data, $key, $index, $column) {
                     return ['style' => 'background-color:' 
                             . ObjektStatus::findOne($data->status_objekt)->color];
                        },
            ],
          
            ['label'=>'Тип проекту',
                'attribute' => 'id_project_type',
                'filter' => ArrayHelper::map(ProjektTupes::find()->all(), 'id', 'title'),
                'value'=> function($data){
                return  ProjektTupes::findOne($data->id_project_type)->title;   
                 }
            ],
            
                        
            ['label'=>'Обленерго',
            'filter' => ArrayHelper::map(Organizations::find()->where(['tupe'=>1])->all(), 'id', 'title'),
            'attribute' => 'id_obl',
                'value'=> function($data){
                return  Organizations::findOne($data->id_obl)->title;   
                 },
                 
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ];

        return $this->render('index2', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'gridColumns' => $gridColumns,
        ]);
       
    }



    public function  actionDroppidrfromobject(){ //примусово видалить підрядника
        
            $models= Main::find()->where(['!=','data_add_dok_poj',0])->all();
           
      
            
            foreach ($models as $key => $data) {
                       
                        if(time()- $data->data_add_dok_poj<432000 ){
                            
                                $secs=  ($data->data_add_dok_poj+432000)- time();
                                $res = array();
    
                                $res['days'] = floor($secs / 86400);
                                $secs = $secs % 86400;
                                
                                $res['hours'] = floor($secs / 3600);
                                $secs = $secs % 3600;
                             
                                $res['minutes'] = floor($secs / 60);
                                $res['secs'] = $secs % 60;
                            
                //            return $res['days'].' д '.$res['hours'].' г';
                        }else{
                             if($data->status_pidr!=1 && $data->status_objekt<2){
                                if($data->status_pidr!=3){

                                    $model_org= Organizations::findOne($data->pidr);
                                  //  $model_org->kill_deny_porj=$model_org->kill_deny_porj+1;
                                  //  $model_org->save(false);
                                    
                                    $data->pidr=0;
                                    $data->status_pidr=2;
                                    $data->data_add_dok_poj=0;

                                    $data->save(false);
                                    echo $data->n_dogoovor.' Час вичерпано '."\n" ;
                                }
                             }

                              
                        }
            }
                    
            return true;
    }
	public function actionContactorchange($id) //принудительно сменить подрядчика
    {
        $model=$this->findModel($id);
       

        if ($model->load(Yii::$app->request->post()) ) {

            if($model->save()){
                return $this->render('view', [
                    'model' => $model, 
                ]);
            }
        }
        return $this->render('changepidrinfo', [
                    'model' => $model, 
                ]);

    }

    public function actionSettupeprodj($id_project, $tupe){
            $model=$this->findModel($id_project);
            $model->tupe_prodj_work=$tupe;
            $model->status_objekt=4;
            $model->save(false);
            return $this->redirect(['view', 'id' => $model->id]);
    }


    public function actionTestmail()
    {
        //composer require kekaadrenalin/yii2-imap "dev-master"
        
        $mailbox = new Mailbox(yii::$app->imap->connection);

        $mailIds = $mailbox->searchMailBox(); // Gets all Mail ids.
        
      //  $mailIds=Mail::GetMail();
    
        foreach($mailIds as $mailId){
            // Returns Mail contents
            echo 'tekst <br>';
            $mail = $mailbox->getMail($mailId);

            // Read mail parts (plain body, html body and attachments
            $mailObject = $mailbox->getMailParts($mail);
        

            // Array with IncomingMail objects
            echo '<pre>';
          //  print_r($mailObject);
        
            echo '</pre>';
            
            echo  '<br> Ввывод ';
            //var_dump($mailObject->date);
            echo '<br>Дата '. $mailObject->date ;
            echo '<br>Тема '.$mailObject->subject ;
            echo '<br>тело '.$mailObject->textPlain ;
            
            //echo '<br><br> Вложение '.$mailObject->attachments ;
            
            $pattern ='/DID:\d+/i';
            preg_match($pattern,$mailObject->subject, $id_str,PREG_OFFSET_CAPTURE, 3); 
            
            $pattern ='/\d+/i';
            preg_match($pattern,$id_str[0][0], $id_obj,PREG_OFFSET_CAPTURE, 3); 
            
            echo '<br><br><pre>';
                var_dump($id_str);
            echo '<br>';
                var_dump($id_obj);
            echo '</pre>';
            
            if($model=Main::findOne($id_obj[0][0])){
                    echo '<br >OK';
                    $attachments = $mailObject->getAttachments();
                    $last_att_name='';
                    foreach($attachments as $attachment){
                        if($last_att_name!=$attachment->name){
                            echo ' Attachment:' . $attachment->name . '<br>';
                            $last_att_name=$attachment->name;
                            $filename=mt_rand(100000,999000);
                            
                            preg_match('/\.[a-z]{1,4}$/i',$attachment->name, $id_name,PREG_OFFSET_CAPTURE, 3);
                            
                            $new_fil_adr=Yii::$app->params['BaseFilePath'].'/'.$id_obj[0][0].'/4/'.$filename.$id_name[0][0];
                            
                            echo '<br>'.$new_fil_adr;
                            echo '<br>'.$attachment->filePath;
                                                    
                            echo '<br>';
                            if(copy($attachment->filePath, $new_fil_adr)){
                                //echo'<br> KOPY OK';
                            
                                // сохраняем инфу поро файл в базу таблица файлов
                                
                                $dowmFile= new Files();
                                $dowmFile->name = $attachment->name;
                                $dowmFile->url = $id_obj[0][0].'/4/'.$filename.$id_name[0][0];
                                $dowmFile->data_create= time();
                                $dowmFile->id_creator=61; //id 61 пользователь mail 
                                $dowmFile->save(false);
                                
                                // сохраняем инфу в таблицу main файл ресурсов
                                
                                $data_file=json_decode($model->file_resoyrs_report, true);
                                $data_file[]=['id'=>Files::findOne(['url'=>$id_obj[0][0].'/4/'.$filename.$id_name[0][0]])->id, 'name'=> $attachment->filePath , 'r_type'=>'d1'];
                                $model->file_resoyrs_report=json_encode($data_file);
                            }
                        }
                        // Delete attachment file
                        unlink($attachment->filePath);
                        
                    }
                    
            }
           
        //  $mailbox->deleteMail($mailId); // Mark a mail to delete
        }
        //$mailbox->expungeDeletedMails(); // Deletes all marked mails
        return true;
    }
}
