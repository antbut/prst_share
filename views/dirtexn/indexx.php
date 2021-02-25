<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\data\Pagination;

use yii\widgets\LinkPager;
/* @var $this yii\web\View */
/* @var $searchModel app\models\DirtexnSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Роботи';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dir-texn-index">

    <h1><?//= Html::encode($this->title) ?></h1>

    <p><?php
        if(\Yii::$app->user->can('dirtexnCreate') || \Yii::$app->user->can('dirkapbudCreate') || \Yii::$app->user->can('DirZabDiyalnCreate') || \Yii::$app->user->can('DirServCenterCreate')   || \Yii::$app->user->can('DirITCreate'))
            echo  Html::a('Додати роботу', ['create'], ['class' => 'btn btn-success']); ?>
    </p>

    
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
<?php
    $expared_day=mktime(0, 0, 0, date("m"), date("d")-2, date("Y"));
    $sekond_days=86400;
	if(\Yii::$app->user->can('moderator')){
		foreach($organizations as $organization){
    		if($organization->id!=1){
                if($organization->id!=$id_obl){
    		      echo Html::a($organization->title,  ['index', 'id_obl'=>$organization->id, 'id_type'=>$id_type], ['class' => 'btn btn-primary']);
                }else{
                    echo Html::a($organization->title,  ['index', 'id_obl'=>$organization->id, 'id_type'=>$id_type], ['class' => 'btn btn-primary active']);
                }
    		}
		}
        
	}

    if(\Yii::$app->user->can('moderator') || \Yii::$app->user->can('sypervisor') || \Yii::$app->user->can('DirTexn') || \Yii::$app->user->can('DirKapBud')){
        echo "<br>";
        foreach($types as $type){
            if($type->display!=0){
                if($type->id!=$id_type){
                    echo Html::a($type->title,  ['index', 'id_obl'=>$id_obl, 'id_type'=>$type->id], ['class' => 'btn btn-info']);
                }else{
                    echo Html::a($type->title,  ['index', 'id_obl'=>$id_obl, 'id_type'=>$type->id], ['class' => 'btn btn-info active']);
                }
            }
        }
    }
?>
    
<?php Pjax::begin(); ?>
   <!--- <table  class="table table-striped table-bordered">  --->

	
        <table  class="table  table-bordered" id="myTable">

	<colgroup>
		<col style="width: 36px;">
		<col style="width: 86px;">
		<col style="min-width: 350px;">
		<col style="min-width: 150px;">
		<col style="width: 100px;">
		<col style="width: 100px;">
		<col style="min-width: 350px;">
		<col style="width: 100px;">
		<col style="width: 100px;">
		<col style="width: 100px;">
		<col style="width: 100px;">
		<col style="width: 100px;">
		<col style="width: 100px;">
		<col style="width: 100px;">
		<col style="width: 100px;">
		<col style="width: 100px;">
		<col style="width: 100px;">
		<col style="width: 100px;">
		<col style="width: 100px;">
		<col style="width: 100px;">
		<col style="width: 100px;">
		<col style="width: 100px;">
		<col style="width: 100px;">
		<col style="width: 100px;">
		<col style="width: 100px;">
		<col style="width: 100px;">
	</colgroup>
         <thead>
        <tr><th scope="col" rowspan="2">№ з/п</th><th scope="col" rowspan="2">Дата</th><th scope="col" rowspan="2" width="300px">Найменування робіт по договору</th><th scope="col" rowspan="2" style="max-width: 100px">Підрядник (після торгів або редукціону)</th><th scope="col" colspan="2">Договір</th><th scope="col" rowspan="2" style="max-width: 100px">Короткий опис робіт</th><th scope="col" rowspan="2">Дата оплати аванса</th><th scope="col" rowspan="2" >Початок робіт (дата)</th><th scope="col" rowspan="2">Вхідний контроль планова дата</th><th scope="col" rowspan="2" colspan="2">Вхідний контроль (дата) (фото паспортів, сертифікатів)</th><th scope="col" rowspan="2">Приховані роботи  планова дата</th><th scope="col" rowspan="2" colspan="2">Приховані роботи  (дата) (скан. актів, фото виконаних робіт)</th><th rowspan="2">Закінчення проміжних етапів планова дата</th><th rowspan="2" colspan="2">Закінчення проміжних етапів (дата) (скан. актів, фото виконаних робіт)</th><th rowspan="2">Закінчення робіт планова дата</th><th rowspan="2" colspan="2">Закінчення робіт (дата)  (фото виконаних робіт)</th><th rowspan="2">Приймання виконаних робіт планова дата</th><th rowspan="2" colspan="2">Приймання виконаних робіт (дата) (акт приймальної комісії)</th></tr>
       

        <tr><th >№</th><th>Дата</th></tr>
         
        <tr style="text-align: center;"><th>1</th><th>2</th><th>3</th><th>4</th><th>5</th><th>6</th><th>7</th><th>8</th><th>9</th><th>10</th><th colspan="2">11</th><th>12</th><th colspan="2">13</th><th>14</th><th colspan="2">15</th><th>16</th><th colspan="2">17</th><th>18</th><th colspan="2">19</th></tr>
        </thead>
         <tbody>
        <?php
            foreach ($types as $keyt => $typ) {
                echo '<tr bgcolor="#98FB98"><td bgcolor="#98FB98" colspan="24"><b>'.$typ->title.'</b></td></tr>';

                $update_date_rull=false;
                switch ($typ->id) {
                            case 0:
                                if(\Yii::$app->user->can('nest_pr_mang'))
                                    $update_date_rull=true;
                                break;
                            case 1:
                                if(\Yii::$app->user->can('ip_mang'))
                                    $update_date_rull=true;
                              
                                break;
                            case 2:
                                if(\Yii::$app->user->can('rem_pidr_sp_manage'))
                                    $update_date_rull=true;
                                
                                break;
                            case 3:
                                if(\Yii::$app->user->can('rem_dzd_manage_date'))
                                    $update_date_rull=true;

                                break;
                            case 4:
                               
                                break;

                            case 5:
                                if(\Yii::$app->user->can('it_dir_manag'))
                                    $update_date_rull=true;

                                break;
                            
                           
                        }
            
                $i=0;
                foreach ($model as $key => $mod) {
                    if($mod->id_type==$typ->id){ 

                        // права на редактирования


                        //вытянуть масивы
                        $d_shadow_work_p=json_decode($mod->d_shadow_work_p,true);
                        $d_shadow_work=json_decode($mod->d_shadow_work,true);

                        $d_enter_controll=json_decode($mod->d_enter_controll,true);
                        $d_enter_control_p=json_decode($mod->d_enter_control_p,true);

                        $d_end_interim_work_p=json_decode($mod->d_end_interim_work_p,true);
                        $d_end_interim_work=json_decode($mod->d_end_interim_work,true);

                        $d_end_work=json_decode($mod->d_end_work,true);
                        $d_end_work_p=json_decode($mod->d_end_work_p,true);




                        $count_rows=[count($d_shadow_work_p),count($d_shadow_work), count($d_enter_controll), count($d_enter_control_p), count($d_end_interim_work_p), count($d_end_interim_work), count($d_end_work_p),];

                        max($count_rows) ==0 ? $kill_rows=1:$kill_rows=max($count_rows);
                        $j=0;
                        echo '<tr style=" background-color: '. ($i % 2 == 0 ? '#FFF' : '#b072211c').';">

                                <td'. ($mod->assept_work!=null ? ' bgcolor="#ccffcc" ':' '). ' rowspan="'.$kill_rows.'">'.++$i.'</td>

                                <td'. ($mod->assept_work!=null ? ' bgcolor="#ccffcc" ':' '). ' rowspan="'.$kill_rows.'">'.($mod->d_asept_dad!=0 ? date('d.m.Y', $mod->d_asept_dad) : 'Не вказано').'</td>
                                <td'. ($mod->assept_work!=null ? ' bgcolor="#ccffcc" ':' '). ' rowspan="'.$kill_rows.'">'.$mod->title.'</td>
                                <td rowspan="'.$kill_rows.'">'.$mod->pidr.'</td>

                                <td '. ($update_date_rull==true ? ' class="ent_texta" ' : ' ' ).'data-key="'. $mod->id.'" data-type="n_ofer" rowspan="'.$kill_rows.'">'.$mod->n_ofer.'</td>

                                <td'. ($update_date_rull==true ? ' class="ent_k_d_p" ' : ' ').' data-key="'. $mod->id.'" data-type="d_ofer" rowspan="'.$kill_rows.'">'.($mod->d_ofer!=0 ? date('d.m.Y', $mod->d_ofer) : ' ').'</td>

                                <td'. ($update_date_rull==true ? ' class="ent_texta" ': ' ').' data-key="'. $mod->id.'" data-type="deskription" rowspan="'.$kill_rows.'">'.$mod->deskription.'</td>
        
                                <td'. ($update_date_rull==true ? ' class="ent_k_d_p" ' : ' ').' data-key="'. $mod->id.'" data-type="d_opl_avans" rowspan="'.$kill_rows.'"> <a href="#date-add">'.($mod->d_opl_avans!=0 ? date('d.m.Y', $mod->d_opl_avans) : ' ').'</a></td>

                                <td '. ($update_date_rull==true ? ' class="ent_k_d_p" ' : ' ').' data-key="'. $mod->id.'" data-type="d_start_work" rowspan="'.$kill_rows.'"><a href="#date-add">'.($mod->d_start_work!=0 ? date('d.m.Y', $mod->d_start_work) : ' ').'</a></td>';

                                

                                if(isset($d_enter_control_p[$j]) ){
                                       echo '<td '. ($update_date_rull==true ? ' class="ent_k_d_p" ' : ' ') .' data-key="'. $mod->id.'" data-type="d_enter_control_p"> <a href="#date-add">'.($d_enter_control_p[$j]['date']!=0 ? date('d.m.Y', $d_enter_control_p[$j]['date']) : 'Невказано').'</a></td>';
                                }else{
                                    echo '<td '. ($update_date_rull==true ? ' class="ent_k_d_p" ' : ' ').' data-key="'. $mod->id.'" data-type="d_enter_control_p"> <a href="#date-add"> </a></td>';
                                }


                                if(isset($d_enter_controll[$j]) ){
                                      echo '<td '. ($update_date_rull==true ? ' class="ent_k_d" ' : ' ') .(($d_enter_control_p[$j]['date'])<=($d_enter_controll[$j]['date']-$sekond_days) ? 'bgcolor="#FFD700"':' ').'data-key="'. $mod->id.'" data-type="d_enter_control" data-idelem="'.$d_enter_control_p[$j]['id'].'">'.date('d.m.Y', $d_enter_controll[$j]['date']).'</td>';
                                }else{
                                    echo '<td'. ($update_date_rull==true ? ' class="ent_k_d" ' : ' ') .(isset($d_enter_control_p[$j]) ? ($d_enter_control_p[$j]['date']<$expared_day ? 'bgcolor="#B22222"':'' ) : ' ').'data-key="'. $mod->id.'" data-type="d_enter_control" data-idelem="'.$d_enter_control_p[$j]['id'].'"> </td>';
                                }

                               /* echo '<td rowspan="'.$kill_rows.'" class="ent_k_d"'.($mod->d_enter_controll==0 ? ($mod->d_enter_control_p<=mktime(0, 0, 0, date("m", time()), date("d", time())+1, date("Y", time())) ? 'bgcolor="#B22222"':'' ): ($mod->d_enter_control_p<=$mod->d_enter_controll ? 'bgcolor="#FFD700"':' ')).' data-key="'. $mod->id.'" data-type="d_enter_control">'.($mod->d_enter_controll!=0 ? date('d.m.Y', $mod->d_enter_controll) : 'Невказано').'</td>
                                */
                                echo '<td rowspan="'.$kill_rows.'" class="'.($mod->enter_controll!=null ? 'view_k_d' : 'none').'" data-key="'. $mod->id.'" data-type="d_enter_control">'.($mod->enter_controll!=null ? '<a href="#modal-info"><img src="/web/images/document.png" height="25px></a>"': '').'</td>';
