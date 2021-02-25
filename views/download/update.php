<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\DownloadFiles */

$this->title = 'Update Download Files: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Download Files', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="download-files-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
