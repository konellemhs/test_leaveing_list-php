<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\RequestForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\date\DatePicker;

if ( Yii::$app->user->identity->date_exists) {

$this->title = 'Изменить заявку';

}else {
  $this->title = 'Создать заявку';  
}
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-signup">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row">
        <div class="col-lg-5">

        <? if ( Yii::$app->user->identity->date_exists) {?>
        <div style="color: green"> 
          У вас уже есть заявка  с <?= Yii::$app->user->identity->date_start ?> по  <?= Yii::$app->user->identity->date_finish ?>. <br><br>
          В данный момент она ожидает подтверждения от руководителя.<br><br>
            Если вы хотите изменить заявку, заолните форму ниже:<br>
             </div>
        <?}else{ ?>

           <div style="color: red">
            У вас нет заявки(<br>
            Не беда! <br>
            Заполните форму ниже и ожидайте одобрения руководителя : 
              <br><br>
           </div>

          <?}?>
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
                  <?if ( Yii::$app->user->identity->date_exists) {?>
                    <?= Html::submitButton('Изменить заявку', ['class' => 'btn btn-success']) ?>
                    <?} else{?>
                   <?= Html::submitButton('Создать', ['class' => 'btn btn-success']) ?>
                   <?}?>
                </div>

            <? ActiveForm::end(); ?>
        </div>
    </div>
</div>