<?php

namespace app\controllers;

use Yii;
use app\models\Files;
use app\models\Main;
use app\models\Organizations;
use app\models\MainSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use yii\filters\AccessControl;

/**
 * FilesController implements the CRUD actions for Files model.
 */
class ReportController extends Controller
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
                        'actions' => ['objetlcount'],
                        'allow' => true,
                        'roles' => ['reports'],
                    ],
                    

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
        $searchModel = new MainSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionObjetlcount($id=0)
    {
        /*
            id ==
            
            0 - Весь период
            1 - последня неделя
            2 - месяц
            3 - год

        */

        $obls=Organizations::find()->where(['tupe'=>1])->all();
        
            switch ($id) {
                case 0:
                    $start_date = 0;
                    $end_date = strtotime("now");
                    break;
                case 1:
                    $start_date = strtotime("Monday last week");
                    $end_date = strtotime("last Sunday");
                    break;
                case 2:
                    $start_date = mktime(0, 0, 0, date("m"), 1,   date("Y"));
                    $end_date = strtotime("now");
                    break;
                case 3:
                    $start_date = mktime(0, 0, 0, 1, 1,   date("Y"));
                    $end_date= strtotime("now");
                    break;
                default:
                    # code...
                    break;
            }

             //   $start_date= strtotime($start_date);
             //   $end_date = strtotime($end_date);

        foreach ($obls as $obl) {
            $count_new= Main::find()->where(['AND',['id_obl'=>$obl->id], ['>=','status_objekt', 1], ['>=', 'date_last_update', $start_date], ['<=', 'date_last_update', $end_date]])->count();
            $count_P_V= Main::find()->where(['AND',['id_obl'=>$obl->id], ['>=','status_objekt', 4],['<=','status_objekt',7], ['>=', 'date_last_update', $start_date], ['<=', 'date_last_update', $end_date]])->count();
            $count_P_D= Main::find()->where(['AND',['id_obl'=>$obl->id], ['>=','status_objekt', 5],['<=','status_objekt',7], ['>=', 'date_last_update', $start_date], ['<=', 'date_last_update', $end_date]])->count();
            $count_cloce= Main::find()->where(['AND', ['id_obl'=>$obl->id], ['status_objekt'=>7], ['>=', 'date_last_update', $start_date], ['<=', 'date_last_update', $end_date]])->count();

            $result[$obl->title]=['count_new'=>$count_new, 
                                  'count_P_V'=>$count_P_V,
                                  'count_P_D'=>$count_P_D,
                                  'count_cloce'=>$count_cloce];
        }
        


        return $this->render('objets_obl', [
            
            'result'=>$result, 
            'start_date'=>$start_date,
            'end_date'=>$end_date
        ]);
    }

  
    protected function findModel($id)
    {
        if (($model = Main::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

    
}
