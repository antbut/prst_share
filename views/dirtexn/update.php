<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\DirTexn */

$this->title = 'Update Dir Texn: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Dir Texns', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="dir-texn-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
