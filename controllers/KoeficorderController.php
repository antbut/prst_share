<?php

namespace app\controllers;

use Yii;
use app\models\KoeficOrder;
use app\models\KoeficOrderSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\SysParam;
use yii\filters\AccessControl;

/**
 * KoeficorderController implements the CRUD actions for KoeficOrder model.
 */
class KoeficorderController extends Controller
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
                        'roles' => ['manageKoefic_order'],
                    ],
                    [
                        'actions' => ['view'],
                        'allow' => true,
                        'roles' => ['manageKoefic_order'],
                    ],
                    [
                        'actions' => ['create'],
                        'allow' => true,
                        'roles' => ['manageKoefic_order'],
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
            ]
        ];
    }

    /**
     * Lists all KoeficOrder models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new KoeficOrderSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single KoeficOrder model.
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
     * Creates a new KoeficOrder model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new KoeficOrder();

        if ($model->load(Yii::$app->request->post())) {
            $model->id_creator=Yii::$app->user->id;
            $model->date_create=time();

           if( $model->save(false)){
            
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
                SysParam::SetParam($name_param_obl,$model->id );

                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing KoeficOrder model.
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
     * Deletes an existing KoeficOrder model.
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
     * Finds the KoeficOrder model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return KoeficOrder the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = KoeficOrder::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
