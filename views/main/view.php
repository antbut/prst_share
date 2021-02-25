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
use app\models\ObjektStatus;
use kartik\export\ExportMenu;
use yii\widgets\Pjax;


/* @var $this yii\web\View */
/* @var $model app\models\Main */

$this->title = $model->title;
//$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Mains'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>

<div class="main-view" style=" margin-right: 50px;">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php
        if(\Yii::$app->user->can('admin') ){ ?>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['Видалити', 'id' => $model->id], [
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

<?php Pjax::begin(); ?>

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
            ['label'=>'Статус обєкта ',
              'value'=> function($data){
                return  ObjektStatus::findOne($data->status_objekt)->title;   
                 }
              ],
            ['label'=>'Погоджено По  ',
              'value'=> function($data){
                if($data->tupe_prodj_work==1){
                  return 'Д1';
                } 
                if($data->tupe_prodj_work==2){
                  return 'Д2';
                } 
                return ' ';

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
            
              
              ['label'=>'Встановлений коефіціент Менеджером',
                'value'=> function($data){
                    return  KoeficOrder::findOne($data->id_koef)->value;   
                 }
              ],

              ['label'=>'Коефіціент k1 ',
                'value'=> function($data){
                  if($data->price_pidr!=0){
                    return number_format ($data->price_dogovor_end/$data->price_pidr, 3 );   
                  }else{
                    return 0;
                  }
                 }
              ],

              ['label'=>'Коефіціент фінальний ',
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

        echo '<p  class="btn btn-primary ent_texta" data-idproject="'.$model->id.'" data_type_file= 4" > Задати ціну П1 і підрядника </p>';
        echo '<p  class="btn btn-primary ent_texta_price" data-id="'.$model->id.'" data-type= 1 > Задати ціну Д </p>';

        echo Html::a(Yii::t('app', 'Завантажити Проект'), ['uploadprojektfile', 'id_project' => $model->id, 'type_file'=>2], ['class' => 'btn btn-primary']);
        echo Html::a(Yii::t('app', 'Завантажити Смету П1'), ['uploadprojektfile', 'id_project' => $model->id, 'type_file'=>3], ['class' => 'btn btn-primary']);

        echo Html::a(Yii::t('app', 'Завантажити Смету Д'), ['uploadprojektfile', 'id_project' => $model->id, 'type_file'=>3, 'smeta_tupe'=>'d'], ['class' => 'btn btn-primary']);
     //   echo Html::a(Yii::t('app', 'Задати ціну П1 і підрядника'), ['addpidrinfo', 'id' => $model->id, ], ['class' => 'btn btn-primary']);
        echo Html::a(Yii::t('app', 'Завантажити Відомість обєму робіт П'), ['uploadprojektfile', 'id_project' => $model->id, 'type_file'=>4,], ['class' => 'btn btn-primary']);

      //  echo Html::a(Yii::t('app', 'Задати ціну Д '), ['addobjectprice', 'id' => $model->id, 'tupe'=>1], ['class' => 'btn btn-primary']);
          //модальні кнопки
        
    }
    // согласование подрядчика роботи
    if(\Yii::$app->user->can('setPidradnikStatus') && $model->status_objekt==1 && $model->status_pidr!=1){ 
      echo "<br>";

      if($model->pidr!=0){
        echo Html::a(Yii::t('app', 'Не приймаю роботу'), ['pidrcoments/noagree', 'id_project' => $model->id, 'tupe_coment'=>0], ['class' => 'btn btn-danger']);
      }
        echo Html::a(Yii::t('app', 'Приймаю роботу'), ['pidrcoments/agree', 'id_project' => $model->id, 'tupe_coment'=>0], ['class' => 'btn btn-success']);
    }


    // согласование Директора сервисного центра 
    // поправить статус когда будет вид
    if(\Yii::$app->user->can('Oblenergo') && $model->status_objekt==4 ){ 
      echo "<br>";
         echo Html::a(Yii::t('app', 'Погоджую смету Д'), ['pidrcoments/agree', 'id_project' => $model->id, 'tupe_coment'=>2 ], ['class' => 'btn btn-success']);
       // echo Html::a(Yii::t('app', 'Є правки стосовно смети'), ['pidrcoments/coment', 'id_project' => $model->id, 'tupe_coment'=>2 ], ['class' => 'btn btn-primary']);    


        echo '<p  class="btn btn-primary ent_texta_coment" data-id="'.$model->id.'" data-type= 2 > Є правки стосовно смети</p>';
    }

    //загрузить ведомость обема работ реальну

    if(\Yii::$app->user->can('uploadProjectFiles_Report_obl') && $model->status_objekt==2 && \Yii::$app->user->can('contractor') ){
        echo Html::a(Yii::t('app', 'Завантажити Відомість обєму робіт реальну'), ['uploadprojektfile', 'id_project' => $model->id, 'type_file'=>4, 'smeta_tupe'=>'d'], ['class' => 'btn btn-primary']);
    }
    // вибрать Д1 или Д2
    if(\Yii::$app->user->can('dir_dep_pkv') && $model->status_objekt==3  ){
        echo Html::a(Yii::t('app', 'Д1'), ['settupeprodj', 'id_project' => $model->id, 'tupe'=>'1'], ['class' => 'btn btn-primary']);
        echo Html::a(Yii::t('app', 'Д2'), ['settupeprodj', 'id_project' => $model->id, 'tupe'=>'2'], ['class' => 'btn btn-primary']);

       
    }

    // Завантажити остаточну версію Смети П2
    if(\Yii::$app->user->can('uploadProjectFiles') && $model->status_objekt==5 ){
      
      echo Html::a(Yii::t('app', 'Завантажити остаточну версію Смети П2'), ['uploadprojektfile', 'id_project' => $model->id, 'type_file'=>3, 'smeta_tupe'=>'end'], ['class' => 'btn btn-primary']);

     // echo Html::a(Yii::t('app', 'Задати остаточну ціну П '), ['addobjectprice', 'id' => $model->id, 'tupe'=>0], ['class' => 'btn btn-primary']);

      echo '<p  class="btn btn-primary ent_texta_price" data-id="'.$model->id.'" data-type= 0 > Задати остаточну ціну П2</p>';
    }

    if(\Yii::$app->user->can('uploadProjectFiles') && $model->status_objekt==4 && $model->tupe_prodj_work==1){
         echo Html::a(Yii::t('app', 'Завантажити Смету Д'), ['uploadprojektfile', 'id_project' => $model->id, 'type_file'=>3, 'smeta_tupe'=>'d'], ['class' => 'btn btn-primary']);
    }
    // Завантажити остаточну версію Смети Д по Д2
    if(\Yii::$app->user->can('uploadProjectFiles') && $model->status_objekt==4 && $model->tupe_prodj_work==2){
        echo Html::a(Yii::t('app', 'Завантажити Проект'), ['uploadprojektfile', 'id_project' => $model->id, 'type_file'=>2], ['class' => 'btn btn-primary']);
        echo Html::a(Yii::t('app', 'Завантажити остаточну версію Смети П2'), ['uploadprojektfile', 'id_project' => $model->id, 'type_file'=>3, 'smeta_tupe'=>'end'], ['class' => 'btn btn-primary']);

    }
    // ответ на согласование подрядчка
    if(\Yii::$app->user->can('setPidradnikAnsver') && $model->status_objekt==1 && ($model->status_pidr==5 || $model->status_pidr==4)){ 
      echo "<br>";
        echo Html::a(Yii::t('app', 'Завантажити Нову Смету П1'), ['uploadprojektfile', 'id_project' => $model->id, 'type_file'=>3, 'smeta_tupe'=>'pn'], ['class' => 'btn btn-primary']);
        echo Html::a(Yii::t('app', 'Дати відповідь підряднику'), ['pidrcoments/ansver', 'id_project' => $model->id, 'tupe_coment'=>0 ], ['class' => 'btn btn-primary']);
    }


    // удалить подрядчика если пишет ересь
	  if(\Yii::$app->user->can('dir_dep_pkv') && $model->status_objekt==1 && $model->status_pidr==3 ){ 
      echo "<br>";
        echo Html::a(Yii::t('app', 'Відміна підрядника'), ['pidrcoments/killpidr', 'id_project' => $model->id, ], ['class' => 'btn btn-danger']);
    }

    //поглження підрядчика смети остаточної П2
      if(\Yii::$app->user->can('setPidradnikStatus') && $model->status_objekt==4){ 
      echo "<br>";
        echo Html::a(Yii::t('app', 'Погоджую ПКД'), ['pidrcoments/agree', 'id_project' => $model->id, 'tupe_coment'=>1 ], ['class' => 'btn btn-success']);
      //  echo Html::a(Yii::t('app', 'Є правки стосовно ПКД'), ['pidrcoments/coment', 'id_project' => $model->id, 'tupe_coment'=>1 ], ['class' => 'btn btn-primary']);

        echo '<p  class="btn btn-primary ent_texta_coment" data-id="'.$model->id.'" data-type= 1 > Є правки стосовно ПКД</p>';

    }
    
    //відповідь підрядчику по остаточній сметі
    // ответ на согласование подрядчка
    if(\Yii::$app->user->can('setPidradnikAnsver') && $model->status_objekt==4 && ($model->status_pidr==3 || $model->status_pidr==4)){ 
      echo "<br>";
        echo Html::a(Yii::t('app', 'Завантажити Нову остаточну смету П'), ['uploadprojektfile', 'id_project' => $model->id, 'type_file'=>3, 'smeta_tupe'=>'end'], ['class' => 'btn btn-primary']);
       // echo Html::a(Yii::t('app', 'Дати відповідь підряднику'), ['pidrcoments/ansver', 'id_project' => $model->id, 'tupe_coment'=>1 ], ['class' => 'btn btn-primary']);

        echo '<p  class="btn btn-primary ent_texta_coment_ansver" data-id="'.$model->id.'" data-type= 1 > Дати відповідь підряднику </p>';
    //    echo Html::a(Yii::t('app', 'Задати остаточну ціну П '), ['addobjectprice', 'id' => $model->id, 'tupe'=>0], ['class' => 'btn btn-primary']);
        echo '<p  class="btn btn-primary ent_texta_price" data-id="'.$model->id.'" data-type= 0 > Задати остаточну ціну П</p>';
    }

    

    // відповідь на коментарі директору сервіс центру
    if((\Yii::$app->user->can('dir_dep_pkv') && \Yii::$app->user->can('uploadProjectFiles') && $model->status_objekt==4 && $model->d_appryv_dkc==-1 && $model->status_dir_sc==2)){
      //echo Html::a(Yii::t('app', 'Дати відповідь директору СЦ'), ['pidrcoments/ansver', 'id_project' => $model->id, 'tupe_coment'=>2 ], ['class' => 'btn btn-primary']);
      echo Html::a(Yii::t('app', 'Завантажити нову Смету Д'), ['uploadprojektfile', 'id_project' => $model->id, 'type_file'=>3, 'smeta_tupe'=>'d'], ['class' => 'btn btn-primary']);
     // echo Html::a(Yii::t('app', 'Задати остаточну ціну Д '), ['addobjectprice', 'id' => $model->id, 'tupe'=>1], ['class' => 'btn btn-primary']);

      echo '<p  class="btn btn-primary ent_texta_price" data-id="'.$model->id.'" data-type= 1 > Задати остаточну ціну Д</p>';

       echo '<p  class="btn btn-primary ent_texta_coment_ansver" data-id="'.$model->id.'" data-type= 2 > Дати відповідь директору СЦ</p>';
    }


    // Загрузить КБ3
    if(\Yii::$app->user->can('Oblenergo') && $model->status_objekt==7 ){ 
      echo "<br>";
        echo Html::a(Yii::t('app', 'Завантажити Скан КБ3'), ['uploadprojektfile', 'id_project' => $model->id, 'type_file'=>5, 'smeta_tupe'=>'d'], ['class' => 'btn btn-primary']);
        
    }


// догрузить данні яких не хватає після обновления

    if(\Yii::$app->user->can('dir_dep_pkv') && $model->status_objekt>2 ){
      echo "<br>";
        if($model->file_resoyrs_report==null){
          echo Html::a(Yii::t('app', 'Завантажити Відомість обєму робіт П'), ['uploadprojektfile', 'id_project' => $model->id, 'type_file'=>4,], ['class' => 'btn btn-primary']);
        }
        if($model->price_dogovor_end==0){
          echo '<p  class="btn btn-primary ent_texta_price" data-id="'.$model->id.'" data-type= 1 > Задати ціну Д </p>';
        }
        
    } 


    ?>
    <br><br>
    
      <div  >
      <div class="row" style="border: 2px dashed black; margin-right: 10px; margin-bottom: 50px; ">
        <h3 align="center">Файли По обєкту</h3>
        <?php 
         if(\Yii::$app->user->can('viewFiles_project') ){ ?>
            <div class="col-lg-3" style="border-right: 2px dashed black; border-top: 2px dashed black;margin-bottom: 20px">
              <h4 align="center"><p> файли проекту <p></h4>

                <?php
                    if($model->files_pojekt!= null){
                      foreach (json_decode ($model->files_pojekt,true) as  $value) {
                        echo  ($value['p_type']=='end' ? 'Остаточна версія ' :' ');
                        echo date('d.m.Y',Files::findOne($value['id'])->data_create).' <a href="'.Url::to(['files/viewfile', 'id' => $value['id']]).'"  target="_blank">'.$value['name'].'</a><br>';
                      }
                    }else{
                      echo "<p>Файли ще не завантажено";
                    }
                ?>

            </div>
        <?php }
          if(\Yii::$app->user->can('viewFiles_Smeta') ){ ?>
            <div class="col-lg-3" style="border-right: 2px dashed black; border-left: 2px dashed black; border-top: 2px dashed black; margin-bottom: 20px">
              <h4 align="center"><p> файли смети <p></h4>

                <?php
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

                ?>

            </div>
          <?php  } 
          if(\Yii::$app->user->can('viewFiles_Resoyrce_report') ){?>
            <div class="col-lg-3" style="border-top: 2px dashed black; border-left:  2px dashed black; margin-bottom: 20px">
              <h4 align="center"><p> файли Відомість ресурсів <p></h4>
                <?php
                    if($model->file_resoyrs_report!= null){
                      foreach (json_decode ($model->file_resoyrs_report,true) as  $value) {
                        //echo '<p>'. $value['name'];
                        echo 'Відомість '. $value['r_type'].'   ';
                        echo date('d.m.Y',Files::findOne($value['id'])->data_create).' <a href="'.Url::to(['files/viewfile', 'id' => $value['id']]).'"  target="_blank">'.$value['name'].'</a><br>';
                      }
                    }else{
                      echo "<p>Файли ще не завантажено";
                    }
                ?>
            </div>
          <?php } 
          if(\Yii::$app->user->can('viewFiles_Resoyrce_report') ){?>
            <div class="col-lg-3" style="border-top: 2px dashed black; border-left:  2px dashed black; margin-bottom: 20px">
              <h4 align="center"><p> файли KB3 <p></h4>
                <?php
                    if($model->files_kb!= null){
                      foreach (json_decode ($model->files_kb,true) as  $value) {
                        //echo '<p>'. $value['name'];
                        echo 'Відомість '. $value['r_type'].'   ';
                        echo date('d.m.Y',Files::findOne($value['id'])->data_create).' <a href="'.Url::to(['files/viewfile', 'id' => $value['id']]).'"  target="_blank">'.$value['name'].'</a><br>';
                      }
                    }else{
                      echo "<p>Файли ще не завантажено";
                    }
                ?>
            </div>
          <?php } ?>

      </div>
     
    </div>

    

    </div>
<hr><br><br>
   
<div class="main-view" style=" margin-right: 50px;">
    <?php

    //  viewHistorySmetaD
  if(\Yii::$app->user->can('viewHistorySmetaD') ){
      echo "<h4>Історія взаємодії з Директором Сервісного центру по сметі</h4><br>";
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
   
    if(\Yii::$app->user->can('viewHistoryPidryadnik') ){
      echo "<br><h4>Історія взаємодії з підрядником погодження виконання робіт</h4><br>";
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
      echo "<h4>Історія взаємодії з підрядником по ПКД</h4><br>";

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
		
	}	
	

?>
</div>
<?php Pjax::end(); ?>




<div class="modal modal-info " id="modal-info" style="display: none; padding-right: 17px;">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span></button>
                <h4 class="modal-title">Info Modal</h4>
              </div>
              <div class="modal-body">
                <p>Напевне у вас нема прав на використання вказаної дії</p>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-outline " data-dismiss="modal">Close</button>

              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>





        <div class="modal modal-info " id="modal-img" style="display: none; padding-right: 17px; ">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span></button>
                <h4 class="modal-title">Info Modal</h4>
              </div>
              <div class="modal-body" >
                <p>Напевне у вас нема прав на використання вказаної дії</p>
              
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-outline " data-dismiss="modal">Close</button>

              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>


<?php //Вызов окна
    $this->registerJs("
    $('.ent_texta').on('click', function(){
    var data = $(this).data();
    $('#modal-img').modal('show');
    $('#modal-img').find('.modal-title').text('Введення');
    $('#modal-img').find('.modal-body').load('/web/main/addpidrinfo?id='+ data.idproject);
    })
    ");
?>

<?php //Вызов окна
    $this->registerJs("
    $('.ent_texta_price').on('click', function(){
    var data = $(this).data();
    $('#modal-img').modal('show');
    $('#modal-img').find('.modal-title').text('Введення');
    $('#modal-img').find('.modal-body').load('/web/main/addobjectprice?id='+ data.id +'&tupe='+ data.type);
    })
    ");
?>

<?php //Вызов окна
    $this->registerJs("
    $('.ent_texta_coment').on('click', function(){
    var data = $(this).data();
    $('#modal-img').modal('show');
    $('#modal-img').find('.modal-title').text('Введення');
    $('#modal-img').find('.modal-body').load('/web/pidrcoments/coment?id_project='+ data.id +'&tupe_coment='+ data.type);
    })
    ");
?>
<?php //Вызов окна
    $this->registerJs("
    $('.ent_texta_coment_ansver').on('click', function(){
    var data = $(this).data();
    $('#modal-img').modal('show');
    $('#modal-img').find('.modal-title').text('Введення');
    $('#modal-img').find('.modal-body').load('/web/pidrcoments/ansver?id_project='+ data.id +'&tupe_coment='+ data.type);
    })
    ");
?>
