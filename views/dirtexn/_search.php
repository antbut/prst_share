<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\DirtexnSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="dir-texn-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'title') ?>

    <?= $form->field($model, 'n_ofer') ?>

    <?= $form->field($model, 'd_ofer') ?>

    <?= $form->field($model, 'pidr') ?>

    <?php // echo $form->field($model, 'deskription') ?>

    <?php // echo $form->field($model, 'd_opl_avans') ?>

    <?php // echo $form->field($model, 'd_start_work') ?>

    <?php // echo $form->field($model, 'd_enter_control_p') ?>

    <?php // echo $form->field($model, 'd_enter_controll') ?>

    <?php // echo $form->field($model, 'enter_controll') ?>

    <?php // echo $form->field($model, 'd_shadow_work_p') ?>

    <?php // echo $form->field($model, 'd_shadow_work') ?>

    <?php // echo $form->field($model, 'shadow_work') ?>

    <?php // echo $form->field($model, 'd_end_interim_work_p') ?>

    <?php // echo $form->field($model, 'd_end_interim_work') ?>

    <?php // echo $form->field($model, 'end_interim_work') ?>

    <?php // echo $form->field($model, 'd_end_work_p') ?>

    <?php // echo $form->field($model, 'd_end_work') ?>

    <?php // echo $form->field($model, 'end_work') ?>

    <?php // echo $form->field($model, 'd_assept_work_p') ?>

    <?php // echo $form->field($model, 'd_assept_work') ?>

    <?php // echo $form->field($model, 'assept_work') ?>

    <?php // echo $form->field($model, 'data_create') ?>

    <?php // echo $form->field($model, 'id_creator') ?>

    <?php // echo $form->field($model, 'statys') ?>

    <?php // echo $form->field($model, 'id_type') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
