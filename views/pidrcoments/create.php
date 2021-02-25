<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\PidrComents */

$this->title = Yii::t('app', 'Додати коментар');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Pidr Coments'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pidr-coments-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
