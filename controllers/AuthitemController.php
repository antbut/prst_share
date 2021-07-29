<?php

namespace app\controllers;

use Yii;
use app\models\AuthItem;
use app\models\AuthitemSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\models\AuthItemChild;

/**
 * AuthitemController implements the CRUD actions for AuthItem model.
 */
class AuthitemController extends Controller
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
                    'actions' => ['create'],
                    'allow' => true,
                    'roles' => ['admin'],
                ],
                [
                    'actions' => ['view'],
                    'allow' => true,
                    'roles' => ['admin'],
                ],
                [
                    'actions' => ['addpermisiontorole'],
                    'allow' => true,
                    'roles' => ['admin'],
                ],

                [
                    'actions' => ['update'],
                    'allow' => true,
                    'roles' => ['admin'],
                ],
                [
                    'actions' => ['delete'],
                    'allow' => true,
                    'roles' => ['admin'],
                ],

            ],
            ],
        ];
    }

    /**
     * Lists all AuthItem models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AuthitemSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AuthItem model.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);

        $permisions= AuthItemChild::find()->where(['parent'=>$model->name])->all();
        return $this->render('view', [
            'model' => $model,
            'permisions'=>$permisions,
        ]);
    }

    /**
     * Creates a new AuthItem model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new AuthItem();

        if ($model->load(Yii::$app->request->post()) ) {

            if($model->type==2){
                $permit = Yii::$app->authManager->createPermission($model->name);
                $permit->description = $model->description;
                Yii::$app->authManager->add($permit);
            }
            if($model->type==1){
                $role = Yii::$app->authManager->createRole($model->name);
                $role->description = $model->description;
                Yii::$app->authManager->add($role);
            }

            

            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing AuthItem model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->name]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing AuthItem model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the AuthItem model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return AuthItem the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AuthItem::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionAddpermisiontorole($id)
    {
       // $model_r = $this->findModel($id);

       // $permisions= AuthItemChild::find()->where(['parent'=>$model->name])->all();

        $model = new AuthItemChild();

        if ($model->load(Yii::$app->request->post()) ) {
            
            $model->parent=$id;

            if($model->save(false)){
                return $this->redirect(['view', 'id' => $id]);
            }

            
        }

        return $this->render('addpermis', [
            'model' => $model,
            //'permisions'=>$permisions,
        ]);
    }
}
