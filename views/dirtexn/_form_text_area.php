<?php

use yii\helpers\Html;
//use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\widgets\FileInput;

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

<div class="dir-texn-form">

    <?php $form = ActiveForm::begin(); ?>

    

<?php

   
    echo '<label> '.$title.'</label><br>';
    if($multidata){

        // echo Html::textInput('text_add', options['rows' => '6']);
         echo Html::textarea('text_add', $def_text_add, ['rows' => '6', 'class'=>"form-control", 'readonly' => $disabl_enter]);

    }else{
        
        echo Html::textarea('text_add', $def_text_add, ['rows' => '6', 'class'=>"form-control", 'readonly' => $disabl_enter]);
        
    }

 
?>


<br>
   <div class="form-group">
        <?= Html::submitButton('Задати', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