//------------Приховані роботи----------------------------------------------
                                if(isset($d_shadow_work_p[$j]) ){
                                       echo '<td'. ($update_date_rull==true ? ' class="ent_k_d_p" ' :' ').' data-key="'. $mod->id.'" data-type="d_shadow_work_p"> <a href="#date-add">'.($d_shadow_work_p[$j]['date']!=0 ? date('d.m.Y', $d_shadow_work_p[$j]['date']) : 'Невказано').'</a></td>';
                                }else{
                                    echo '<td '. ($update_date_rull==true ? ' class="ent_k_d_p" ' : ' ').' data-key="'. $mod->id.'" data-type="d_shadow_work_p"></td>';
                                }
                                
                                if(isset($d_shadow_work[$j]) ){
                                      echo '<td '. ($update_date_rull==true ? ' class="ent_k_d" ' : '') .(isset($d_shadow_work_p[$j]) ? ($d_shadow_work_p[$j]['date']<=($d_shadow_work[$j]['date']-$sekond_days) ? 'bgcolor="#FFD700"':' '): '').'data-key="'. $mod->id.'" data-type="d_shadow_work" data-idelem="'.$d_shadow_work_p[$j]['id'].'">'.date('d.m.Y', $d_shadow_work[$j]['date']).'</td>';
                                }else{
                                    echo '<td '. ($update_date_rull==true ? ' class="ent_k_d" ' : ' ').(isset($d_shadow_work_p[$j]) ? ($d_shadow_work_p[$j]['date']<$expared_day ? 'bgcolor="#B22222"':'' ) : '').'data-key="'. $mod->id.'" data-type="d_shadow_work" data-idelem="'.$d_shadow_work_p[$j]['id'].'"> </td>';
                                }
							/*			
                            echo '<td class="ent_k_d" '.($mod->d_shadow_work==0 ? ($mod->d_shadow_work_p<mktime(0, 0, 0, date("m"), date("d")+1, date("Y")) ? 'bgcolor="#B22222"':'' ): ($mod->d_shadow_work_p<=$mod->d_shadow_work ? 'bgcolor="#FFD700"':' ')).'data-key="'. $mod->id.'" data-type="d_shadow_work">'.($mod->d_shadow_work!=0 ? date('d.m.Y', $mod->d_shadow_work) : 'Невказано').'</td>';

*/
                            echo'<td rowspan="'.$kill_rows.'" class="'.($mod->shadow_work!=null ? 'view_k_d' : 'none').'" data-key="'. $mod->id.'" data-type="d_shadow_work">'.($mod->shadow_work!=null ? '<img src="/web/images/document.png" height="25px"': '').'</td>';

                               
