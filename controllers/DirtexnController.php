<?php

namespace app\controllers;

use Yii;
use app\models\DirTexn;
use app\models\DirtexnSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Types;
use yii\web\UploadedFile;
use app\models\UploadForm;
use app\models\DownloadFiles;
use yii\filters\AccessControl;
use app\models\User;
use app\models\Organizations;

use yii\data\Pagination;
use yii\base\BaseObject;
use yii\base\Configurable;
use yii\web\Linkable;
use yii\helpers\ArrayHelper;
/**
 * DirtexnController implements the CRUD actions for DirTexn model.
 */
class DirtexnController extends Controller
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
                    'roles' => ['dirtexnIndex'],
                ],
                [
                    'actions' => ['view'],
                    'allow' => true,
                    'roles' => ['dirtexnIndex'],
                ],
                [
                    'actions' => ['create'],
                    'allow' => true,
                    'roles' => ['dirtexnCreate', 'dirkapbudCreate', 'DirServCenterCreate', 'DirZabDiyalnCreate', 'DirITCreate'],
                ],
                [
                    'actions' => ['update'],
                    'allow' => true,
                    'roles' => ['dirtexnUpdate'],
                ],
                [
                    'actions' => ['delete'],
                    'allow' => true,
                    'roles' => ['dirtexnDelete'],
                ],

                [
                    'actions' => ['updatedate'],
                    'allow' => true,
                    'roles' => ['dirtexnupdatedate'],
                ],

                [
                    'actions' => ['viewfiles'],
                    'allow' => true,
                    'roles' => ['dirtexnviewfiles'],
                ],
                [
                    'actions' => ['deleteuploadfile'],
                    'allow' => true,
                    'roles' => ['dirtexnDeleteFile'],
                ],
                
                [
                    'actions' => ['updatedatep'],
                    'allow' => true,
                    'roles' => ['dirtexnUpdatedatep'],
                ],
                [
                    'actions' => ['updatetextarea'],
                    'allow' => true,
                    'roles' => ['dirtexnUpdatetextarea'],
                ],


            ],
        ]
        ];
    }

    /**
     * Lists all DirTexn models.
     * @return mixed
     */
    public function actionIndex($id_obl=1, $id_type=-1)
    {
        $searchModel = new DirtexnSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

	$organizations = Organizations::find()->all();
//---Доступ админа
        if(\Yii::$app->user->can('moderator') || \Yii::$app->user->can('admin')){			

    	    if($id_obl==1){
                if($id_type==-1){
    		      $model =Dirtexn::find()->where(['statys' => 0])->orderBy('id DESC');
                }else{
                  $model =Dirtexn::find()->where(['statys' => 0, 'id_type'=>$id_type])->orderBy('id DESC');  
                }
    		}else{
                if($id_type==-1){
    		      $model =Dirtexn::find()->where(['statys' => 0,'id_organization'=>$id_obl])->orderBy('id DESC');
                }else{
                   $model =Dirtexn::find()->where(['statys' => 0,'id_organization'=>$id_obl, 'id_type'=>$id_type])->orderBy('id DESC');
                }
    		}
           
            $types = Types::find()->where(['display'=>1])->all();
//-----Доступ руководитель обла
        }elseif(\Yii::$app->user->can('sypervisor')){
        //    $model =Dirtexn::find(['order'=>'id DESC'])->where(['id_organization'=>User::findOne(Yii::$app->user->id)->id_obl])->orderBy('id DESC')->all();

            $id_obl= User::findOne(Yii::$app->user->id)->id_obl;
            if($id_type==-1){
                $model =Dirtexn::find(['order'=>'id DESC'])->where(['id_organization'=>User::findOne(Yii::$app->user->id)->id_obl])->orderBy('id DESC');
            }else{
                $model =Dirtexn::find(['order'=>'id DESC'])->where(['id_organization'=>User::findOne(Yii::$app->user->id)->id_obl, 'id_type'=>$id_type])->orderBy('id DESC');
            }
            $types = Types::find()->where(['display'=>1])->all();
//----доступ директори технічні        
        }elseif(\Yii::$app->user->can('DirTexn')){
            $id_obl= User::findOne(Yii::$app->user->id)->id_obl;

            if($id_type==-1){
                $model =Dirtexn::find(['order'=>'id DESC'])->where(['id_organization'=>User::findOne(Yii::$app->user->id)->id_obl, 'id_type'=>2])->orderBy('id DESC');
            }else{
                $model =Dirtexn::find(['order'=>'id DESC'])->where(['id_organization'=>User::findOne(Yii::$app->user->id)->id_obl, 'id_type'=>$id_type])->orderBy('id DESC');
            }

            $types = Types::findAll([2]);

//----доступ Дирекція з капітального будівництва
        }elseif(\Yii::$app->user->can('DirKapBud')){
            $id_obl= User::findOne(Yii::$app->user->id)->id_obl;
            if($id_type==-1){
                $model =Dirtexn::find(['order'=>'id DESC'])->where(['id_organization'=>User::findOne(Yii::$app->user->id)->id_obl, 'id_type'=>1])->orderBy('id DESC');
            }else{
                $model =Dirtexn::find(['order'=>'id DESC'])->where(['id_organization'=>User::findOne(Yii::$app->user->id)->id_obl, 'id_type'=>$id_type])->orderBy('id DESC');
            }
            $types = Types::findAll([1]);

//----доступ Дирекція сервісного центру
        }elseif(\Yii::$app->user->can('DirServCenter')){
            $id_obl= User::findOne(Yii::$app->user->id)->id_obl;
            $model =Dirtexn::find(['order'=>'id DESC'])->where(['id_organization'=>User::findOne(Yii::$app->user->id)->id_obl, 'id_type'=>0])->orderBy('id DESC');

          

            $types = Types::findAll([0]);

//----доступ Дирекція з забезпечення діяльності
        }elseif(\Yii::$app->user->can('DirZabDiyaln')){
            $id_obl= User::findOne(Yii::$app->user->id)->id_obl;
            $model =Dirtexn::find(['order'=>'id DESC'])->where(['id_organization'=>User::findOne(Yii::$app->user->id)->id_obl, 'id_type'=>3])->orderBy('id DESC');
            $types = Types::findAll([3]);
//----доступ Дирекція IT
        }elseif(\Yii::$app->user->can('DirIT')){
            $id_obl= User::findOne(Yii::$app->user->id)->id_obl;
            $model =Dirtexn::find(['order'=>'id DESC'])->where(['id_organization'=>User::findOne(Yii::$app->user->id)->id_obl, 'id_type'=>5])->orderBy('id DESC');
            $types = Types::findAll([5]);
        }


        $countQuery = clone $model;

        $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => 20, 'params' => array_merge($_GET, ['id_obl' => $id_obl, 'id_type'=>$id_type])]);

          $models = $model->offset($pages->offset)->limit($pages->limit)->all();

        return $this->render('indexx', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model'=>$models,
            'types'=>$types,
            'pages' => $pages,
            'id_obl'=>$id_obl,
            'id_type'=>$id_type,
	    'organizations'=>$organizations, 
        ]);
    }

    /**
     * Displays a single DirTexn model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new DirTexn model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new DirTexn();

        if(\Yii::$app->user->can('texnDirUser') ){
            $model->id_type=User::findOne(Yii::$app->user->id)->id_types;
            $model->id_organization=User::findOne(Yii::$app->user->id)->id_obl;
		$tupes=ArrayHelper::map(Types::find()->all(), 'id', 'title');
        }

	if(\Yii::$app->user->can('DirTexn') ){
        //    $tupes=ArrayHelper::map(Types::findAll([0,1,2]), 'id', 'title');
            $tupes=ArrayHelper::map(Types::findAll([2]), 'id', 'title');
        }

        if(\Yii::$app->user->can('DirKapBud') ){
            //$tupes=ArrayHelper::map(Types::findAll([1]), 'id', 'title');
	//	$tupes=ArrayHelper::map(Types::find()->where(['display'=>1])->all(), 'id', 'title');
            $tupes=ArrayHelper::map(Types::findAll([1]), 'id', 'title');

        }
        if(\Yii::$app->user->can('DirServCenter') ){
            $tupes=ArrayHelper::map(Types::findAll([0]), 'id', 'title');

        }
        if(\Yii::$app->user->can('DirZabDiyaln') ){
            $tupes=ArrayHelper::map(Types::findAll([3]), 'id', 'title');

        }
        if(\Yii::$app->user->can('DirIT') ){
            $tupes=ArrayHelper::map(Types::findAll([5]), 'id', 'title');

        }
	if(\Yii::$app->user->can('sypervisor') ){
		$tupes=ArrayHelper::map(Types::find()->where(['display'=>1])->all(), 'id', 'title');
	}
	if(\Yii::$app->user->can('moderator') ){
		$tupes=ArrayHelper::map(Types::find()->where(['display'=>1])->all(), 'id', 'title');
	}
	if(\Yii::$app->user->can('admin') ){
		$tupes=ArrayHelper::map(Types::find()->where(['display'=>1])->all(), 'id', 'title');
	}
        

        if ($model->load($p=Yii::$app->request->post()) ) {
           
            //var_dump(Yii::$app->request->post('d_ofer_w'));

            $model->d_asept_dad=strtotime(Yii::$app->request->post('d_asept_dad_w'));
            $model->d_ofer=strtotime(Yii::$app->request->post('d_ofer_w'));
            
/*
            $model->d_ofer=strtotime(Yii::$app->request->post('d_ofer_w'));
            $model->d_opl_avans=strtotime(Yii::$app->request->post('d_opl_avans_w'));

            $days=array();
            $i=0;
                foreach ($model->d_enter_control_p['day'] as  $day) {
                    $days[$i]=['id'=>$i,'date'=>strtotime($day)];

                    $i++;
                }
            $model->d_enter_control_p=json_encode($days);

             $days=array();
                $i=0;
                foreach ($model->d_shadow_work_p['day'] as  $day) {
                    $days[$i]=['id'=>$i,'date'=>strtotime($day)];

                    $i++;
                }
            $model->d_shadow_work_p=json_encode($days);

            $days=array();
                $i=0;
                foreach ($model->d_end_interim_work_p['day'] as  $day) {
                    $days[$i]=['id'=>$i,'date'=>strtotime($day)];

                    $i++;
                }
            $model->d_end_interim_work_p=json_encode($days);


            $model->d_start_work=strtotime(Yii::$app->request->post('d_start_work_w'));

            $model->d_assept_work_p=strtotime(Yii::$app->request->post('d_assept_work_p_w'));

            $days=array();
                $i=0;
                foreach ($model->d_end_work_p['day'] as  $day) {
                    $days[$i]=['id'=>$i,'date'=>strtotime($day)];

                    $i++;
                }
            $model->d_end_work_p=json_encode($days);

*/
            $model->data_create=time();
            $model->id_creator=Yii::$app->user->id;

            $model->id_organization=User::findOne(Yii::$app->user->id)->id_obl;

          //  var_dump($model->d_shadow_work_p);



            if($model->save(false)){
                return $this->redirect(['view', 'id' => $model->id]);
            }
            
        }

        return $this->render('create', [
            'model' => $model, 'tupes'=>$tupes,
        ]);
    }

    /**
     * Updates an existing DirTexn model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionUpdatedate($id, $type, $idelem)
    {
        $model = $this->findModel($id);
        $model_f = new UploadForm();

       $array_dates = array();
        switch ($type) {

            case 'd_enter_control':
                $title='Вхідний контроль';

         //       $model->d_enter_controll!=0 ? $def_date=$model->d_enter_controll : $def_date=time();

                $array_dates=json_decode($model->d_enter_controll, true);

                if(isset($array_dates[$idelem]['date']) and $array_dates[$idelem]['date']!=''){
                     $def_date=$array_dates[$idelem]['date'];
                }else{
                     $def_date=time();
                }
                
                $temp= $array_dates;
                break;
            case 'd_shadow_work':
                $title='Приховані роботи ';

                $array_dates=json_decode($model->d_shadow_work, true);

               // json_decode($model->d_shadow_work, true)==null ? $def_date=time() : $def_date=json_decode($model->d_shadow_work, true)['$idelem']['date'];
                if(isset($array_dates[$idelem]['date']) and $array_dates[$idelem]['date']!=''){
                     $def_date=$array_dates[$idelem]['date'];
                }else{
                     $def_date=time();
                }
                
                break;
                
            case 'd_end_interim_work':
                $title='Закінчення проміжних етапів ';
               
               // $model->d_end_interim_work!=0 ? $def_date=$model->d_end_interim_work : $def_date=time();

                $array_dates=json_decode($model->d_end_interim_work, true);

                if(isset($array_dates[$idelem]['date']) and $array_dates[$idelem]['date']!=''){
                     $def_date=$array_dates[$idelem]['date'];
                }else{
                     $def_date=time();
                }

                break;
            case 'd_end_work':
                $title='Закінчення робіт';
                $array_dates=json_decode($model->d_end_work, true);

              //   $model->d_end_work!=0 ? $def_date=$model->d_end_work : $def_date=time();

                 $array_dates=json_decode($model->d_end_work, true);

                 if(isset($array_dates[$idelem]['date']) and $array_dates[$idelem]['date']!=''){
                     $def_date=$array_dates[$idelem]['date'];
                }else{
                     $def_date=time();
                }

                break;
            case 'd_assept_work':
                $title='Приймання виконаних робіт робіт';
                $model->d_assept_work!=0 ? $def_date=$model->d_assept_work : $def_date=time();

                break;
            
            
            default:
               $title=$type;
                break;
        }

            

        if (Yii::$app->request->isPost) {

   
            $model_f->file = UploadedFile::getInstances($model_f, 'file');
 
        
            $basePath= Yii::$app->params['BaseFilePath'];
            $tablenamePatx='dirt';

            $fullPath=$basePath.$tablenamePatx.'/'.$id.'/'.$type.'/';
              //echo $basePath.$tablenamePatx;
              //************************* проверяем наличие папки
            if(!file_exists($basePath.$tablenamePatx)){
                mkdir($basePath.$tablenamePatx, 0774);
            }
            if(!file_exists($basePath.$tablenamePatx.'/'.$id)){
                mkdir($basePath.$tablenamePatx.'/'.$id, 0774);
            }
            if(!file_exists($basePath.$tablenamePatx.'/'.$id.'/'.$type.'/')){
                mkdir($basePath.$tablenamePatx.'/'.$id.'/'.$type, 0774);
            }
            $data_file=array();
                foreach ($model_f->file as $fill) {
                        $filename=mt_rand(100000,999000);

                        $fill->saveAs($fullPath . $filename . '.' . $fill->extension);

                        $dowmFile= new DownloadFiles();
                        $dowmFile->name = $fill->baseName . '.' . $fill->extension;
                        $dowmFile->url = $tablenamePatx.'/'.$id.'/'.$type.'/'. $filename . '.' . $fill->extension;
                        $dowmFile->data_create= time();
                        $dowmFile->id_creator=Yii::$app->user->id;
                        $dowmFile->save(false);
                        unset($dowmFile);
                        $data_file[]=['id'=>DownloadFiles::findOne(['url'=>$tablenamePatx.'/'.$id.'/'.$type.'/'. $filename . '.' . $fill->extension])->id, 'key_id'=>$idelem];
                }


                if($array_dates==null){
                    if(!empty($data_file)){
                        $array_dates[$idelem]=['id'=> $idelem, 'date'=>time()];
                    }else{
                        $array_dates=null;
                    }
                    
                }else{
                    if(!isset($array_dates[$idelem]['date'])){
                        if(!empty($data_file)){
                            $array_dates[$idelem]=['id'=> $idelem, 'date'=>time()];
                        }
                        
                    }
                }       


            switch ($type) {
            case 'd_enter_control':
               
                $model->d_enter_controll=json_encode($array_dates);
                               
                $model->enter_controll!=null ? $model->enter_controll=json_encode(array_merge(json_decode ($model->enter_controll,true), $data_file)):$model->enter_controll=json_encode($data_file) ;

                break;
                
            case 'd_shadow_work':
                
                $model->d_shadow_work=json_encode($array_dates);

                $model->shadow_work!=null ? $model->shadow_work=json_encode(array_merge(json_decode ($model->shadow_work,true), $data_file)):$model->shadow_work=json_encode($data_file) ;
                break;
            case 'd_end_interim_work':

                
                $model->d_end_interim_work=json_encode($array_dates);

                $model->end_interim_work!=null ? $model->end_interim_work=json_encode(array_merge(json_decode ($model->end_interim_work,true), $data_file)):$model->end_interim_work=json_encode($data_file) ;
                break;
            case 'd_end_work':

                $model->d_end_work=json_encode($array_dates);

                $model->end_work!=null ? $model->end_work=json_encode(array_merge(json_decode ($model->end_work,true), $data_file)):$model->end_work=json_encode($data_file) ;
                break;
            case 'd_assept_work':
                if($model->d_end_work==0){    
                    $model->d_assept_work=time();
                }
                $model->assept_work!=null ? $model->assept_work=json_encode(array_merge(json_decode ($model->assept_work,true), $data_file)):$model->assept_work=json_encode($data_file) ;
                break;
            
            }
            $model->save(false);
            return $this->redirect(['index']);
        }
        if(Yii::$app->request->isAjax){
             return $this->renderAjax('_form_date', [
                'model' => $model, 'title'=>$title ,'model_f'=>$model_f, 'def_date'=>$def_date, 'idelem'=> $idelem
            ]);
        }else{
            return $this->render('updatedate', [
                'model' => $model, 'title'=>$title ,'model_f'=>$model_f, 'def_date'=>$def_date
            ]);
        }
    }


    public function actionUpdatedatep($id, $type)
    {
        $model = $this->findModel($id);
        $def_date=time();
        $disabl_enter=true;
        $multidata= false;
       
       $array_dates = array();
        switch ($type) {

            case 'd_enter_control_p':
                $title='Вхідний контроль';
                $disabl_enter=false;

                
                break;
            case 'd_shadow_work_p':
                $title='Приховані роботи ';             
                $disabl_enter=false;
                
            case 'd_end_interim_work_p':
                $title='Закінчення проміжних етапів ';
                $disabl_enter=false;

                         
                break;
            case 'd_end_work':
                $title='Закінчення робіт';
                if($model->d_end_work==0)  $disabl_enter=false;
                 else
                    $def_date=$model->d_end_work;    
                break;
            case 'd_assept_work':
                $title='Приймання виконаних робіт робіт';
                if($model->d_assept_work==0)  $disabl_enter=false;
                else
                    $def_date=$model->d_assept_work;    
                break;
            case 'd_start_work':
                $title='Початок робіт ';
                if($model->d_start_work==0)  $disabl_enter=false;
                else
                    $def_date=$model->d_start_work;    
                break;
            case 'd_opl_avans':
                $title='Дата оплати аванса ';
                if($model->d_opl_avans==0)  $disabl_enter=false;

                else
                    $def_date=$model->d_opl_avans;    
                
                break;
            case 'd_assept_work_p':
                $title='Приймання виконаних робіт робіт планова дата ';
                if($model->d_assept_work_p==0)  $disabl_enter=false;

                else
                    $def_date=$model->d_assept_work_p;   
                break;
            case 'd_end_work_p':
                $title='Закінчення робіт планова дата';
                if($model->d_assept_work_p==0)  $disabl_enter=false;

                else
                    $def_date=$model->d_assept_work_p;   
                break;
            case 'd_ofer':
                $title='Дата підписання договору';
                if($model->d_ofer==0)  $disabl_enter=false;

                else
                    $def_date=$model->d_ofer;   
                break;
            

            default:
               $title=$type;
                break;
        }

            

        if (Yii::$app->request->isPost) {

   
            switch ($type) {
            case 'd_enter_control_p':
               
               $days=json_decode($model->d_enter_control_p,true);
               if($days==null)
                    $i=0;
                else
                    $i=count($days);
                $days[$i]=['id'=>$i,'date'=>strtotime(Yii::$app->request->post('data'))]; 

                $model->d_enter_control_p=json_encode($days);
                
                break;
                
            case 'd_shadow_work_p':
                $days=json_decode($model->d_shadow_work_p,true);
               if($days==null)
                    $i=0;
                else
                    $i=count($days);
                $days[$i]=['id'=>$i,'date'=>strtotime(Yii::$app->request->post('data'))]; 

                $model->d_shadow_work_p=json_encode($days);
               
                break;
            case 'd_end_interim_work_p':
                $days=json_decode($model->d_end_interim_work_p,true);
               if($days==null)
                    $i=0;
                else
                    $i=count($days);
                $days[$i]=['id'=>$i,'date'=>strtotime(Yii::$app->request->post('data'))]; 

                $model->d_end_interim_work_p=json_encode($days);
              
                break;
            case 'd_end_work_p':
                $days=json_decode($model->d_end_work_p,true);
               if($days==null)
                    $i=0;
                else
                    $i=count($days);
                $days[$i]=['id'=>$i,'date'=>strtotime(Yii::$app->request->post('data'))]; 

                $model->d_end_work_p=json_encode($days);
                break;
            
            case 'd_start_work':
                $model->d_start_work=strtotime(Yii::$app->request->post('data'));

                break;
            case 'd_opl_avans':
                $model->d_opl_avans=strtotime(Yii::$app->request->post('data'));
                break;

            case 'd_assept_work_p':
                $model->d_assept_work_p=strtotime(Yii::$app->request->post('data'));
                break;
            case 'd_ofer':
                $model->d_ofer=strtotime(Yii::$app->request->post('data'));
                break;
            }
	if(!$disabl_enter){
            $model->save(false);
	}
            return $this->redirect(['index']);
        }
        if(Yii::$app->request->isAjax){
             return $this->renderAjax('_form_date_p', [
                'model' => $model, 'title'=>$title , 'def_date'=>$def_date, 'disabl_enter'=>$disabl_enter, 'multidata'=>$multidata
            ]);
        }else{
            return $this->render('_form_date_p', [
                'model' => $model, 'title'=>$title , 'def_date'=>$def_date, 'disabl_enter'=>$disabl_enter,'multidata'=>$multidata
            ]);
        }
    }

    public function actionUpdatetextarea($id, $type)
    {
        $model = $this->findModel($id);

        $disabl_enter=true;

        switch ($type) {
            case 'deskription':
                $title='Короткий опис робіт';

                if($model->deskription=='')  
                    $disabl_enter=false;
                else
                    $def_text_add=$model->deskription;    
                
                break;
            case 'n_ofer':
                $title='№ Договору';
                if($model->n_ofer=='')
                  $disabl_enter=false;
                else
                    $def_text_add=$model->n_ofer;   
                break;

        }

        if (Yii::$app->request->isPost) {
            switch ($type) {
                case 'deskription':
                    if($model->deskription=='') 
                        $model->deskription=Yii::$app->request->post('text_add');
                break;
                case 'n_ofer':
                    if($model->n_ofer=='') 
                        $model->n_ofer=Yii::$app->request->post('text_add');
                break;
            }

            $model->save(false);
            return $this->redirect(['index']);
        }
        if(Yii::$app->request->isAjax){
             return $this->renderAjax('_form_text_area', [
                'model' => $model, 'title'=>$title,  'disabl_enter'=>$disabl_enter, 'def_text_add'=>$def_text_add]);
        }else{
            return $this->render('_form_text_area', [
                'model' => $model, 'title'=>$title, 'disabl_enter'=>$disabl_enter, 'def_text_add'=>$def_text_add]);
        }

    }

    public function actionViewfiles($id, $type){
        $model = $this->findModel($id);
        
       
        switch ($type) {
            case 'd_enter_control':
                $title='Данні Вхідний контроль';
               
                $fils=json_decode ($model->enter_controll, true);
                break;
            case 'd_shadow_work':
                $title='Данні Приховані роботи ';
                $fils=json_decode ($model->shadow_work, true);
                break;
            case 'd_end_interim_work':
                $title='Данні Закінчення проміжних етапів ';
                $fils=json_decode ($model->end_interim_work, true);
                break;
            case 'd_end_work':
                $title='Данні Закінчення робіт';
                $fils=json_decode ($model->end_work, true);
                break;
            case 'd_assept_work':
                $title='Данні Приймання виконаних робіт робіт';
                $fils=json_decode ($model->assept_work, true);
                break;
            
            
            default:
               $title=$type;
                break;
        }

        $data=array();
        foreach ($fils as $file) {
            $params=DownloadFiles::findOne($file['id']);
            $data[]=['id'=>$file['id'], 'name'=>$params->name, 'data'=>$params->data_create, 'autor'=> User::findOne($params->id_creator)->view_name, 'key_id'=>$file['key_id'] ];
        }


        if(Yii::$app->request->isAjax){
             return $this->renderAjax('viewfiles', [
                'data' => $data, 'title'=>$title, 'model'=>$model, 'type'=>$type
            ]);
        }else{
            return $this->render('viewfiles', [
                'data' => $data, 'title'=>$title, 'model'=>$model, 'type'=>$type
            ]);
        }


    }

    public function actionDeleteuploadfile($id, $id_file, $type){
        $model = $this->findModel($id);
        
        $model_f=DownloadFiles::findOne($id_file);

        switch ($type) {
            case 'd_enter_control':
                $title='Данні Вхідний контроль';
               
                $fils=json_decode ($model->enter_controll, true);
                break;
            case 'd_shadow_work':
                $title='Данні Приховані роботи ';
                $fils=json_decode ($model->shadow_work, true);
                break;
            case 'd_end_interim_work':
                $title='Данні Закінчення проміжних етапів ';
                $fils=json_decode ($model->end_interim_work, true);
                break;
            case 'd_end_work':
                $title='Данні Закінчення робіт';
                $fils=json_decode ($model->end_work, true);
                break;
            case 'd_assept_work':
                $title='Данні Приймання виконаних робіт робіт';
                $fils=json_decode ($model->assept_work, true);
                break;
            
            
            default:
               $title=$type;
                break;
        }

        $id_del_file=false;
        foreach ($fils as $key => $file) {
            if($file['id']==$id_file){
                $id_del_file=$key;
                break;
            }
        }
      
        unset($fils[$id_del_file]);

        if(!empty($fils)){
            $fils_j=json_encode($fils);
        }else{
            $fils_j=null;
        }
            switch ($type) {
                case 'd_enter_control':               
                    $model->enter_controll=$fils_j;
                    break;
                case 'd_shadow_work':
                    $model->shadow_work=$fils_j;
                    break;
                case 'd_end_interim_work':
                    $model->end_interim_work=$fils_j;
                    break;
                case 'd_end_work':
                    $model->end_work=$fils_j;
                    break;
                case 'd_assept_work':
                    $model->assept_work=$fils_j;
                    break;
            }
        
      
       if($model->save(false)){
            
            unlink(Yii::$app->params['BaseFilePath'].$model_f->url);
            $model_f->delete();

       }

       return $this->redirect(['index']);

    }

    /**
     * Deletes an existing DirTexn model.
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
     * Finds the DirTexn model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return DirTexn the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = DirTexn::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionUpload($id, $param)
    {
        return $this->render('view', [
                ]);
    }
}
