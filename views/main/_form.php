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

    <?= $form->field($model, 'customer')->textarea(['rows' => 2]) ?>

    <?= $form->field($model, 'n_dogoovor')->textInput(['maxlength' => true, 'disabled'=> true, 'value' => $n_dogov]) ?>

    

    <?= $form->field($model, 'id_project_type')->dropDownList(ArrayHelper::map(ProjektTupes::find()->all(), 'id', 'title')) ?>
    

    <?php 
        if($model->status_objekt<2){
            echo  $form->field($model, 'id_district')->dropDownList(ArrayHelper::map(DistriktPidr::find()->where(['id_obl'=>$id_obl])->all(), 'id', 'title'), ['prompt' => 'Вкажіть Район...']) ;
        }else{
            echo  $form->field($model, 'id_district')->dropDownList(ArrayHelper::map(DistriktPidr::find()->where(['id_obl'=>$id_obl])->all(), 'id', 'title'), ['disabled' => 'disabled'],['prompt' => 'Вкажіть Район...']);
        } ?>

    <?php 
	
		
        echo '<label> Дата оплати  </label>';

		echo DatePicker::widget([
				'name' => 'data', 
				//'value' => date('d-m-Y', $model->date_payment ),
				'options' => ['placeholder' => '---- Вкажіть дату ---','required'=>true],
			   // 'disabled' => true,
				'pluginOptions' => [
					'format' => 'dd-mm-yyyy',
					'todayHighlight' => true,
			//'maxFileSize'=>200
				],

		]);
		
		echo '<label>Нормативна дата виконання роботи </label>';

		echo DatePicker::widget([
				'name' => 'date_norm_run', 
				'value' => date('d-m-Y', $model->date_norm_run_work ),
				'options' => ['placeholder' => '---- Вкажіть дату ---','required'=>true],
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
