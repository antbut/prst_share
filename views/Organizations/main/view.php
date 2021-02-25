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

$this->title = $model->title;
//$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Mains'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="main-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php
        if(\Yii::$app->user->can('admin') ){ ?>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ])    ?>
		<?= Html::a(Yii::t('app', 'Заміна підрядника примусово'), ['contactorchange', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        
    <?php } 
		if(\Yii::$app->user->can('viewpdf') ){ ?>
		<?= Html::a(Yii::t('app', 'PDF'), ['viewpdf', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
		<?php }?>
    
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
              'visible' => Yii::$app->user->can('viewPidryadnukObjekt'),
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

    //загрузть П1
    if(\Yii::$app->user->can('uploadProjectFiles') && $model->status_objekt<1 ){ 
        echo Html::a(Yii::t('app', 'Завантажити Технічні умови'), ['uploadprojektfile', 'id_project' => $model->id, 'type_file'=>1], ['class' => 'btn btn-primary']);
        echo Html::a(Yii::t('app', 'Завантажити Проект'), ['uploadprojektfile', 'id_project' => $model->id, 'type_file'=>2], ['class' => 'btn btn-primary']);
        echo Html::a(Yii::t('app', 'Завантажити Смету'), ['uploadprojektfile', 'id_project' => $model->id, 'type_file'=>3], ['class' => 'btn btn-primary']);
        echo Html::a(Yii::t('app', 'Задати ціну і підрядника'), ['addpidrinfo', 'id' => $model->id, ], ['class' => 'btn btn-primary']);
    }
    // согласование подрядчика
    if(\Yii::$app->user->can('setPidradnikStatus') && $model->status_objekt==1){ 
      echo "<br>";

      if($model->pidr!=0){
        echo Html::a(Yii::t('app', 'Не приймаю роботу'), ['pidrcoments/noagree', 'id_project' => $model->id, 'tupe_coment'=>0], ['class' => 'btn btn-danger']);
      }
        echo Html::a(Yii::t('app', 'Приймаю роботу'), ['pidrcoments/agree', 'id_project' => $model->id, 'tupe_coment'=>0], ['class' => 'btn btn-success']);
        echo Html::a(Yii::t('app', 'Є правки стосовно роботи'), ['pidrcoments/coment', 'id_project' => $model->id, 'tupe_coment'=>0], ['class' => 'btn btn-primary']);
    }
/*	if(\Yii::$app->user->can('uploadProjectFiles') && $model->status_objekt==1 && ($model->status_pidr==3 || $model->status_pidr==4) ){
		echo Html::a(Yii::t('app', 'Дати відповідь по коментарю'), ['pidrcoments/coment', 'id_project' => $model->id, ], ['class' => 'btn btn-primary']);
	}*/

    // ответ на согласование подрядчка
    if(\Yii::$app->user->can('setPidradnikAnsver') && $model->status_objekt==1 && ($model->status_pidr==3 || $model->status_pidr==4)){ 
      echo "<br>";
        echo Html::a(Yii::t('app', 'Завантажити Нову Смету П1'), ['uploadprojektfile', 'id_project' => $model->id, 'type_file'=>3, 'smeta_tupe'=>'pn'], ['class' => 'btn btn-primary']);
        echo Html::a(Yii::t('app', 'Дати відповідь підряднику'), ['pidrcoments/ansver', 'id_project' => $model->id, 'tupe_coment'=>0 ], ['class' => 'btn btn-primary']);
    }
    // удалить подрядчика если пишет ересь
	if(\Yii::$app->user->can('dir_dep_pkv') && $model->status_objekt==1 && $model->status_pidr==3 ){ 
      echo "<br>";
        echo Html::a(Yii::t('app', 'Відміна падрядника'), ['pidrcoments/killpidr', 'id_project' => $model->id, ], ['class' => 'btn btn-danger']);
        
    }
      //загрузить ведомость обема работ
    if(\Yii::$app->user->can('dir_dep_pkv') && \Yii::$app->user->can('uploadProjectFiles') && $model->status_objekt==2 ){
     //   echo Html::a(Yii::t('app', 'Завантажити Смету Д'), ['uploadprojektfile', 'id_project' => $model->id, 'type_file'=>3, 'smeta_tupe'=>'d'], ['class' => 'btn btn-primary']);
        echo Html::a(Yii::t('app', 'Завантажити Відомість обєму робіт П'), ['uploadprojektfile', 'id_project' => $model->id, 'type_file'=>4,], ['class' => 'btn btn-primary']);
    }
    //загрузить ведомость обема работ реальну

    if(\Yii::$app->user->can('uploadProjectFiles_Report_obl') && $model->status_objekt==3 ){
        echo Html::a(Yii::t('app', 'Завантажити Відомість обєму робіт реальну'), ['uploadprojektfile', 'id_project' => $model->id, 'type_file'=>4, 'smeta_tupe'=>'d'], ['class' => 'btn btn-primary']);
    }
    // загрузить договырні смета і проект
    if(\Yii::$app->user->can('uploadProjectFiles') && $model->status_objekt==4 ){
        echo Html::a(Yii::t('app', 'Завантажити Остаточну версію Проекту'), ['uploadprojektfile', 'id_project' => $model->id, 'type_file'=>2 ,'smeta_tupe'=>'end'], ['class' => 'btn btn-primary']);
        echo Html::a(Yii::t('app', 'Завантажити остаточну версію Смети'), ['uploadprojektfile', 'id_project' => $model->id, 'type_file'=>3, 'smeta_tupe'=>'end'], ['class' => 'btn btn-primary']);
        echo Html::a(Yii::t('app', 'Задати остаточну ціну П '), ['addobjectprice', 'id' => $model->id, 'tupe'=>0], ['class' => 'btn btn-primary']);
    }

    //пооглження підрядчика сметиостаточної
      if(\Yii::$app->user->can('setPidradnikStatus') && $model->status_objekt==5){ 
      echo "<br>";
        echo Html::a(Yii::t('app', 'Погоджую ПКД'), ['pidrcoments/agree', 'id_project' => $model->id, 'tupe_coment'=>1 ], ['class' => 'btn btn-success']);
        echo Html::a(Yii::t('app', 'Є правки стосовно ПКД'), ['pidrcoments/coment', 'id_project' => $model->id, 'tupe_coment'=>1 ], ['class' => 'btn btn-primary']);
    }
    //відповідь підрядчику по остаточній сметі
    // ответ на согласование подрядчка
    if(\Yii::$app->user->can('setPidradnikAnsver') && $model->status_objekt==5 && ($model->status_pidr==3 || $model->status_pidr==4)){ 
      echo "<br>";
        echo Html::a(Yii::t('app', 'Завантажити Нову остаточну смету П'), ['uploadprojektfile', 'id_project' => $model->id, 'type_file'=>3, 'smeta_tupe'=>'end'], ['class' => 'btn btn-primary']);
        echo Html::a(Yii::t('app', 'Дати відповідь підряднику'), ['pidrcoments/ansver', 'id_project' => $model->id, 'tupe_coment'=>1 ], ['class' => 'btn btn-primary']);
    }
    // загрузить смету Д
    if((\Yii::$app->user->can('dir_dep_pkv') && \Yii::$app->user->can('uploadProjectFiles') && $model->status_objekt==6) || (\Yii::$app->user->can('dir_dep_pkv') && \Yii::$app->user->can('uploadProjectFiles') && $model->status_objekt==7 && $model->d_appryv_dkc==-1)){
        echo Html::a(Yii::t('app', 'Завантажити Смету Д'), ['uploadprojektfile', 'id_project' => $model->id, 'type_file'=>3, 'smeta_tupe'=>'d'], ['class' => 'btn btn-primary']);
         echo Html::a(Yii::t('app', 'Задати остаточну ціну Д '), ['addobjectprice', 'id' => $model->id, 'tupe'=>1], ['class' => 'btn btn-primary']);
    }
    // согласование директора колцентра сметы Д

    if(\Yii::$app->user->can('Oblenergo') && $model->status_objekt==7){
         echo Html::a(Yii::t('app', 'Погоджую смету'), ['pidrcoments/agree', 'id_project' => $model->id, 'tupe_coment'=>2 ], ['class' => 'btn btn-success']);
        echo Html::a(Yii::t('app', 'Є правки стосовно смети'), ['pidrcoments/coment', 'id_project' => $model->id, 'tupe_coment'=>2 ], ['class' => 'btn btn-primary']);
    }

    // відповідь на коментарі директору колчентру
    if((\Yii::$app->user->can('dir_dep_pkv') && \Yii::$app->user->can('uploadProjectFiles') && $model->status_objekt==7 && $model->d_appryv_dkc==-1)){
      echo Html::a(Yii::t('app', 'Дати відповідь директору СЦ'), ['pidrcoments/ansver', 'id_project' => $model->id, 'tupe_coment'=>2 ], ['class' => 'btn btn-primary']);
    }


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
          echo  ($value['p_type']=='end' ? 'Остаточна версія ' :' ');
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
            echo 'смета '. ($value['s_type']=='end' ? 'Остаточна версія П2 ' : ($value['s_type']=='pn' ? 'p скоригована' : $value['s_type'] ) ).'   ';
            echo date('d.m.Y',Files::findOne($value['id'])->data_create).' <a href="'.Url::to(['files/viewfile', 'id' => $value['id']]).'"  target="_blank">'.$value['name'].'</a><br>';
          }
        }
      }else{
        echo "<p>Файли ще не завантажено";
      }
      echo '<hr>';
    }

    if(\Yii::$app->user->can('viewFiles_Smeta_D') ){

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

