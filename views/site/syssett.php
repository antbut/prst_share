<?php
use app\models\SysParam;
use yii\helpers\Html;

/* @var $this yii\web\View */

$this->title = 'My Yii Application';
?>
<div class="site-index">

    <div class="jumbotron">
     
        <p class="lead">Cистемі параметри</p>

        <p>Вільного місця <?= $free_disk ?></p>
        <p>Всього місця <?= $full_disk ?></p>

        <p>Всього памяті для php <?= memory_get_usage() ?> </p>

        <p><h4>Параметри системи</h4></p>
        <table align="center">

            <?php
                foreach ($sys_par as $key => $value) {
                    echo '<tr><td>'.'</td><td>'.$value['deskription'].'</td><td>'.SysParam::GetParam($value['name']).'</td></tr>';
                }

            ?>
        </table>

<?php
         echo Html::a(Yii::t('app', 'запуск сброс в корзину по закінченнютерміну'), ['main/droppidrfromobject' ], ['class' => 'btn btn-primary']);

         echo "<br>";

         echo Html::a(Yii::t('app', 'phpMyAdmin'), 'https://45.83.193.144:2003/phpmyadmin' , ['class' => 'btn btn-primary']);
         ?>

    </div>

    <div class="body-content">

      <?php

      ?>

    </div>
</div>