//-------------Закінчення проміжних етапів------------------------------

							if(isset($d_end_interim_work_p[$j]) ){
                                       echo '<td '. ($update_date_rull==true ? ' class="ent_k_d_p" ' : ' ').' data-key="'. $mod->id.'" data-type="d_end_interim_work_p"> <a href="#date-add">'.($d_end_interim_work_p[$j]['date']!=0 ? date('d.m.Y', $d_end_interim_work_p[$j]['date']) : 'Невказано').'</a></td>';
                            }else{
                                    echo '<td '. ($update_date_rull==true ? ' class="ent_k_d_p" ': ' ').' data-key="'. $mod->id.'" data-type="d_end_interim_work_p"></td>';
                            }	

                            if(isset($d_end_interim_work[$j]) ){
                                      echo '<td '. ($update_date_rull==true ? ' class="ent_k_d" ' : ' ') .($d_end_interim_work_p[$j]['date']<=($d_end_interim_work[$j]['date']-$sekond_days) ? 'bgcolor="#FFD700"':' ').'data-key="'. $mod->id.'" data-type="d_end_interim_work" data-idelem="'.$d_end_interim_work_p[$j]['id'].'">'.date('d.m.Y', $d_end_interim_work[$j]['date']).'</td>';
                            }else{
                                    echo '<td '. ($update_date_rull==true ? ' class="ent_k_d" ': ' ') .(isset($d_end_interim_work_p[$j]) ? ($d_end_interim_work_p[$j]['date']<$expared_day ? 'bgcolor="#B22222"':'' ): '').'data-key="'. $mod->id.'" data-type="d_end_interim_work" data-idelem="'.$d_end_interim_work_p[$j]['id'].'"> </td>';
                            }

                            /* echo   '<td rowspan="'.$kill_rows.'" class="ent_k_d" '.($mod->d_end_interim_work_p<=time() ? ($mod->d_end_interim_work==0 ? 'bgcolor="#B22222"':'' ): ($mod->d_end_interim_work_p<=$mod->d_end_interim_work ? 'bgcolor="#FFD700"':' ')).'data-key="'. $mod->id.'" data-type="d_end_interim_work">'.($mod->d_end_interim_work!=0 ? date('d.m.Y', $mod->d_end_interim_work) : 'Невказано').'</td>
                            */
                            echo   '<td rowspan="'.$kill_rows.'" class="'.($mod->end_interim_work!=null ? 'view_k_d' : 'none').'" data-key="'. $mod->id.'" data-type="d_end_interim_work">'.($mod->end_interim_work!=null ? '<img src="/web/images/document.png" height="25px"': '').'</td>';

