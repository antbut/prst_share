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

   
    echo '<label> '.$title.'</label>';
    if($multidata){

        echo $form->field($model, 'tempdata')->widget(MultipleInput::className(), [
                'max' => 4,
                'columns' => [
                    
                    [
                        'name'  => 'day',

                        'type'  => \kartik\date\DatePicker::className(),
                        'title' => '',
                        'value' => function($data) {
                            return $data['day'];
                        },
                        
                        'options' => [
                            'pluginOptions' => [
                                'format' => 'dd.mm.yyyy',
                                'todayHighlight' => true,
                                'placeholder' => '---- Вкажіть дату ---'
                            ]
                        ]
                    ],
                    
                ]
             ]);

    }else{

        echo DatePicker::widget([
                'name' => 'data', 
                'value' => date('d-m-Y', $def_date),
                'options' => ['placeholder' => '---- Вкажіть дату ---'],
                'disabled' => $disabl_enter,
                'pluginOptions' => [
                    'format' => 'dd-mm-yyyy',
                    
    		//'maxFileSize'=>200
                ],

        ]);
    }

 
?>


<br>
   <div class="form-group">
        <?= Html::submitButton('Задати', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
