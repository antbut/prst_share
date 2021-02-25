<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Organizations;

/* @var $this yii\web\View */
/* @var $model app\models\DistriktPidr */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="distrikt-pidr-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textarea(['rows' => 6]) ?>

    <?//= $form->field($model, 'id_pidr')->textInput() ?>

    <?= $form->field($model, 'id_pidr')->dropDownList(ArrayHelper::map(Organizations::find()->where(['tupe'=>2])->all(), 'id', 'title')) ?>

    <?//= $form->field($model, 'id_obl')->textInput() ?>
    <?= $form->field($model, 'id_obl')->dropDownList(ArrayHelper::map(Organizations::find()->where(['tupe'=>1])->all(), 'id', 'title')) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
