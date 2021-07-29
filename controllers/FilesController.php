<?php

namespace app\controllers;

use Yii;
use app\models\Files;
use app\models\FilesSearch;
use app\models\Main;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * FilesController implements the CRUD actions for Files model.
 */
class FilesController extends Controller
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
        ];
    }

    /**
     * Lists all Files models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new FilesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Files model.
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
     * Creates a new Files model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Files();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Files model.
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
     * Deletes an existing Files model.
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
     * Finds the Files model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Files the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Files::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

    public function actionDownload($id)
    {
        $model = $this->findModel($id);

        if(file_exists(Yii::$app->params['BaseFilePath'].'/'.$model->url)){

            return Yii::$app->response->sendFile(Yii::$app->params['BaseFilePath'].'/'.$model->url, $model->name );
        }else{
            return "<h2>помилка доступу до файлів</h2>";
        }
         
    }

    public function actionViewfile($id)
    {
        $model = $this->findModel($id);

        if(file_exists(Yii::$app->params['BaseFilePath'].'/'.$model->url)){
            return Yii::$app->response->sendFile(Yii::$app->params['BaseFilePath'].'/'.$model->url, $model->name ,['inline'=>true]); 
        }else{
            return "<h2>помилка доступу до файлів</h2>";
        }
        //return Yii::$app->response->sendFile(Yii::$app->params['BaseFilePath'].$model->url); 
    }


    public function actionDownloadzipfilepidr($id){

        $model = Main::findOne($id);

        $id_files=[];

        $files_pojekt= json_decode($model->files_pojekt,true);

        if(is_array($files_pojekt)){
            foreach ( $files_pojekt as $key => $value) {
                $id_files[]=$value['id'];
            }
        }
        $file_resoyrs_report= json_decode($model->file_resoyrs_report,true);

        if(is_array($file_resoyrs_report)){
            foreach ( $file_resoyrs_report as $key => $value) {
                $id_files[]=$value['id'];
            }
        }

        $files_smeta= json_decode($model->files_smeta,true);

        if(is_array($files_smeta)){
            foreach ( $files_smeta as $key => $value) {
                if(($value['s_type']=='p' || $value['s_type']=='pn' || $value['s_type']=='end' || $value['s_type']=='p_d2')){
                    $id_files[]=$value['id'];
                }
            }
        }


       // print_r($id_files);

      //  echo "<br> addr: ".dirname(__FILE__);
        

        $zip = new \ZipArchive();
 
        if($zip->open(Yii::$app->params['BaseFilePath'].'/zip/'.'archive_'.$id.'.zip', \ZIPARCHIVE::CREATE)){

            $zip->setArchiveComment ( 'Проект №'.$model->n_dogoovor);
        
             //   echo "<br>".Yii::$app->params['BaseFilePath'].'/zip/'.'archive_'.$id.'.zip';                   
            foreach ($id_files as $key => $value) {

                $model_f = $this->findModel($value);

                
                $zip->addFile(Yii::$app->params['BaseFilePath'].'/'.$model_f->url,$model_f->name);

              //  echo "<br>".Yii::$app->params['BaseFilePath'].'/'.$model_f->url;
            }       

            $zip->close(); //Завершаем работу с архивом
        }

        if(file_exists(Yii::$app->params['BaseFilePath'].'/zip/'.'archive_'.$id.'.zip')){

            return Yii::$app->response->sendFile(Yii::$app->params['BaseFilePath'].'/zip/'.'archive_'.$id.'.zip', $model->n_dogoovor.$model->adress.'.zip');

        }else{
            return "<h2>помилка доступу до файлів</h2>";
        }

        
    }
}
