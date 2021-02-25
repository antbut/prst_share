<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\KoeficOrder */

$this->title = Yii::t('app', 'Create Koefic Order');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Koefic Orders'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="koefic-order-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
