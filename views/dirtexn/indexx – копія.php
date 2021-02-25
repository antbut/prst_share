<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\data\Pagination;

use yii\widgets\LinkPager;
/* @var $this yii\web\View */
/* @var $searchModel app\models\DirtexnSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Роботи технічна дирекція';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dir-texn-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Додати роботу', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?/*= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'title:ntext',
            'n_ofer',
            'd_ofer',

            ['label'=>'Дата договору',
                'value'=> function($data){
                return date('d.m.Y', $data->d_ofer);   
                 }
            ],
            'pidr:ntext',
            'deskription:ntext',
            'd_opl_avans',

            ['label'=>'Дата Авансу',
                'value'=> function($data){
                return date('d.m.Y', $data->d_opl_avans);   
                 }
            ],
            'd_start_work',

            ['label'=>'Дата початку робіт',
                'value'=> function($data){
                return date('d.m.Y', $data->d_start_work);   
                 }
            ],
            'd_enter_control_p',
            'd_enter_controll',
            'enter_controll:ntext',
            'd_shadow_work_p',
            'd_shadow_work',
            'shadow_work:ntext',
            'd_end_interim_work_p',
            'd_end_interim_work',
            'end_interim_work:ntext',
            'd_end_work_p',
            'd_end_work',
            'end_work:ntext',
            'd_assept_work_p',
            'd_assept_work',
            'assept_work:ntext',
            //'data_create',
            //'id_creator',
            'statys',
            //'id_type',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]);*/ ?>

    <table  class="table table-striped table-bordered">
        <tr><th rowspan="2">№ з/п</th><th rowspan="2">Найменування робіт по договору</th><th rowspan="2">Підрядник</th><th colspan="2">Договір</th><th rowspan="2">Короткий опис робіт</th><th rowspan="2">Дата оплати аванса</th><th rowspan="2">Початок робіт планова дата</th><th rowspan="2" >Початок робіт (дата)</th><th rowspan="2">Вхідний контроль планова дата</th><th rowspan="2" colspan="2">Вхідний контроль (дата) (фото паспортів, сертифікатів)</th><th rowspan="2">Приховані роботи  планова дата</th><th rowspan="2" colspan="2">Приховані роботи  (дата) (скан. актів, фото виконаних робіт)</th><th rowspan="2">Закінчення проміжних етапів планова дата</th><th rowspan="2" colspan="2">Закінчення проміжних етапів (дата) (скан. актів, фото виконаних робіт)</th><th rowspan="2">Закінчення робіт планова дата</th><th rowspan="2" colspan="2">Закінчення робіт (дата)  (фото виконаних робіт)</th><th rowspan="2">Приймання виконаних робіт робіт планова дата</th><th rowspan="2" colspan="2">Приймання виконаних робіт робіт (дата) (акт приймальної комісії)</th></tr>
       

        <tr><th>№</th><th>Дата</th></tr>
        <tr align="center"><th>1</th><th>2</th><th>3</th><th>4</th><th>5</th><th>6</th><th>7</th><th>8</th><th>9</th><th>10</th><th colspan="2">11</th><th>12</th><th colspan="2">13</th><th>14</th><th colspan="2">15</th><th>16</th><th colspan="2">17</th><th>18</th><th colspan="2">19</th></tr>
        
        <?php
            foreach ($types as $keyt => $typ) {
                echo '<tr bgcolor="#98FB98"><th bgcolor="#98FB98" colspan="24">'.$typ->title.'</th></tr>';
            
                $i=0;
                foreach ($model as $key => $mod) {
                    if($mod->id_type==$typ->id){ 
                        echo '<tr>
                                <td>'.++$i.'</td>
                                <td>'.$mod->title.'</td>
                                <td>'.$mod->pidr.'</td>
                                <td>'.$mod->n_ofer.'</td>
                                <td>'.($mod->d_ofer!=0 ? date('d.m.Y', $mod->d_ofer) : 'Не вказано').'</td>
                                <td>'.$mod->deskription.'</td>
                                <td>'.date('d.m.Y', $mod->d_opl_avans).'</td>
                                <td>'.($mod->d_opl_avans!=0 ? date('d.m.Y', $mod->d_opl_avans) : 'Невказано').'</td>
                                <td>'.($mod->d_start_work!=0 ? date('d.m.Y', $mod->d_start_work) : 'Невказано').'</td>
                                <td >'.($mod->d_enter_control_p!=0 ? date('d.m.Y', $mod->d_enter_control_p) : 'Невказано').'</td>

                                <td class="ent_k_d"'.($mod->d_enter_control_p<=$mod->d_enter_controll ? 'bgcolor="#DC143C"':' ').' data-key="'. $mod->id.'" data-type="d_enter_control">'.($mod->d_enter_controll!=0 ? date('d.m.Y', $mod->d_enter_controll) : 'Невказано').'</td>
                                <td class="'.($mod->enter_controll!=null ? 'view_k_d' : 'none').'" data-key="'. $mod->id.'" data-type="d_enter_control">'.($mod->enter_controll!=null ? '<a href="#modal-info"><img src="/web/images/document.png" height="25px></a>"': '').'</td>

                                <td>'.($mod->d_shadow_work_p!=0 ? date('d.m.Y', $mod->d_shadow_work_p) : 'Невказано').'</td>

                                <td class="ent_k_d" '.($mod->d_shadow_work_p<=$mod->d_shadow_work ? 'bgcolor="#DC143C"':' ').'data-key="'. $mod->id.'" data-type="d_shadow_work">'.($mod->d_shadow_work!=0 ? date('d.m.Y', $mod->d_shadow_work) : 'Невказано').'</td>

                                <td class="'.($mod->shadow_work!=null ? 'view_k_d' : 'none').'" data-key="'. $mod->id.'" data-type="d_shadow_work">'.($mod->shadow_work!=null ? '<img src="/web/images/document.png" height="25px"': '').'</td>

                                <td>'.($mod->d_end_interim_work_p!=0 ? date('d.m.Y', $mod->d_end_interim_work_p) : 'Невказано').'</td>

                                <td class="ent_k_d" '.($mod->d_end_interim_work_p<=$mod->d_end_interim_work ? 'bgcolor="#DC143C"':' ').'data-key="'. $mod->id.'" data-type="d_end_interim_work">'.($mod->d_end_interim_work!=0 ? date('d.m.Y', $mod->d_end_interim_work) : 'Невказано').'</td>

                                <td class="'.($mod->end_interim_work!=null ? 'view_k_d' : 'none').'" data-key="'. $mod->id.'" data-type="d_end_interim_work">'.($mod->end_interim_work!=null ? '<img src="/web/images/document.png" height="25px"': '').'</td>

                                <td>'.($mod->d_end_work_p!=0 ? date('d.m.Y', $mod->d_end_work_p) : 'Невказано').'</td>

                                <td class="ent_k_d"  '.($mod->d_end_work_p<=$mod->d_end_work ? 'bgcolor="#DC143C"':' ').'data-key="'. $mod->id.'" data-type="d_end_work">'.($mod->d_end_work!=0 ? date('d.m.Y', $mod->d_end_work) : 'Невказано').'</td>

                                <td class="'.($mod->end_work!=null ? 'view_k_d' : 'none').'" data-key="'. $mod->id.'" data-type="d_end_work">'.($mod->end_work!=null ? '<img src="/web/images/document.png" height="25px"': '').'</td>

                                <td>'.($mod->d_assept_work_p!=0 ? date('d.m.Y', $mod->d_assept_work_p) : 'Невказано').'</td>
                                
                                <td class="ent_k_d" '.($mod->d_assept_work_p<=$mod->d_assept_work ? 'bgcolor="#DC143C"':' ').'data-key="'. $mod->id.'" data-type="d_assept_work">'.($mod->d_assept_work!=0 ? date('d.m.Y', $mod->d_assept_work) : 'Невказано').'</td>
                                <td class="'.($mod->assept_work!=null ? 'view_k_d' : 'none').'" data-key="'. $mod->id.'" data-type="d_assept_work">'.($mod->assept_work!=null ? '<img src="/web/images/document.png" height="25px"': '').'</td>

                                
                            </tr>';
                    }
                      
               }
            }
        ?>

    </table>

    <?php Pjax::end(); ?>

