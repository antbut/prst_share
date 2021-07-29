<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ObjektLog */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="objekt-log-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id')->textInput() ?>

    <?= $form->field($model, 'date')->textInput() ?>

    <?= $form->field($model, 'id_user')->textInput() ?>

    <?= $form->field($model, 'id_objekt')->textInput() ?>

    <?= $form->field($model, 'id_obl')->textInput() ?>

    <?= $form->field($model, 'changet_colum')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'coment')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
