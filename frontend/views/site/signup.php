<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Вход';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-signup">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Введите данные для регистрации: </p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin() ?>

                 <?= $form->field($model, 'first_name') ?>
                 <?= $form->field($model, 'last_name') ?>

                <?= $form->field($model, 'username') ?>


                <?= $form->field($model, 'password')->passwordInput() ?>

                 <?= $form->field($model, 'role')->dropDownList([
                    '0' => 'Сотрудник',
                    '1' => 'Руководитель'

                 ]); ?>

                <div class="form-group">
                   <?= Html::submitButton('Регистрация', ['class' => 'btn btn-success']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>

