<?php

/* @var $this \yii\web\View */
/* @var $content string */

use common\models\User;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => 'Отпуска',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);

    if (Yii::$app->user->identity->role === '0' && Yii::$app->user->identity->status == User::STATUS_NONE ) {  
         $menuItems = [
                ['label' => 'Список заявок', 'url' => ['/site/index']],
                ['label' => '+Создать заявку', 'url' => ['/site/about']]];
   
    }elseif(Yii::$app->user->identity->role === '0' &&  Yii::$app->user->identity->status == User::STATUS_FIX ){

            $menuItems = [
                ['label' => 'Список заявок', 'url' => ['/site/index']]];

    }elseif (Yii::$app->user->identity->role === '0' && Yii::$app->user->identity->status == User::STATUS_WAIT ) {

       $menuItems = [
        ['label' => 'Список заявок', 'url' => ['/site/index']],
        ['label' => 'Моя заявка', 'url' => ['/site/about']]];

    }elseif(Yii::$app->user->identity->role === '1'){
       $menuItems = [
        ['label' => 'Список заявок', 'url' => ['/site/index']]
    ];
    }

    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => 'Регистрация', 'url' => ['/site/signup']];
        $menuItems[] = ['label' => 'Вход', 'url' => ['/site/login']];
    } else {
        $menuItems[] = '<li>'
            . Html::beginForm(['/site/logout'], 'post')
            . Html::submitButton(
                'Выход (' . Yii::$app->user->identity->first_name . ')',
                ['class' => 'btn btn-link logout']

            )
            . Html::endForm()
            . '</li>';
    }
   
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menuItems,
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; <?= Html::encode(Yii::$app->name) ?> <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
