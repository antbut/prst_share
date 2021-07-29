<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\AuthItemChild;
use app\models\AuthItem;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\AuthItem */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="auth-item-form">

    <?php $form = ActiveForm::begin(); ?>
    <?php
        $permisions= AuthItem::find()->where(['type'=>2])->all();
    ?>

    <?//= $form->field($model, 'type')->textInput() ?>
    <?= $form->field($model, 'child')->dropDownList(ArrayHelper::map($permisions, 'name', 'description')) ?>

    

    <?//= $form->field($model, 'rule_name')->textInput(['maxlength' => true]) ?>

    <?//= $form->field($model, 'data')->textInput() ?>

    <?//= $form->field($model, 'created_at')->textInput() ?>

    <?//= $form->field($model, 'updated_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
