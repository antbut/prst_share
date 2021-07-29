<?php

namespace app\controllers;

use Yii;
use app\models\ObjektLog;
use app\models\ObjeklogSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * ObjectlogController implements the CRUD actions for ObjektLog model.
 */
class ObjectlogController extends Controller
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
                        'roles' => ['view_objekts_log'],
                    ],
                    [
                        'actions' => ['view'],
                        'allow' => true,
                        'roles' => ['view_objekt_log'],
                    ],

                    [
                        'actions' => ['viewhistoruobjekt'],
                        'allow' => true,
                        'roles' => ['view_objekt_log'],
                    ],
    
                ],
            ]
        ];
    }

    /**
     * Lists all ObjektLog models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ObjeklogSearch();
        if(\Yii::$app->user->can('view_prod_all') ){ 
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        }elseif(\Yii::$app->user->can('contractor') ){ 
            $dataProvider = $searchModel->search_pidr_historu(Yii::$app->request->queryParams);
        }elseif(\Yii::$app->user->can('contractor_bbi') ){ 
            $dataProvider = $searchModel->search_pidr_historu(Yii::$app->request->queryParams);
        }else{ 
            $dataProvider = $searchModel->search_obl_historu(Yii::$app->request->queryParams);
        }
        

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ObjektLog model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */

    public function actionViewhistoruobjekt($id){

        $searchModel = new ObjeklogSearch();
        $dataProvider = $searchModel->search_obj_historu($id, Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new ObjektLog model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ObjektLog();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing ObjektLog model.
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
     * Deletes an existing ObjektLog model.
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
     * Finds the ObjektLog model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ObjektLog the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ObjektLog::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
