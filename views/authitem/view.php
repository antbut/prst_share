<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\AuthItem;

/* @var $this yii\web\View */
/* @var $model app\models\AuthItem */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Ролі', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="auth-item-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->name], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->name], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>

        <?= Html::a('Add Rules', ['addpermisiontorole', 'id' => $model->name], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'name',
            'type',
            'description:ntext',
            'rule_name',
            'data',
            'created_at',
            'updated_at',
        ],
    ]) ?>

    <h4>Доступні дозволи</h4>
<?php
    if($permisions){

        echo "<table>";
        echo "<tr><th>назва в системі</th><th>опис ролі</th></tr>";
        foreach ($permisions as  $permision) {

            echo '<tr><td>'.$permision->child.' </td><td> '.AuthItem::findOne(['name'=>$permision->child])->description."</td><tr>";
            
        }
        echo "</table>";
    }
?>
    <pre>
        <?php //var_dump($permisions) ?>
    </pre>

</div>
