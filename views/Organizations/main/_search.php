<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\MainSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="main-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'title') ?>

    <?= $form->field($model, 'adress') ?>

    <?= $form->field($model, 'n_dogoovor') ?>

    <?= $form->field($model, 'price_dogovor') ?>

    <?php // echo $form->field($model, 'price_pidr') ?>

    <?php // echo $form->field($model, 'pidr') ?>

    <?php // echo $form->field($model, 'status_pidr') ?>

    <?php // echo $form->field($model, 'status_objekt') ?>

    <?php // echo $form->field($model, 'id_obl') ?>

    <?php // echo $form->field($model, 'date_create') ?>

    <?php // echo $form->field($model, 'files_pojekt') ?>

    <?php // echo $form->field($model, 'id_project_type') ?>

    <?php // echo $form->field($model, 'file_resoyrs_report') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
