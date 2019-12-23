<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Usert */

$this->title = 'Create Usert';
$this->params['breadcrumbs'][] = ['label' => 'Userts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="usert-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
