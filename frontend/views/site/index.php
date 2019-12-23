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


 
 <?
   echo GridView::widget([
        'dataProvider'  => $dataProvider,
        'filterModel'   => $searchModel,

        'rowOptions'    => function ($model, $key, $index, $grid)
                             {
                             if($model->fixied == 1) {
                                return ['style' => 'background-color: #9ACD32'];
                              }
                         },
        'columns'       => [
            ['class'    => 'yii\grid\SerialColumn'],

            'first_name' ,
            'last_name',
            'date_start',
            'date_finish',

             ['class'   => 'yii\grid\ActionColumn','template' => '{update}',
             'visibleButtons' => [
                'update' => function ($model, $key, $index) {
                     return $model->fixied !== 1;
                 }
             ]
        ],
      ]
    ]); 
    ?>


</div>
        

