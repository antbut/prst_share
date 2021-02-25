<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\DistriktPidr */

$this->title = 'Update Distrikt Pidr: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Distrikt Pidrs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="distrikt-pidr-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
