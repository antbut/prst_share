<?php

use yii\helpers\Html;

use yii\widgets\ActiveForm;
use app\models\ProjektTupes;
use yii\helpers\ArrayHelper;
use app\models\Organizations;
use app\models\ParentOrg; 


/* @var $this yii\web\View */
/* @var $model app\models\Main */

$this->title = 'Додати дані по проекту '.$model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Mains'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="main-create">

    <h1><?= Html::encode($this->title) ?></h1>
	
	<div class="main-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'price_pidr')->textInput() ?>

    <?//= $form->field($model, 'pidr')->dropDownList(ArrayHelper::map(Organizations::find()->where(['id'=>ParentOrg::GetCostemerObl($model->id_obl) ])->all(), 'id', 'title')) ?>

    <?php 
   //     echo $model->id_obl;
     //   var_dump(ParentOrg::GetCostemerObl($model->id_obl));
     ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    
</div>
