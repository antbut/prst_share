<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\ProjektTupes;
use app\models\Organizations;
use app\models\ObjektStatus;
use yii\helpers\Url;
use app\models\PidrStaus;
use yii\data\Pagination;
use yii\widgets\LinkPager;
use app\models\ParentOrg;
use app\models\DirScStatus;

use yii\helpers\ArrayHelper;
use kartik\export\ExportMenu;

/* @var $this yii\web\View */
/* @var $searchModel app\models\MainSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Звіти');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="main-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php //var_dump(ParentOrg::GetCostemerObl(2));?>
<br>

    <p>
    <?php 
       // print_r($result);


     ?>
    </p>
    <br>
    <?= Html::a(Yii::t('app', 'Весьчас '), ['objetlcount', 'id' => 1], ['class' => 'btn btn-primary']) ?>
    <?= Html::a(Yii::t('app', 'минулий тиждень '), ['objetlcount', 'id' => 1], ['class' => 'btn btn-primary']) ?>
    <?= Html::a(Yii::t('app', 'поточний місяць '), ['objetlcount', 'id' => 2], ['class' => 'btn btn-primary']) ?>
    <?= Html::a(Yii::t('app', 'поточний рік '), ['objetlcount', 'id' => 3], ['class' => 'btn btn-primary']) ?>
    <br><br><br>


<?php
    echo 'Період звіту: '.date('Y-m-d', $start_date).' - '. date('Y-m-d', $end_date);
    echo "<br> ";
?>

    <table style="border: 1px double black; border-collapse: collapse
; ">
        <tr style="padding-left: 10px; "><th>Обленерго</th><th style="padding: 10px; ">Кількість внесених</th><th style="padding: 10px; ">Проект+ ВОВР</th><th style="padding: 10px; ">П+Д</th><th style="padding: 10px; ">Закрито обєктов</th></tr>
        <?php

            $count_new = 0;
            $count_P_V = 0;
            $count_P_D = 0;
            $count_cloce = 0;
        foreach ($result as $key => $value) {
            echo '<tr align="center" style="border: 1px double black; border-collapse: collapse
; "><td>'.$key.'</td><td>'.$value['count_new'].'</td><td>'.$value['count_P_V'].'</td><td>'.$value['count_P_D'].'</td><td>'.$value['count_cloce'].'</td></tr>';
            $count_new +=$value['count_new'];
            $count_P_V += $value['count_P_V'];
            $count_P_D += $value['count_P_D'];
            $count_cloce += $value['count_cloce'];
        }
            echo '<tr  align="center"><td>Сумма</td><td>'.$count_new.'</td><td>'.$count_P_V.'</td><td>'.$count_P_D.'</td><td>'.$count_cloce.'</td></tr>';


          ?>


    </table>


   