</div>
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





        <div class="modal modal-info " id="modal-img" style="display: none; padding-right: 17px;">
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

<?php $this->registerJs("
$('.ent_k_d').on('click', function(){
    var data = $(this).data();
    $('#modal-info').modal('show');
    $('#modal-info').find('.modal-title').text('Load files');
    $('#modal-info').find('.modal-body').load('/web/dirtexn/updatedate?id='+ data.key+'&type='+ data.type);
    })
    ");
?>

<?php $this->registerJs("
$('.view_k_d').on('click', function(){
    var data = $(this).data();
    $('#modal-info').modal('show');
    $('#modal-info').find('.modal-title').text('Info load files');
    $('#modal-info').find('.modal-body').load('/web/dirtexn/viewfiles?id='+ data.key+'&type='+ data.type);
    })
    ");
?>


<?php $this->registerJs("
$('.view_img').on('click', function(){
    var data = $(this).data();
    $('#modal-img').modal('show');
    $('#modal-img').find('.modal-title').text('load files');
    $('#modal-img').find('.modal-body').load('/web/download/viewfile?id='+ data.key);
    })
    ");
?>

<?php
echo LinkPager::widget(['pagination' => $pages,]);
?>

<script>
    $(function () {

      // функция с параметрами idModal1 (1 модальное окно) и idModal2 (2 модальное окно)
      var twoModal = function (idModal1, idModal2) {
        var showModal2 = false;
        // при нажатии на ссылку в idModal2 устанавливаем переменной showModal2 значение равное true и закрываем idModal1
        $('.' + idModal2).click(function (e) {
          e.preventDefault();
          showModal2 = true;
          $('#'+idModal1).modal('hide');
        });
        // после закрытия idModal1, если значение showModal2 равно true, то открываем idModal2
        $('#'+idModal1).on('hidden.bs.modal', function (e) {
          if (showModal2) {
            showModal2 = false;
            $('#'+idModal2).modal('show');
          }
        });
        // при закрытии idModal2 открываем idModal1
        $('#'+idModal2).on('hidden.bs.modal', function (e) {
          $('#'+idModal1).modal('show');
        });
      };

      twoModal('view_k_d', 'modal-img');
     
    });
  </script>
