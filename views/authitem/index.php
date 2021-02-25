<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\AuthitemSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Ролі';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="auth-item-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Auth Item', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'name',
            //'type',

            [   'attribute'=>'type',
                'label'=>'type',
                'value'=> function($data){
                    switch ($data->type) {
                        case 1:
                            return 'Роль'; 
                            break;
                        
                        case 2:
                            return 'Правило'; 
                            break;
                    }
                  
                 },

                 'filter' => Html::activeDropDownList(
                    $searchModel,
                    'type',
                    ['1'=>'Роль', '2'=>'Правило'],
                    ['class' => 'form-control', 'prompt' => 'Все']
                ),
            ],
            'description:ntext',
            'rule_name',
          //  'data',
            //'created_at',
            //'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
