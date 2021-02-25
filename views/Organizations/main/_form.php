<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\ProjektTupes;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Main */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="main-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'adress')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'n_dogoovor')->textInput(['maxlength' => true, 'disabled'=> true, 'value' => $n_dogov]) ?>

    <?//= $form->field($model, 'price_dogovor')->textInput() ?>

    <?//= $form->field($model, 'price_pidr')->textInput() ?>

    <?//= $form->field($model, 'pidr')->textInput() ?>

    <?//= $form->field($model, 'status_pidr')->textInput() ?>

    <?//= $form->field($model, 'status_objekt')->textInput() ?>

    <?//= $form->field($model, 'id_obl')->textInput() ?>

    <?//= $form->field($model, 'date_create')->textInput() ?>

    <?//= $form->field($model, 'files_pojekt')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'id_project_type')->dropDownList(ArrayHelper::map(ProjektTupes::find()->all(), 'id', 'title')) ?>

    <?//= $form->field($model, 'file_resoyrs_report')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
