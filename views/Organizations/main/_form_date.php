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
/* @var $this yii\web\View */
/* @var $model app\models\DirTexn */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="dir-texn-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    

<?php

  
    echo '<label class="control-label">Upload Document</label>';
/*    echo FileInput::widget([
                            'name' => 'files[]',
                            'options' => ['multiple' => true]
                            ]);

*/
    echo FileInput::widget([
                    'model' => $model_f,
                    'attribute' => 'file[]',
                    'options' => ['multiple' => true]
    ]);
?>


<br>
   <div class="form-group">
        <?= Html::submitButton('Зберегти', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
