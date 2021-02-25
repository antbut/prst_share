<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Organizations;
use app\models\AuthItem;
use app\models\AuthAssignment;
use app\models\Types;
//use kartik\widgets\PasswordInput;
//use kartik\date\PasswordInput;
use kartik\password\PasswordInput;

use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'username')->textInput(['readonly' => Yii::$app->user->can('updateUsers') ? false : true]) ?>
    <?= $form->field($model, 'view_name')->textInput(['readonly' => Yii::$app->user->can('updateUsers') ? false : true]) ?>
    <?= $form->field($model, 'email')->textInput(['readonly' => Yii::$app->user->can('updateUsers') ? false : true]) ?>
    
    <?//= $form->field($model, 'password')->passwordInput() ?>

    <?= Html::label('Пароль  ', 'passwd') ?>
    <?//= Html::passwordInput('passwd',['class'=>'form-control']) ?><br>

     <?= PasswordInput::widget(['name' => 'passwd', 'language' => 'ru']) ?>
    <?//= $form->field($model, 'status')->textInput() ?>

    <?= $form->field($model, 'id_organization')->dropDownList(ArrayHelper::map(Organizations::find()->all(), 'id', 'title'),['style'=>'display:'.(Yii::$app->user->can('updateUsers') ? true : 'none;')]) ?>

    <?= Html::label('Роль  ', 'role') ?>
    <?= Html::dropDownList('role', AuthAssignment::findOne(['user_id'=>$model->id])->item_name, ArrayHelper::map(AuthItem::find()->where(['type'=>1])->all(), 'name', 'description'),['class'=>'form-control','style'=>'display:'.(Yii::$app->user->can('updateUsers') ? true : 'none;')]) ?>
    <br>
    
    
    <br>
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
