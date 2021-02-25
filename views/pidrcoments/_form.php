<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\PidrComents */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pidr-coments-form">

    <?php $form = ActiveForm::begin(); ?>

    <?//= $form->field($model, 'id_obj')->textInput() ?>

    <?//= $form->field($model, 'date_create')->textInput() ?>

    <?//= $form->field($model, 'id_creator')->textInput() ?>

    <?= $form->field($model, 'coment')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Зберегти коментар'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
