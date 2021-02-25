<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Organizations;
use app\models\User;

/* @var $this yii\web\View */
/* @var $model app\models\KoeficOrder */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="koefic-order-form">

    <?php $form = ActiveForm::begin(); ?>

    <?//= $form->field($model, 'id')->textInput() ?>

    <?= $form->field($model, 'value')->textInput() ?>

    <?= $form->field($model, 'id_obl')->dropDownList(ArrayHelper::map(Organizations::find()->where(['tupe'=>1])->all(), 'id', 'title')) ?>

    <?//= $form->field($model, 'id_creator')->textInput() ?>

    <?//= $form->field($model, 'date_create')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