//--------------Закінчення робіт------------------------------------------------                                
							
                            if(isset($d_end_work_p[$j]) ){
                                       echo '<td '. ($update_date_rull==true ? ' class="ent_k_d_p" ': ' ').' data-key="'. $mod->id.'" data-type="d_end_work_p"> <a href="#date-add">'.($d_end_work_p[$j]['date']!=0 ? date('d.m.Y', $d_end_work_p[$j]['date']) : 'Невказано').'</a.</td>';
                            }else{
                                    echo '<td '. ($update_date_rull==true ? ' class="ent_k_d_p" ' : ' ').' data-key="'. $mod->id.'" data-type="d_end_work_p"></td>';
                            }	

                            if(isset($d_end_work[$j]) ){
                                      echo '<td '. ($update_date_rull==true ? ' class="ent_k_d" ' : ' ').($d_end_work_p[$j]['date']<=($d_end_work[$j]['date']-$sekond_days) ? 'bgcolor="#FFD700"':' ').'data-key="'. $mod->id.'" data-type="d_end_interim_work" data-idelem="'.$d_end_work_p[$j]['id'].'">'.date('d.m.Y', $d_end_work[$j]['date']).'</td>';
                            }else{
                                    echo '<td  '. ($update_date_rull==true ? ' class="ent_k_d" ': ' ') .(isset($d_end_work_p[$j]) ? ($d_end_work_p[$j]['date']<$expared_day ? 'bgcolor="#B22222"':'' ): '').'data-key="'. $mod->id.'" data-type="d_end_work" data-idelem="'.$d_end_work_p[$j]['id'].'"> </td>';
                            }

									
                            /*
                            echo '<td rowspan="'.$kill_rows.'" class="ent_k_d"  '.($mod->d_end_work_p<=time() ? ($mod->d_end_work==0 ? 'bgcolor="#B22222"':'' ): ($mod->d_end_work_p<=$mod->d_end_work ? 'bgcolor="#FFD700"':' ')).'data-key="'. $mod->id.'" data-type="d_end_work">'.($mod->d_end_work!=0 ? date('d.m.Y', $mod->d_end_work) : '').'</td>
                            */
                            echo '<td rowspan="'.$kill_rows.'" class="view_k_d" data-key="'. $mod->id.'" data-type="d_end_work">'.($mod->d_assept_work!=null ? '<img src="/web/images/document.png" height="25px"': '').'</td>';
