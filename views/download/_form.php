<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;


use kartik\widgets\FileInput;



/* @var $this yii\web\View */
/* @var $model app\models\DownloadFiles */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="download-files-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'data_create')->textInput() ?>

    <?= $form->field($model, 'id_creator')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
