<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\DistriktPidr */

$this->title = 'Create Distrikt Pidr';
$this->params['breadcrumbs'][] = ['label' => 'Distrikt Pidrs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="distrikt-pidr-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
