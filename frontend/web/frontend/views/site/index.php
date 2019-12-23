<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\UsertSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Userts';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="usert-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Usert', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'username',
            'password',
            'first_name',
            'last_name',
            //'role',
            //'date_start',
            //'date_finish',
            //'fixied',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
