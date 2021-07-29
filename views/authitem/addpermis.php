<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\AuthItem */

$this->title = 'addpermis';
//$this->params['breadcrumbs'][] = ['label' => 'Ролі', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="auth-item-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_addpermis', [
        'model' => $model,
    ]) ?>

</div>
