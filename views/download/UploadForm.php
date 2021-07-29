<?php
//use yii\widgets\ActiveForm;

use yii\bootstrap4\Modal;
use kartik\form\ActiveForm;
use kartik\widgets\DateTimePicker;
use kartik\date\DatePicker;
use kartik\widgets\FileInput;
?>

<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

<?//= $form->field($model, 'file')->fileInput() ?>

<?php
echo FileInput::widget([
                    'model' => $model,
                    'attribute' => 'file',
                 //   'options' => ['multiple' => true]
    ]);
?>
<button>Submit</button>

<?php ActiveForm::end() ?>