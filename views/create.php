<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\DirTexn */

$this->title = 'Додати роботу';
$this->params['breadcrumbs'][] = ['label' => 'Роботи технічна дирекція', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dir-texn-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
