<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Signup';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-signup">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Please fill out the following fields to signup:</p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin() ?>

                <?= $form->field($model, 'username') ?>


                <?= $form->field($model, 'password')->passwordInput() ?>

                 <?= $form->field($model, 'role') ?>

                <div class="form-group">
                   <?= Html::submitButton('Регистрация', ['class' => 'btn btn-success']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>

<!-- <?php

//use yii\helpers\Html;
//use yii\bootstrap\ActiveForm;
?>

<?php $form = ActiveForm::begin() ?>
<?= $form->field($model, 'username') ?>
<?= $form->field($model, 'password')->passwordInput() ?>
<div class="form-group">
 <div>
 <?= Html::submitButton('Регистрация', ['class' => 'btn btn-success']) ?>
 </div>
</div>
<?php ActiveForm::end() ?> -->