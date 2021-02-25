<?php

namespace app\controllers;

use Yii;
use app\models\User;
use app\models\UserSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\models\AuthAssignment;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
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
                    'roles' => ['viewsUsers'],
                ],
                [
                    'actions' => ['create'],
                    'allow' => true,
                    'roles' => ['cereateUsers'],
                ],
                [
                    'actions' => ['update'],
                    'allow' => true,
                    'roles' => ['updateUsers'],
                        'roleParams' => function() {
                                return ['id_user' => Yii::$app->request->get('id')];
                        },
                ],
                [
                    'actions' => ['delete'],
                    'allow' => true,
                    'roles' => ['deleteUsers'],
                ],
                [
                    'actions' => ['view'],
                    'allow' => true,
                    'roles' => ['viewsUsers'],
                ],



            ],
        ]
        ];
    }

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
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
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new User();

        if ($model->load(Yii::$app->request->post())) {
        
                if(strlen(Yii::$app->request->post('passwd'))>7 ){
                   
                   $model->setPassword(Yii::$app->request->post('passwd'));
                   $model->generateAuthKey();
                   $model->save();

                   $auth = new AuthAssignment();
                   $auth->item_name=Yii::$app->request->post('role');
                   $auth->user_id= User::findOne(['username'=>$model->username])->id;
                   $auth->save(false);

                    return $this->redirect(['view', 'id' => $model->id]);
                    
                }else{
                    return $this->render('create', [
                    'model' => $model,
                    ]);
                }



            
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $auth= AuthAssignment::findOne(['user_id'=>$id]);

        if ($model->load(Yii::$app->request->post())) {

            if(!empty(Yii::$app->request->post('passwd'))){
                if(strlen(Yii::$app->request->post('passwd'))>7 ){
                    $model->setPassword(Yii::$app->request->post('passwd'));
                }
            }

            $model->generateAuthKey();

            if($auth==null){
                $auth= new AuthAssignment();
                $auth->user_id=$id;

            }

              $auth->item_name=Yii::$app->request->post('role');
              $auth->save(false);

            if ($model->save()) {
                        return $this->redirect(['update', 'id' => $model->id, 'auth'=>$auth->item_name]);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing User model.
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
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
