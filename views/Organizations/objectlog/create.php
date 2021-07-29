<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ObjektLog */

$this->title = 'Create Objekt Log';
$this->params['breadcrumbs'][] = ['label' => 'Objekt Logs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="objekt-log-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
