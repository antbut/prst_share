<?php

use yii\helpers\Html;
//use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

use yii\bootstrap4\Modal;
use kartik\form\ActiveForm;
use kartik\widgets\DateTimePicker;
use kartik\date\DatePicker;

use app\models\Organizations;
use app\models\Types;
use unclead\multipleinput\MultipleInput;
/* @var $this yii\web\View */
/* @var $model app\models\DirTexn */
/* @var $form yii\widgets\ActiveForm */
?>



    <?php $form = ActiveForm::begin(); ?>

    <div class="dir-texn-form">
    <?php
    echo '<label>Дата</label>';
    echo DatePicker::widget([
    'name' => 'd_asept_dad_w', 
   // 'value' => date('d-M-Y', strtotime('+2 days')),
    'options' => ['placeholder' => '---- Вкажіть дату ---'],
    'pluginOptions' => [
        'format' => 'dd-mm-yyyy',
        'todayHighlight' => true
    ]
    ]);?>

    <?= $form->field($model, 'title')->textarea(['rows' => 4]) ?>

    

    <?= $form->field($model, 'pidr')->textarea(['rows' => 4]) ?>

    <?//= $form->field($model, 'deskription')->textarea(['rows' => 6]) ?>

    <?//= $form->field($model, 'd_opl_avans')->textInput() ?>

    <?php  
?>

    <?= $form->field($model, 'id_type')->dropDownList($tupes) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>


