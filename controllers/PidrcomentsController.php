<?php

namespace app\controllers;

use Yii;
use app\models\PidrComents;
use app\models\PidrComentsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Main; 
use app\models\User;
use app\models\Organizations;
use yii\filters\AccessControl;


/**
 * PidrcomentsController implements the CRUD actions for PidrComents model.
 */
class PidrcomentsController extends Controller
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
                        'roles' => ['admin'],
                    ],
                    [
                        'actions' => ['view'],
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
					[
                        'actions' => ['agree'],
                        'allow' => true,
                        'roles' => ['agri_coment'],
                    ],
					[
                        'actions' => ['noagree'],
                        'allow' => true,
                        'roles' => ['contractor'],
                    ],
					[
                        'actions' => ['coment'],
                        'allow' => true,
                        'roles' => ['agri_coment'],
                    ],
					[
                        'actions' => ['ansver'],
                        'allow' => true,
                        'roles' => ['setPidradnikAnsver'],
                    ],
					[
                        'actions' => ['killpidr'],
                        'allow' => true,
                        'roles' => ['dir_dep_pkv'],
                    ],
                   
                ],
            ]
        ];
    }

    /**
     * Lists all PidrComents models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PidrComentsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PidrComents model.
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
     * Creates a new PidrComents model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new PidrComents();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing PidrComents model.
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

    /**
     * Deletes an existing PidrComents model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
     //   $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the PidrComents model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PidrComents the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PidrComents::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

    public function actionAgree($id_project, $tupe_coment=0){

        /* $tupe_coment=0 подрядчик погоджуєця на роботу
            $tupe_coment=1 подрядчик погоджує фінальну версію  ПКД */

        $model_p= Main::findOne($id_project);
        $model =  new PidrComents();
            $model->id_obj=$id_project;
            $model->date_create=time();
            $model->id_creator=Yii::$app->user->id;
            $model->id_organization=User::findOne(Yii::$app->user->id)->id_organization;

            $model->coment='Погоджено підрядником';
            if($tupe_coment==2){  
                $model->coment='Погоджено директором сервісного центру';
            }

            $model->tupe_coment=$tupe_coment;

        if($model->save(false)){

            if($tupe_coment==0){    //если ето первая итерация согласования подрядчика
                if($model_p->status_pidr==2 || $model_p->status_pidr==4){   // если согласовано с корзины

                    $model_p->pidr= User::findOne(Yii::$app->user->id)->id_organization;    // задать подрядчика согласившегося на работу

                    $model_org= Organizations::findOne(User::findOne($model->id_creator));

                    if($model_org->kill_deny_porj>0){
                        $model_org->kill_deny_porj=$model_org->kill_deny_porj-1;
                        $model_org->save();
                    }
                }


                
                     $model_p->status_objekt=2;
               
            }
            //добавляем id коментария в таблицу MAIN
            if ($model_p->pidr_coment==null){
                $model_p->pidr_coment=json_encode([$model->id]);
            }else{
                $old_mas=json_decode($model_p->pidr_coment, true);
                $old_mas[]=$model->id;
                $model_p->pidr_coment= json_encode($old_mas);
                if($model_p->status_pidr==2){
                    $model_p->pidr=User::findOne($model->id_creator)->id_organization;
                }
            }
            if($tupe_coment==0){    //если ето первая итерация согласования подрядчика
                $model_p->status_pidr=1;
            //    $model_p->status_objekt=2;
                $model_p->data_add_dok_poj=0;
            }
            if($tupe_coment==1){    //если ето вторая итерация согласования подрядчика
                    
                $model_p->status_pidr=1;
                $model_p->status_objekt=7;
                            
            }
            if($tupe_coment==2){    //если ето первая итерация согласования обла
                
                if($model_p->status_pidr==1 ){
                  //  $model_p->status_objekt=2;
                }
                $model_p->status_objekt=5;
                $model_p->status_dir_sc=1;

                $model_p->d_appryv_dkc=time();
            }

			$model_p->date_last_update=time();
            $model_p->save(false);
        }

        return $this->redirect(['main/view', 'id' => $id_project]);
    }

    

    public function actionNoagree($id_project, $tupe_coment=0){
         /* $tupe_coment=0 подрядчик погоджуєця на роботу
            $tupe_coment=1 подрядчик погоджує фінальну версію  ПКД */

        $model_p= Main::findOne($id_project);
        $model =  new PidrComents();
            $model->id_obj=$id_project;
            $model->date_create=time();
            $model->id_creator=Yii::$app->user->id;
            $model->coment='Не погоджено підрядником';
            $model->id_organization=User::findOne(Yii::$app->user->id)->id_organization;
            $model->tupe_coment=$tupe_coment;

      //  $model->save(false);

        if($model->save(false)){
            if($tupe_coment==0){    //если ето первая итерация согласования подрядчика
                $model_org= Organizations::findOne(User::findOne($model->id_creator));
                $model_org->kill_deny_porj=$model_org->kill_deny_porj+1;
                $model_org->save();

                $model_p->status_objekt=1;
                $model_p->status_pidr=2;
                $model_p->pidr=0;
            }

            if ($model_p->pidr_coment==null){
                $model_p->pidr_coment=json_encode([$model->id]);
            }else{
                $old_mas=json_decode($model_p->pidr_coment, true);
                $old_mas[]=$model->id;
               $model_p->pidr_coment= json_encode($old_mas);

            }
            
			$model_p->date_last_update=time();
            $model_p->save(false);
        }

        return $this->redirect(['main/view', 'id' => $id_project]);
    }

    public function actionComent($id_project, $tupe_coment=0)
    {
        /* $tupe_coment=0 подрядчик погоджуєця на роботу
            $tupe_coment=1 подрядчик погоджує фінальну версію  ПКД */
        $model_p= Main::findOne($id_project);

        $model = new PidrComents();

        if ($model->load(Yii::$app->request->post()) ) {

            $model->id_obj=$id_project;
            $model->date_create=time();
            $model->id_creator=Yii::$app->user->id;
            $model->id_organization=User::findOne(Yii::$app->user->id)->id_organization;
            $model->tupe_coment=$tupe_coment;
  
                if($model->save(false)){

                    if($tupe_coment==0){    //если ето первая итерация согласования подрядчика
                        if($model_p->status_pidr!=2){ //если отказной обєкт  не менять статус 
                            $model_p->status_pidr=3;
                        }else{
                            $model_p->status_pidr=4;
                        }
                    }
                    if($tupe_coment==1){    //если ето согласование ПКД
                        $model_p->status_pidr=3;
                    }
                    if($tupe_coment==2){
                        $model_p->d_appryv_dkc=-1;


                        $model_p->status_dir_sc=2;
                    }
                
                    if ($model_p->pidr_coment==null){
                        $model_p->pidr_coment=json_encode([$model->id]);
                    }else{
                        $old_mas=json_decode($model_p->pidr_coment, true);
                        $old_mas[]=$model->id;
                       $model_p->pidr_coment= json_encode($old_mas);
                    }

    				$model_p->date_last_update=time();
                    $model_p->save(false);

                    return $this->redirect(['main/view', 'id' => $id_project]);
                }
           

            
        }

        if(Yii::$app->request->isAjax){
             return $this->renderAjax('create', [
                'model' => $model,
            ]);
        }else{
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    public function actionAnsver($id_project, $tupe_coment=0  )
    {
        $model_p= Main::findOne($id_project);

        $model = new PidrComents();

        if ($model->load(Yii::$app->request->post()) ) {

            $model->id_obj=$id_project;
            $model->date_create=time();
            $model->id_creator=Yii::$app->user->id;
            $model->tupe_coment=$tupe_coment;

            if( $model->save()){
            
                if($model_p->status_pidr!=4){
					//$model_p->status_pidr=2;
				}else{
					$model_p->status_pidr=0;
				}

                if ($tupe_coment==1){
                    $model_p->status_pidr=0;
                }

                if ($tupe_coment==2){
                    $model_p->status_dir_sc=0;
                }
                if ($model_p->pidr_coment==null){
                    $model_p->pidr_coment=json_encode([$model->id]);
                }else{
                    $old_mas=json_decode($model_p->pidr_coment, true);
                    $old_mas[]=$model->id;
                   $model_p->pidr_coment= json_encode($old_mas);
                }
				$model_p->date_last_update=time();
                if($tupe_coment==0){
				    $model_p->data_add_dok_poj=time();
                }
                $model_p->save(false);

                return $this->redirect(['main/view', 'id' => $id_project]);
            }                   
        }
        if(Yii::$app->request->isAjax){
             return $this->renderAjax('create', [
                'model' => $model,
            ]);
        }else{
            return $this->render('create', [
                'model' => $model,
            ]);
        }
	}	
		public function actionKillpidr($id_project){

        $model_p= Main::findOne($id_project);
        $model =  new PidrComents();
            $model->id_obj=$id_project;
            $model->date_create=time();
            $model->id_creator=Yii::$app->user->id;
			$model_org= Organizations::findOne($model_p->pidr)->title;
            $model->coment='Підрядника '.$model_org.' відхилено';

			if($model->save(false)){
			
				if ($model_p->pidr_coment==null){
					$model_p->pidr_coment=json_encode([$model->id]);
				}else{
					$old_mas=json_decode($model_p->pidr_coment, true);
					$old_mas[]=$model->id;
					$model_p->pidr_coment= json_encode($old_mas);           
				}
				
				$model_p->status_pidr=2;
				$model_p->status_objekt=1;
				$model_p->date_last_update=time();
				$model_p->save(false);
			}

        return $this->redirect(['main/view', 'id' => $id_project]);
   
		
		}
}
