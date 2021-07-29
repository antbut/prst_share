<?php

use yii\helpers\Html;

use yii\widgets\ActiveForm;
use app\models\ProjektTupes;
use yii\helpers\ArrayHelper;
use app\models\Organizations;


/* @var $this yii\web\View */
/* @var $model app\models\Main */

$this->title = 'Додати остаточну ціну проекту '.$model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Mains'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="main-create">

    <h1><?= Html::encode($this->title) ?></h1>
	
	<div class="main-form">

    <?php $form = ActiveForm::begin(); ?>
<?php
        if($tupe==0){
            echo $form->field($model, 'price_pidr_end')->textInput();
        }elseif ($tupe==1) {
            echo $form->field($model, 'price_dogovor_end')->textInput();
        }
        ?>
  


    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'зберегти'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    
</div>