//----------------------------------------------------------------------------------------------------------------------

                            echo '<td  '. ($update_date_rull==true ? ' class="ent_k_d_p" ': ' ').' data-key="'. $mod->id.'" data-type="d_assept_work_p" rowspan="'.$kill_rows.'"><a href="#date-add">'.($mod->d_assept_work_p!=0 ? date('d.m.Y', $mod->d_assept_work_p) : '').'</a></td>';
								
								
                                
                            echo '<td rowspan="'.$kill_rows.'"  '. ($update_date_rull==true ? ' class="ent_k_d" ': ' ') .($mod->d_assept_work_p!=0 ? ($mod->d_assept_work_p<=$expared_day ? ($mod->d_assept_work==0 ? 'bgcolor="#B22222"':'' ): ($mod->d_assept_work_p<=($mod->d_assept_work-$sekond_days) ? 'bgcolor="#FFD700"':' ')) : '').'data-key="'. $mod->id.'" data-type="d_assept_work">'.($mod->d_assept_work!=0 ? date('d.m.Y', $mod->d_assept_work) : '').'</td>

                                <td rowspan="'.$kill_rows.'" class="'.($mod->assept_work!=null ? 'view_k_d' : 'none').'" data-key="'. $mod->id.'" data-type="d_assept_work">'.($mod->assept_work!=null ? '<img src="/web/images/document.png" height="25px"': '').'</td>

                                
                            </tr>';
                            $j++;
