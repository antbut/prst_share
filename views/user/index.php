<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Organizations;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Користувачі';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create User', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

          //  'id',
            'username',
	     'view_name',
            //'auth_key',
            //'password_hash',
            //'password_reset_token',
           // 'email:email',
            'status',
           // 'id_obl',
            ['label'=>'id_oorganization',
                'value'=> function($data){
                    return Organizations::findOne($data->id_organization)->title;
                  
                 },
		'filter' => Html::activeDropDownList(
                    $searchModel,
                    'id_organization',
                    ArrayHelper::map(Organizations::find()->all(), 'id', 'title'),
                    ['class' => 'form-control', 'prompt' => 'Все']
                ),
            ],
            //'created_at',
            //'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
