<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\User;
use app\models\Organizations;

/* @var $this yii\web\View */
/* @var $model app\models\KoeficOrder */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Koefic Orders'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="koefic-order-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'value',
            //'id_obl',
            [
                'attribute'=>'id_obl',
                'value'=> function($data){
                return  Organizations::findOne($data->id_obl)->title;   
                 }
            ],

            [
                'attribute'=>'id_creator',
                'value'=> function($data){
                return  User::findOne($data->id_creator)->view_name;   
                 }
            ],
         //   'id_creator',
          
            [
              'attribute'=>'date_create',
                'value'=> function($data){
                return date('d.m.Y', $data->date_create);   
                 }
            ],
        ],
    ]) ?>

</div>
