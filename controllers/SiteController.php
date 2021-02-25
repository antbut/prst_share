<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\User;
use app\models\SysParam;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    /*
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
         //       'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
		    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
		     [
                        'actions' => ['syssettings'],
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
		     [
                        'allow' => true,
                        'actions' => ['login', 'signup'],
                        'roles' => ['?'],
                    ],
		    [
                        'actions' => ['error'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }
    */
    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionSyssettings()
    {
        $df = disk_free_space(getcwd());
        $dt = disk_total_space("/");



        $i=0;
        $iec = array("B", "Kb", "Mb", "Gb", "Tb");
        while (($df/1024)>1) {
            $df=$df/1024;
            $i++;
        }
        $df=round($df,2).$iec[$i] ;
         $i=0;
        $iec = array("B", "Kb", "Mb", "Gb", "Tb");
        while (($dt/1024)>1) {
            $dt=$dt/1024;
            $i++;
        }
        $dt=round($dt,2).$iec[$i] ;

        $sys=SysParam::find()->all();
       // $df=round($size,1)." ".$iec[$i];

        return $this->render('syssett',['free_disk'=>$df,'full_disk'=>$dt, 'sys_par'=>$sys]);
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionRoles(){

/*
        $role = Yii::$app->authManager->createRole('admin');
        $role->description = 'Администратор';
        Yii::$app->authManager->add($role);

        $moder = Yii::$app->authManager->createRole('moderator');
        $moder->description = 'Модератор';
        Yii::$app->authManager->add($moder);

        $obl = Yii::$app->authManager->createRole('obl');
        $obl->description = 'Представитель обленерго';
        Yii::$app->authManager->add($obl);

        $ban = Yii::$app->authManager->createRole('baned');
        $ban->description = 'Вимкнений';
        Yii::$app->authManager->add($ban);

       
    $model = User::find()->where(['username' => 'admin'])->one();
    if (empty($model)) {
        $user = new User();
        $user->username = 'admin';
        $user->email = 'admin@кодер.укр';
        $user->setPassword('admin');
        $user->generateAuthKey();
        if ($user->save()) {
            echo 'good';
        }
    }


        $permit = Yii::$app->authManager->createPermission('dirtexnCreate');
        $permit->description = 'Создание работ технической дирекции';
        Yii::$app->authManager->add($permit);

        


        $role = Yii::$app->authManager->getRole('admin');
        $permit = Yii::$app->authManager->getPermission('cereateUsers');
        Yii::$app->authManager->addChild($role, $permit);

*/
       /* 
        $userRole = Yii::$app->authManager->getRole('admin');
        Yii::$app->authManager->assign($userRole, 1);
        */
        /*
        $role = Yii::$app->authManager->getRole('texnDirUser');
        $permit = Yii::$app->authManager->getPermission('dirtexnviewfiles');
        Yii::$app->authManager->addChild($role, $permit);

*/
/*
        $auth = Yii::$app->authManager;
 
        // добовляем правило
        $rule = new \app\rules\CuruserRule;
        $auth->add($rule);
        

        $auth = Yii::$app->authManager;
        $updateOwnPost = $auth->createPermission('updateUser');
        $updateOwnPost->description = 'Редактировать Своего пользователя';
        $updateOwnPost->ruleName =  $rule->name;
        $auth->add($updateOwnPost);
      */

        $permit = Yii::$app->authManager->createPermission('FilePreload');
        $permit->description = 'Перегляд завантажених файлів';
        Yii::$app->authManager->add($permit);


        
    }

}
