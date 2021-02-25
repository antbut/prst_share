<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\DownloadFiles */
?>
<div class="download-files-view">
<?php
	if($viewfile_url){
		echo Html::img('/web/files/'.$viewfile_url);
	}else{
		echo "Перегляд вайлу не можливий але вы можете його завантажити";
	}
?>
  <?//= Html::img('/web/files/'.$viewfile_url) ?>



    

</div>
