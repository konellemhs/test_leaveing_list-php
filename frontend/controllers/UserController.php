<?php
use common\models\User;
use yii\web\Controller;
use Yii;
/**
 * 
 */
class UserController extends Controller
{
	 public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new Users();
        if ($model->load(Yii::$app->request->post()) 
            && $model->login()) {
            return $this->goBack();
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }
    
     public function login()
    {
        if ($this->validate()) {
        return Yii::$app->user->login($this->getUser());
        }
    }
}