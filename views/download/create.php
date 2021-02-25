<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\DownloadFiles */

$this->title = 'Create Download Files';
$this->params['breadcrumbs'][] = ['label' => 'Download Files', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="download-files-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
