<?php

namespace app\controllers;

use Yii;
use app\models\DownloadFiles;
use app\models\DownloadfilesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\UploadForm;
use yii\web\UploadedFile;
use yii\filters\AccessControl;
use yii\helpers\Html;

/**
 * DownloadController implements the CRUD actions for DownloadFiles model.
 */
class DownloadController extends Controller
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
                        'roles' => ['FilesIndex'],
                    ],
                    [
                        'actions' => ['create'],
                        'allow' => true,
                        'roles' => ['FilesCreate'],
                    ],
                    [
                        'actions' => ['update'],
                        'allow' => true,
                        'roles' => ['FilesUpdate'],
                    ],
                    [
                        'actions' => ['delete'],
                        'allow' => true,
                        'roles' => ['FilesDelete'],
                    ],
                    [
                        'actions' => ['download'],
                        'allow' => true,
                        'roles' => ['FileDownload'],
                    ],
                    [
                        'actions' => ['viewfile'],
                        'allow' => true,
                        'roles' => ['FileDownload'],
                    ],
                ],
            ]
        ];
    }

    /**
     * Lists all DownloadFiles models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DownloadfilesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single DownloadFiles model.
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
     * Creates a new DownloadFiles model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new DownloadFiles();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpload()
    {
        $model = new UploadForm();

        if (Yii::$app->request->isPost) {
            $model->file = UploadedFile::getInstance($model, 'file');

            if ($model->file && $model->validate()) {    
                //echo "string";            
                $model->file->saveAs('/var/www/html/files/' . $model->file->baseName . '.' . $model->file->extension);
            }
        }

        return $this->render('UploadForm', ['model' => $model]);
    }

    public function actionDownload($id)
    {
        $model = $this->findModel($id);
        
        return Yii::$app->response->sendFile(Yii::$app->params['BaseFilePath'].'/'.$model->url, $model->name ); 
    }

    public function actionViewfile($id)
    {
        $model = $this->findModel($id);

	
	return Yii::$app->response->sendFile(Yii::$app->params['BaseFilePath'].'/'.$model->url, $model->name ,['inline'=>true]); 

        //return Yii::$app->response->sendFile(Yii::$app->params['BaseFilePath'].$model->url); 
    }

    /**
     * Updates an existing DownloadFiles model.
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
     * Deletes an existing DownloadFiles model.
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
     * Finds the DownloadFiles model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return DownloadFiles the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = DownloadFiles::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
