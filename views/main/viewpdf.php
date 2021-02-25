<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\ProjektTupes;
use app\models\Organizations;
use app\models\UploadForm;
use yii\helpers\Url;
use app\models\PidrComents;
use app\models\User;
use app\models\KoeficOrder;
use app\models\Files;
use kartik\mpdf\Pdf;


/* @var $this yii\web\View */
/* @var $model app\models\Main */

////$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Mains'), 'url' => ['index']];
?>
<div class="main-view">

    <h4><?= Html::encode($model->title) ?></h1>

    <p>
        

     
   
    
     </p>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
          //  'id',
            ['label'=>'Дата створення',
                'value'=> function($data){
                return date('d.m.Y', $data->date_create);   
                 }
            ],
            'title:ntext',
            'adress:ntext',
            'n_dogoovor',
           // 'price_dogovor',
          //  'price_pidr',
          //  'pidr',
          //  'status_pidr',
          //  'status_objekt',
         //   'id_obl',
            ['label'=>'Обленерго',
                'value'=> function($data){
                return  Organizations::findOne($data->id_obl)->title;   
                 }
            ],
         //   'date_create',
          //  'files_pojekt:ntext',
          //  'id_project_type',
            ['label'=>'Тип проекту',
                'value'=> function($data){
                return  ProjektTupes::findOne($data->id_project_type)->title;   
                 }
            ],
            ['label'=>'Підрядник ',
              'visible' => Yii::$app->user->can('viewPrices'),
                'value'=> function($data){
                return  Organizations::findOne($data->pidr)->title;   
                 }
              ],
          //  'file_resoyrs_report:ntext',
        ],
    ]) ?>