//вывод подстрок            
                            while ( $j<$kill_rows) {
                               echo '<tr style=" background-color: '. (($i-1) % 2 == 0 ? '#FFF' : '#b072211c').';">';

//---------Вхідний контроль планова дата------------------------------------------------------------
                                if(isset($d_enter_control_p[$j]) ){ 
                                       echo '<td '. ($update_date_rull==true ? ' class="ent_k_d_p" ' : ' ') .' data-key="'. $mod->id.'" data-type="d_enter_control_p"> <a href="#date-add">'.($d_enter_control_p[$j]['date']!=0 ? date('d.m.Y', $d_enter_control_p[$j]['date']) : 'Невказано').'</a></td>';
                                }else{
                                    echo '<td '. ($update_date_rull==true ? ' class="ent_k_d_p" ' : ' ') .' data-key="'. $mod->id.'" data-type="d_enter_control_p"></td>';
                                }
//----------Вхідний контроль (дата) (фото паспортів, сертифікатів ------------------------------
                                if(isset($d_enter_controll[$j]) ){
                                      echo '<td '. ($update_date_rull==true ? ' class="ent_k_d" ' : ' ').($d_enter_control_p[$j]['date']<=($d_enter_controll[$j]['date']-$sekond_days) ? 'bgcolor="#FFD700"':' ').'data-key="'. $mod->id.'" data-type="d_enter_control" data-idelem="'.$d_enter_control_p[$j]['id'].'">'.date('d.m.Y', $d_enter_controll[$j]['date']).'</td>';
                                }else{

                                    if(isset($d_enter_control_p[$j])){
                                        echo '<td '. ($update_date_rull==true ? ' class="ent_k_d" ' : ' ').($d_enter_control_p[$j]['date']<$expared_day ? 'bgcolor="#B22222"':'' ).'data-key="'. $mod->id.'" data-type="d_enter_control" data-idelem="'.$d_enter_control_p[$j]['id'].'">Невказано</td>';
                                    }else{
                                        echo "<td></td>";
                                    }
                                }

//----------Приховані роботи планова дата-------------------------------------------
                                if(isset($d_shadow_work_p[$j]) ){ 
                                       echo '<td '. ($update_date_rull==true ? ' class="ent_k_d_p" ' : ' ') .' data-key="'. $mod->id.'" data-type="d_shadow_work_p"> <a href="#date-add">'.($d_shadow_work_p[$j]['date']!=0 ? date('d.m.Y', $d_shadow_work_p[$j]['date']) : 'Невказано').'</a></td>';
                                }else{
                                    echo '<td '. ($update_date_rull==true ? ' class="ent_k_d_p" ' : ' ') .' data-key="'. $mod->id.'" data-type="d_shadow_work_p"></td>';
                                }

                                if(isset($d_shadow_work[$j]) ){
                                      echo '<td '. ($update_date_rull==true ? ' class="ent_k_d" ' : ' ').($d_shadow_work_p[$j]['date']<=($d_shadow_work[$j]['date']-$sekond_days) ? 'bgcolor="#FFD700"':' ').'data-key="'. $mod->id.'" data-type="d_shadow_work" data-idelem="'.$d_shadow_work_p[$j]['id'].'">'.date('d.m.Y', $d_shadow_work[$j]['date']).'</td>';
                                }else{

                                    if(isset($d_shadow_work_p[$j])){
                                        echo '<td '. ($update_date_rull==true ? ' class="ent_k_d" ' : ' ').($d_shadow_work_p[$j]['date']<$expared_day ? 'bgcolor="#B22222"':'' ).'data-key="'. $mod->id.'" data-type="d_shadow_work" data-idelem="'.$d_shadow_work_p[$j]['id'].'">Невказано</td>';
                                    }else{
                                        echo "<td></td>";
                                    }
                                }

//----------Закінчення проміжних етапів планова дата-------------------------------------------------------------------------
                                if(isset($d_end_interim_work_p[$j]) ){ 
                                       echo '<td '. ($update_date_rull==true ? ' class="ent_k_d_p" ' : ' ') .' data-key="'. $mod->id.'" data-type="d_end_interim_work_p"> <a href="#date-add">'.($d_end_interim_work_p[$j]['date']!=0 ? date('d.m.Y', $d_end_interim_work_p[$j]['date']) : 'Невказано').'</a></td>';
                                }else{
                                    echo '<td '. ($update_date_rull==true ? ' class="ent_k_d_p" ' : ' ') .' data-key="'. $mod->id.'" data-type="d_end_interim_work_p"></td>';
                                }

                                if(isset($d_end_interim_work[$j]) ){
                                      echo '<td '. ($update_date_rull==true ? ' class="ent_k_d" ' : ' ').($d_end_interim_work_p[$j]['date']<=($d_end_interim_work[$j]['date']-$sekond_days) ? 'bgcolor="#FFD700"':' ').'data-key="'. $mod->id.'" data-type="d_end_interim_work" data-idelem="'.$d_end_interim_work_p[$j]['id'].'">'.date('d.m.Y', $d_end_interim_work[$j]['date']).'</td>';
                                }else{

                                    if(isset($d_end_interim_work_p[$j])){
                                        echo '<td '. ($update_date_rull==true ? ' class="ent_k_d" ' : ' ').($d_end_interim_work_p[$j]['date']<$expared_day ? 'bgcolor="#B22222"':'' ).'data-key="'. $mod->id.'" data-type="d_end_interim_work" data-idelem="'.$d_end_interim_work_p[$j]['id'].'">Невказано</td>';
                                    }else{
                                        echo "<td></td>";
                                    }
                                }
//--------------------------------------------------------------------------------------------------
                                if(isset($end_work_p[$j]) ){ 
                                       echo '<td '. ($update_date_rull==true ? ' class="ent_k_d_p" ' : ' ') .' data-key="'. $mod->id.'" data-type="end_work_p"> <a href="#date-add">'.($end_work_p[$j]['date']!=0 ? date('d.m.Y', $end_work_p[$j]['date']) : 'Невказано').'</a></td>';
                                }else{
                                    echo '<td '. ($update_date_rull==true ? ' class="ent_k_d_p" ' : ' ') .' data-key="'. $mod->id.'" data-type="end_work_p"></td>';
                                }

                                if(isset($end_work[$j]) ){
                                      echo '<td '. ($update_date_rull==true ? ' class="ent_k_d" ' : ' ').($end_work_p[$j]['date']<=($end_work[$j]['date']-$sekond_days) ? 'bgcolor="#FFD700"':' ').'data-key="'. $mod->id.'" data-type="end_work" data-idelem="'.$end_work_p[$j]['id'].'">'.date('d.m.Y', $end_work[$j]['date']).'</td>';
                                }else{

                                    if(isset($end_work_p[$j])){
                                        echo '<td '. ($update_date_rull==true ? ' class="ent_k_d" ' : ' ').($end_work_p[$j]['date']<$expared_day ? 'bgcolor="#B22222"':'' ).'data-key="'. $mod->id.'" data-type="end_work" data-idelem="'.$end_work_p[$j]['id'].'">Невказано</td>';
                                    }else{
                                        echo "<td></td>";
                                    }
                                }


                                
                               echo '</tr>';
                               $j++;
                            }

                    }
                      
               }
            }
        ?>

    </tbody>

    </table>



    <?php Pjax::end(); ?>
