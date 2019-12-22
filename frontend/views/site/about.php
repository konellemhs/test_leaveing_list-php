<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\RequestForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\date\DatePicker;
$this->title = 'Create';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-signup">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row">
        <div class="col-lg-5">
            <? $form = ActiveForm::begin() ?>
            <?
        echo $form->field($model, 'date_start')->widget(DatePicker::classname(), [
                 'options' => [
                     'placeholder' => Yii::t('app', 'Начало отпуска'), 
                 ],
           
              'type' => DatePicker::TYPE_INPUT,
              'pluginOptions' => [
                'todayHighlight' => true,
                'autoclose'=>true,
                'format' => 'dd/mm/yyyy',
                'startView' => 1,
                'startDate'=>date('d/m/Y')
  ],
])->label(Yii::t('app', 'Введите дату начала отпуска в формате дд\мм\гггг'));

    
   ?>
                
         
          <? echo $form->field($model, 'date_finish')->widget(DatePicker::classname(), [
                 'options' => [
                     'placeholder' => Yii::t('app', 'Конец отпуска'), 
                 ],
           
              'type' => DatePicker::TYPE_INPUT,
              'pluginOptions' => [
                'todayHighlight' => true,
                'autoclose'=>true,
                'format' => 'dd/mm/yyyy',
                'startView' => 1,
                'startDate'=> date('d/m/Y')
  ],
])->label(Yii::t('app', 'Введите дату конца отпуска в формате дд\мм\гггг'));

   ?>                 
                <div class="form-group">
                   <?= Html::submitButton('Создать', ['class' => 'btn btn-success']) ?>
                </div>
<!-- ['type' => 'date(format)'] -->
            <? ActiveForm::end(); ?>
        </div>
    </div>
</div>