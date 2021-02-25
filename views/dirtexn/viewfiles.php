<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\DirTexn */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Dir Texns', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="dir-texn-view">

    <h3><?= Html::encode($title) ?></h3>
    
<?php //echo "user=".Yii::$app->user->id; ?>
    <table>
        <tr><th>  Назва  </th><th></th><th>  Дата  </th><th>  Завантажив </th></tr>

        <?php
            function cmp($a, $b){
                    if ($a['key_id'] == $b['key_id']) {
                        return 0;
                    }
                    return ($a['key_id'] < $b['key_id']) ? -1 : 1;
                }

                usort($data, "cmp");

                $key_id=-1;

            foreach ($data as $value) {

                if($key_id!=$value['key_id']){
                    $key_id=$value['key_id'];
                   echo '<tr><td colspan="4">'.($value['key_id']+1).' дата </td></tr>';
                   
                }
                echo '<tr><td><a href="'.Url::to(['download/viewfile', 'id' => $value['id']]).'"  target="_blank">'.$value['name'].'</a></td><td><a href="'.Url::to(['download/download', 'id' => $value['id']]).'" style="padding:5px"><img src="/web/images/save.png" height="25px"></a></td><td style="padding:5px">'.date('d.m.Y',$value['data']).'</td><td>'.$value['autor'].'</td><td>'.(Yii::$app->user->can('dirtexnDeleteFile') ? '<a href="'.Url::to(['dirtexn/deleteuploadfile', 'id' => $model->id, 'id_file'=>$value['id'],'type'=>$type]).'">'.'<img src="/web/images/icons-delete.png" height="25px"></a>' : true).'</td></tr>';
            }
        ?>

    </table>

   

</div>




<?php /*$this->registerJs("
$('.view_img').on('click', function(){
    var data = $(this).data();
    $('#modal-img').modal('show');
    $('#modal-img').find('.modal-title').text('load files');
    $('#modal-img').find('.modal-body').load('/web/download/viewfile?id='+ data.key);
    })
    ");*/
?>