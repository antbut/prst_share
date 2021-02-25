<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\DirtexnSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Роботи технічна дирекція';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dir-texn-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Dir Texn', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'title:ntext',
            'n_ofer',
            'd_ofer',

            ['label'=>'Дата договору',
                'value'=> function($data){
                return date('d.m.Y', $data->d_ofer);   
                 }
            ],
            'pidr:ntext',
            'deskription:ntext',
            'd_opl_avans',

            ['label'=>'Дата Авансу',
                'value'=> function($data){
                return date('d.m.Y', $data->d_opl_avans);   
                 }
            ],
            'd_start_work',

            ['label'=>'Дата початку робіт',
                'value'=> function($data){
                return date('d.m.Y', $data->d_start_work);   
                 }
            ],
            'd_enter_control_p',
            'd_enter_controll',
            'enter_controll:ntext',
            'd_shadow_work_p',
            'd_shadow_work',
            'shadow_work:ntext',
            'd_end_interim_work_p',
            'd_end_interim_work',
            'end_interim_work:ntext',
            'd_end_work_p',
            'd_end_work',
            'end_work:ntext',
            'd_assept_work_p',
            'd_assept_work',
            'assept_work:ntext',
            //'data_create',
            //'id_creator',
            'statys',
            //'id_type',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