<?php

    if(\Yii::$app->user->can('viewPrices') ){ 
          echo DetailView::widget([
          'model' => $model,
          'attributes' => [
            
              'price_dogovor',
              'price_pidr',
             // 'pidr',
            /*  ['label'=>'Підрядник ',
                'value'=> function($data){
                return  Organizations::findOne($data->pidr)->title;   
                 }
              ],*/
              'price_dogovor_end',
              'price_pidr_end',

            //  'status_pidr',
            //  'status_objekt',
           
             
          ],
        ]) ;
      }
      if(\Yii::$app->user->can('viewKoefic_order') ){ 
          echo DetailView::widget([
          'model' => $model,
          'attributes' => [
            
              
              ['label'=>'Встановлений коефіціент ',
                'value'=> function($data){
                    return  KoeficOrder::findOne($data->id_koef)->value;   
                 }
              ],
              ['label'=>'наявний коефіціент ',
                'value'=> function($data){
                  if($data->price_pidr_end!=0){
                    return number_format ($data->price_dogovor_end/$data->price_pidr_end, 3 );   
                  }else{
                    return 0;
                  }
                 }
              ],
           
          ],
        ]) ;
      }

    echo '</div>';
    

    if(\Yii::$app->user->can('viewFiles_TY') ){
      echo "<h4><p> файли Технічних умов<p></h4>";
	  
	  
	  
      if($model->files_ty!= null){
        foreach (json_decode ($model->files_ty,true) as  $value) {
        //  echo '<p>'. $value['name'];
		
		
          echo date('d.m.Y',Files::findOne($value['id'])->data_create).' <a href="'.Url::to(['files/viewfile', 'id' => $value['id']]).'"  target="_blank">'.$value['name'].'</a>';
        }
      }else{
        echo "<p>Файли ще не завантажено";
      }
       echo '<hr>';
    }
    if(\Yii::$app->user->can('viewFiles_project') ){
      echo "<h4><p> файли проекту <p></h4>";
      if($model->files_pojekt!= null){
        foreach (json_decode ($model->files_pojekt,true) as  $value) {
          echo  ($value['p_type']=='end' ? 'Остаточна версія' :' ');
          echo date('d.m.Y',Files::findOne($value['id'])->data_create).' <a href="'.Url::to(['files/viewfile', 'id' => $value['id']]).'"  target="_blank">'.$value['name'].'</a><br>';
        }
      }else{
        echo "<p>Файли ще не завантажено";
      }
      echo '<hr>';
    }
    if(\Yii::$app->user->can('viewFiles_Smeta') ){
      echo "<h4><p> файли смети <p></h4>";
      if($model->files_smeta!= null){
        foreach (json_decode ($model->files_smeta,true) as  $value) {
          //echo '<p>'. $value['name'];
          if(\Yii::$app->user->can('Oblenergo') && ($value['s_type']=='p' || $value['s_type']=='pn')){

          }else{
            echo 'смета '. ($value['s_type']=='end' ? 'Остаточна версія' : ($value['s_type']=='pn' ? 'p скоригована' : $value['s_type'] ) ).'   ';
            echo date('d.m.Y',Files::findOne($value['id'])->data_create).' <a href="'.Url::to(['files/viewfile', 'id' => $value['id']]).'"  target="_blank">'.$value['name'].'</a><br>';
          }
        }
      }else{
        echo "<p>Файли ще не завантажено";
      }
      echo '<hr>';
    }

    if(\Yii::$app->user->can('viewFiles_Resoyrce_report') ){
      echo "<h4><p> файли Відомість ресурсів <p></h4>";
      if($model->file_resoyrs_report!= null){
        foreach (json_decode ($model->file_resoyrs_report,true) as  $value) {
          //echo '<p>'. $value['name'];
          echo 'Відомість '. $value['r_type'].'   ';
          echo date('d.m.Y',Files::findOne($value['id'])->data_create).' <a href="'.Url::to(['files/viewfile', 'id' => $value['id']]).'"  target="_blank">'.$value['name'].'</a><br>';
        }
      }else{
        echo "<p>Файли ще не завантажено";
      }
      echo '<hr>';
    }

    if(\Yii::$app->user->can('viewHistoryPidryadnik') ){
      echo "<h4>істрія взаємодії з підрядником погодження виконання робіт</h4><br>";
        if($model->pidr_coment!=null){
            echo '<table class="table table-striped table-bordered detail-view">';
            foreach (json_decode ($model->pidr_coment,true) as  $value) {
              $prid=PidrComents::findOne($value);

              if($prid->tupe_coment==0){
                echo '<tr><td>'.date('d.m.Y',$prid->date_create).'</td><td>'.$prid->coment.'</td><td>'.Organizations::findOne($prid->id_organization)->title.'</td><td>'.User::findOne($prid->id_creator)->view_name.'</td></tr>';
              }
            }
            echo "</table>";
        }else{
          echo "Підрядник не давав своїх коментарів";
        }
      echo "<h4>істрія взаємодії з підрядником по ПКД</h4><br>";

        if($model->pidr_coment!=null){
            echo '<table class="table table-striped table-bordered detail-view">';
            foreach (json_decode ($model->pidr_coment,true) as  $value) {
              $prid=PidrComents::findOne($value);

              if($prid->tupe_coment==1){
                echo '<tr><td>'.date('d.m.Y',$prid->date_create).'</td><td>'.$prid->coment.'</td><td>'.Organizations::findOne($prid->id_organization)->title.'</td><td>'.User::findOne($prid->id_creator)->view_name.'</td></tr>';
              }
            }
            echo "</table>";
        }else{
          echo "Підрядник не давав своїх коментарів";
        }
      echo "<h4>істрія взаємодії з Директором Сервісного центру по сметі</h4><br>";
      if($model->pidr_coment!=null){
            echo '<table class="table table-striped table-bordered detail-view">';
            foreach (json_decode ($model->pidr_coment,true) as  $value) {
              $prid=PidrComents::findOne($value);

              if($prid->tupe_coment==2){
                echo '<tr><td>'.date('d.m.Y',$prid->date_create).'</td><td>'.$prid->coment.'</td><td>'.Organizations::findOne($prid->id_organization)->title.'</td><td>'.User::findOne($prid->id_creator)->view_name.'</td></tr>';
              }
            }
            echo "</table>";
      }else{
          echo "не давав своїх коментарів";
      }
    }

?>