<?php
echo LinkPager::widget(['pagination' => $pages]);
?>
    <?php
\bluezed\floatThead\FloatThead::widget(
    [
        'tableId' => 'myTable', 
        'options' => [
            'top'=>'50'
        ]
    ]
);
?>

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

<?php $this->registerJs("
$('.ent_k_d').on('click', function(){
    var data = $(this).data();
    $('#modal-info').modal('show');
    $('#modal-info').find('.modal-title').text('Load files');
    $('#modal-info').find('.modal-body').load('/web/dirtexn/updatedate?id='+ data.key+'&type='+ data.type+'&idelem='+ data.idelem);
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

<?php $this->registerJs("
$('.ent_k_d_p').on('click', function(){
    var data = $(this).data();
    $('#modal-img').modal('show');
    $('#modal-img').find('.modal-title').text('Введення дати');
   $('#modal-img').find('.modal-body').load('/web/dirtexn/updatedatep?id='+ data.key+'&type='+ data.type);
    })
    ");
?>



<?php $this->registerJs("
$('.ent_texta').on('click', function(){
    var data = $(this).data();
    $('#modal-img').modal('show');
    $('#modal-img').find('.modal-title').text('Введення');
   $('#modal-img').find('.modal-body').load('/web/dirtexn/updatetextarea?id='+ data.key+'&type='+ data.type);
    })
    ");
?>


<?php/*
echo LinkPager::widget(['pagination' => $pages,
			//'params'=>['id_obl'=>2],
			]);*/
?>

