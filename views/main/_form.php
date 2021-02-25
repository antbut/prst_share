<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\ProjektTupes;
use yii\helpers\ArrayHelper;
use  app\models\DistriktPidr;
use kartik\widgets\DateTimePicker;
use kartik\date\DatePicker;


/* @var $this yii\web\View */
/* @var $model app\models\Main */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="main-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'adress')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'n_dogoovor')->textInput(['maxlength' => true, 'disabled'=> true, 'value' => $n_dogov]) ?>

    

    <?= $form->field($model, 'id_project_type')->dropDownList(ArrayHelper::map(ProjektTupes::find()->all(), 'id', 'title')) ?>
    

    <?= $form->field($model, 'id_district')->dropDownList(ArrayHelper::map(DistriktPidr::find()->where(['id_obl'=>$id_obl])->all(), 'id', 'title'),['prompt' => 'Вкажіть Район...']) ?>

    <?php 
        echo '<label> Дата оплати  </label>';

    echo DatePicker::widget([
            'name' => 'data', 
            'value' => date('d-m-Y', time()),
            'options' => ['placeholder' => '---- Вкажіть дату ---'],
           // 'disabled' => true,
            'pluginOptions' => [
                'format' => 'dd-mm-yyyy',
                'todayHighlight' => true,
        //'maxFileSize'=>200
            ],

    ]);
     ?>

    <?//= $form->field($model, 'file_resoyrs_report')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
