<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\UsertSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Список';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="usert-index">

    <h1><?= Html::encode($this->title) ?></h1>

<p>

      <?= Html::a("Обновить", ['index'], ['class' => 'btn btn-lg btn-primary'])?>
 </p>

  
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'summary'       => false,
         'rowOptions'    => function ($model, $key, $index, $grid)
                             {
                             if($model->fixied == 1) {
                                return ['style' => 'background-color: #9ACD32'];
                              }
                         },
        'columns' => [
            
            ['class' => 'yii\grid\SerialColumn'],
            
          
          
            
            
            'user_first_name',
            'user_last_name',
            'date_start',
            'date_finish',
         
        ],
    ]); ?>


</div>