<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\DirTexn */

$this->title = $title.' для: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'головна', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Додати дату';
?>
<div class="dir-texn-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form_date', [
        'model' => $model,  'title'=>$title ,'model_f'=>$model_f, 'def_date'=>$def_date
    ]) ?>

</div>
