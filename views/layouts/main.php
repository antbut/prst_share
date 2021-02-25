<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);


    $menyItem=[
            ['label' => 'Головна', 'url' => ['/']],];

    if(\Yii::$app->user->can('manageKoefic_order')){        
            $menyItem[]=['label' => 'Коефіціенти', 'url' => ['/koeficorder/index']];
    }
    if(\Yii::$app->user->can('viewPidryadnuk')){   
            $menyItem[]=['label' => 'Підрядники', 'items' =>[     
                ['label' => 'Підрядники', 'url' => ['/organizations/indexpidr']],
                ['label' => 'Райони підрядника', 'url' => ['/distriktpidr/index']]
            ]];
    }
    

    if(\Yii::$app->user->can('admin')){
       $menyItem[]=['label' => 'Система', 'items' =>[
                        ['label' => 'Користувачі', 'url' => ['/user/index']],
                        ['label' => 'Ролі', 'url' => ['/authitem/index']],
                        ['label' => 'параметри системи', 'url' => ['/site/syssettings']],
                    ]];
    }


    if(Yii::$app->user->isGuest) {
                $menyItem[]=['label' => 'Логін', 'url' => ['/site/login']];
    }else{

            $menyprofitem[]=['label' => 'Профіль', 'url' => ['/user/update', 'id'=>Yii::$app->user->identity->id]];
            $menyprofitem[]=  '<li>'
                . Html::beginForm(['/site/logout'], 'post')
                . Html::submitButton(
                    'Вихід (' . Yii::$app->user->identity->username . ')',
                    ['class' => 'logout']
                )
                . Html::endForm()
                . '</li>';

            $menyItem[]=['label' => Yii::$app->user->identity->username, 'items' =>$menyprofitem];


          /*    $menyItem[]=  '<li>'
                . Html::beginForm(['/site/logout'], 'post')
                . Html::submitButton(
                    'Вихід (' . Yii::$app->user->identity->username . ')',
                    ['class' => 'btn btn-link logout']
                )
                . Html::endForm()
                . '</li>';*/
               
    }


    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menyItem
            
    ]);
    /*
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => [
            ['label' => 'Home', 'url' => ['/site/index']],
            ['label' => 'Технічні директори', 'url' => ['/dirtexn/index']],

            
                ['label' => 'Система', 'items' =>[
                    ['label' => 'Користувачі', 'url' => ['/user/index']],
                    ['label' => 'Ролі', 'url' => ['/authitem/index']],
                ]],
            
            Yii::$app->user->isGuest ? (
                ['label' => 'Логін', 'url' => ['/site/login']]
            ) : (
                '<li>'
                . Html::beginForm(['/site/logout'], 'post')
                . Html::submitButton(
                    'Вихід (' . Yii::$app->user->identity->username . ')',
                    ['class' => 'btn btn-link logout']
                )
                . Html::endForm()
                . '</li>'
            )
        ],
    ]);
    */
    NavBar::end();
    ?>

    <!--div class="container"-->
    <div style="padding-left: 50px">
       
            <?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>
            <?= Alert::widget() ?>
            <?= $content ?>
        
    </div>
</div>


<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; My Company <?= date('Y') ?></p>

        <p class="pull-right"></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
