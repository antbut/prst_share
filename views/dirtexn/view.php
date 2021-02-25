<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\User;
use app\models\Organizations;

/* @var $this yii\web\View */
/* @var $model app\models\DirTexn */

$this->title = $model->title;
//$this->params['breadcrumbs'][] = ['label' => 'Роботи технічна дирекція', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="dir-texn-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?//= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?/*= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) */?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
           // 'id',
            'title:ntext',
           // 'n_ofer',
           // 'd_ofer',
		
            'pidr:ntext',
         //   'deskription:ntext',
           // 'd_opl_avans',
           // 'd_start_work',
           // 'd_enter_control_p',
           // 'd_enter_controll',
          //  'enter_controll:ntext',
          //  'd_shadow_work_p',
          //  'd_shadow_work',
           // 'shadow_work:ntext',
           // 'd_end_interim_work_p',
           // 'd_end_interim_work',
          //  'end_interim_work:ntext',
           // 'd_end_work_p',
           // 'd_end_work',
           // 'end_work:ntext',
          //  'd_assept_work_p',
           // 'd_assept_work',
           // 'assept_work:ntext',
        //    'data_create',
	   ['attribute'=>'data_create',
                'value'=> function($data){
                return date('d.m.Y', $data->data_create);   
                 }
            ],
         //   'id_creator',
	 ['attribute'=>'id_creator',
                'value'=> function($data){
                return  User::findOne($data->id_creator)->view_name;   
                 }
            ],
        //    'id_organization',
	['attribute'=>'id_organization',
                'value'=> function($data){
                return  Organizations::findOne($data->id_organization)->title;   
                 }
            ],
          //  'statys',
          //  'id_type',
        ],
    ]) ?>

</div>
