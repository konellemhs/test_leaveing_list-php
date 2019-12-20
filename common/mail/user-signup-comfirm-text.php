<?php

 // @var $user \common\models\User 

$confirmLink = Yii::$app->urlManager->createAbsoluteUrl(['site/signup-confirm', 'token' => $user->verification_token]);
?>
Hello <?= $user->username ?>,

Follow the link below to confirm your email:

<?= $confirmLink ?>