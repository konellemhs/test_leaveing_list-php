<?php
namespace frontend\controllers;

//use frontend\models\ResendVerificationEmailForm;
//use frontend\models\VerifyEmailForm;
use Yii;
use common\models\User;
//use yii\base\InvalidArgumentException;
//use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
//use frontend\models\PasswordResetRequestForm;
//use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\RequestForm;
//use frontend\models\ContactForm;
//use common\services\auth\SignupService;
/**
 * Site controller
 */
class SiteController extends Controller
{
// public function actionSignup(){
//  if (!Yii::$app->user->isGuest) {
//  return $this->goHome();
//  }
//  $model = new SignupForm();
//  if($model->load(\Yii::$app->request->post()) && $model->validate()){
//  echo '<pre>'; print_r($model);
//  die;
//  }

//  return $this->render('signup', compact('model'));
// }

            // public function actionSignup(){
            //      if (!Yii::$app->user->isGuest) {
            //      return $this->goHome();
            //      }
            //      $model = new SignupForm();
            //      if($model->load(\Yii::$app->request->post()) && $model->validate()){
            //                  $user = new User();
            //                  $user->username = $model->username;
            //                 $user->password = \Yii::$app->security->generatePasswordHash($model->password);

            //                     if($user->save()){
            //                          return $this->goHome();
            //                      }
            //      }
            //  return $this->render('signup', compact('model'));
            //  }



     public function actionSignup()
    {

        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post()) && $model->signup()) {
            Yii::$app->session->setFlash('success', 'Thank you for registration.');


            return $this->goHome();
        }


        return $this->render('signup', [
            'model' => $model,
        ]);
    }


        public function actionAbout(){

            $model = new RequestForm();
            
        if ($model->load(Yii::$app->request->post()) && $model->request()) {
    
            Yii::$app->session->setFlash('success','Ваша заявка принята в обработку...');
          
            return $this->goHome();
        }


        return $this->render('about', [
            'model' => $model,
        ]);
    }
        

         public function behaviors()
         {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }
    public function actionIndex()
    {
        return $this->render('index');
    }


     public function actionLogin()
    {
         if (!Yii::$app->user->isGuest) {
        return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post())) {
            try{

                if($model->login()){
                    return $this->goBack();
                }else{
                    $model->password = '';
                }

            } catch (\DomainException $e){
                Yii::$app->session->setFlash('error', $e->getMessage());
                return $this->goHome();
            }
        }

        return $this->render('login', [
                'model' => $model,
            ]);

    }
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    // public function actionSignup()
    // {
    //     if (!Yii::$app->user->isGuest) {
    //         return $this->goHome();
    //     }

    //     $model = new SignupForm();
    //     if ($model->load(Yii::$app->request->post()) ) {
    //         return $this->goBack();
    //     } else {
    //         $model->password = '';

    //         return $this->render('login', [
    //             'model' => $model,
    //         ]);
    //     }
    // }





}



    /**
    //  * {@inheritdoc}
    //  */
    // public function behaviors()
    // {
    //     return [
    //         'access' => [
    //             'class' => AccessControl::className(),
    //             'only' => ['logout', 'signup'],
    //             'rules' => [
    //                 [
    //                     'actions' => ['signup'],
    //                     'allow' => true,
    //                     'roles' => ['?'],
    //                 ],
    //                 [
    //                     'actions' => ['logout'],
    //                     'allow' => true,
    //                     'roles' => ['@'],
    //                 ],
    //             ],
    //         ],
    //         'verbs' => [
    //             'class' => VerbFilter::className(),
    //             'actions' => [
    //                 'logout' => ['post'],
    //             ],
    //         ],
    //     ];
    // }

    // /**
    //  * {@inheritdoc}
    //  */
    // public function actions()
    // {
    //     return [
    //         'error' => [
    //             'class' => 'yii\web\ErrorAction',
    //         ],
    //         'captcha' => [
    //             'class' => 'yii\captcha\CaptchaAction',
    //             'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
    //         ],
    //     ];
    // }

    // /**
    //  * Displays homepage.
    //  *
    //  * @return mixed
    //  */
    // public function actionIndex()
    // {
    //     return $this->render('index');
    // }

    // /**
    //  * Logs in a user.
    //  *
    //  * @return mixed
    //  */
    // // public function actionLogin()
    // // {
    // //     if (!Yii::$app->user->isGuest) {
    // //         return $this->goHome();
    // //     }

    // //     $model = new LoginForm();
    // //     if ($model->load(Yii::$app->request->post()) && $model->login()) {
    // //         return $this->goBack();
    // //     } else {
    // //         $model->password = '';

    // //         return $this->render('login', [
    // //             'model' => $model,
    // //         ]);
    // //     }
    // // }
    
    
    // public function actionLogin()
    // {
    //      if (!Yii::$app->user->isGuest) {
    //     return $this->goHome();
    //     }

    //     $model = new LoginForm();
    //     if ($model->load(Yii::$app->request->post())) {
    //         try{

    //             if($model->login()){
    //                 return $this->goBack();
    //             }

    //         } catch (\DomainException $e){
    //             Yii::$app->session->setFlash('error', $e->getMessage());
    //             return $this->goHome();
    //         }
    //     }

    //     return $this->render('login', [
    //         'model' => $model,
    //     ]);
    // }

    // /**
    //  * Logs out the current user.
    //  *
    //  * @return mixed
    //  */
    // // public function actionLogout()
    // // {
    // //     Yii::$app->user->logout();

    // //     return $this->goHome();
    // // }
    // public function actionLogout()
    // {
    //     Yii::$app->user->logout();

    //     return $this->goHome();
    // }

    // /**
    //  * Displays contact page.
    //  *
    //  * @return mixed
    //  */
    // public function actionContact()
    // {
    //     $model = new ContactForm();
    //     if ($model->load(Yii::$app->request->post()) && $model->validate()) {
    //         if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
    //             Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
    //         } else {
    //             Yii::$app->session->setFlash('error', 'There was an error sending your message.');
    //         }

    //         return $this->refresh();
    //     } else {
    //         return $this->render('contact', [
    //             'model' => $model,
    //         ]);
    //     }
    // }

    // /**
    //  * Displays about page.
    //  *
    //  * @return mixed
    //  */
    // public function actionAbout()
    // {
    //     return $this->render('about');
    // }

    // /**
    //  * Signs user up.
    //  *
    //  * @return mixed
    //  */
    // // public function actionSignup()
    // // {
    // //     $model = new SignupForm();
    // //     if ($model->load(Yii::$app->request->post()) && $model->signup()) {
    // //         Yii::$app->session->setFlash('success', 'Thank you for registration. Please check your inbox for verification email.');
    // //         return $this->goHome();
    // //     }

    // //     return $this->render('signup', [
    // //         'model' => $model,
    // //     ]);
    // // }

    // public function actionSignup()
    // {
    //     $model = new SignupForm();
    //     if ($model->load(Yii::$app->request->post()) && $model->validate()) {
    //         $signupService = new SignupService();

    //         try{
    //             $user = $signupService->signup($model);
    //             Yii::$app->session->setFlash('success', 'Check your email to confirm the registration.');
    //             $signupService->sentEmailConfirm($user);
    //             return $this->goHome();
    //         } catch (\RuntimeException $e){
    //             Yii::$app->errorHandler->logException($e);
    //             Yii::$app->session->setFlash('error', $e->getMessage());
    //         }
    //      }

    //     return $this->render('signup', [
    //         'model' => $model,
    //     ]);
    // }
    // public function actionSignupConfirm($token)
    // {
    //      $signupService = new SignupService();

    //      try{
    //          $signupService->confirmation($token);
    //          Yii::$app->session->setFlash('success', 'You have successfully confirmed your registration.');
    //     } catch (\Exception $e){
    //         Yii::$app->errorHandler->logException($e);
    //         Yii::$app->session->setFlash('error', $e->getMessage());
    //     }

    //     return $this->goHome();
    // }


    // /**
    //  * Requests password reset.
    //  *
    //  * @return mixed
    //  */
    // public function actionRequestPasswordReset()
    // {
    //     $model = new PasswordResetRequestForm();
    //     if ($model->load(Yii::$app->request->post()) && $model->validate()) {
    //         if ($model->sendEmail()) {
    //             Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

    //             return $this->goHome();
    //         } else {
    //             Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
    //         }
    //     }

    //     return $this->render('requestPasswordResetToken', [
    //         'model' => $model,
    //     ]);
    // }

    // /**
    //  * Resets password.
    //  *
    //  * @param string $token
    //  * @return mixed
    //  * @throws BadRequestHttpException
    //  */
    // public function actionResetPassword($token)
    // {
    //     try {
    //         $model = new ResetPasswordForm($token);
    //     } catch (InvalidArgumentException $e) {
    //         throw new BadRequestHttpException($e->getMessage());
    //     }

    //     if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
    //         Yii::$app->session->setFlash('success', 'New password saved.');

    //         return $this->goHome();
    //     }

    //     return $this->render('resetPassword', [
    //         'model' => $model,
    //     ]);
    // }

    // /**
    //  * Verify email address
    //  *
    //  * @param string $token
    //  * @throws BadRequestHttpException
    //  * @return yii\web\Response
    //  */
    // public function actionVerifyEmail($token)
    // {
    //     try {
    //         $model = new VerifyEmailForm($token);
    //     } catch (InvalidArgumentException $e) {
    //         throw new BadRequestHttpException($e->getMessage());
    //     }
    //     if ($user = $model->verifyEmail()) {
    //         if (Yii::$app->user->login($user)) {
    //             Yii::$app->session->setFlash('success', 'Your email has been confirmed!');
    //             return $this->goHome();
    //         }
    //     }

    //     Yii::$app->session->setFlash('error', 'Sorry, we are unable to verify your account with provided token.');
    //     return $this->goHome();
    // }

    // /**
    //  * Resend verification email
    //  *
    //  * @return mixed
    //  */
    // public function actionResendVerificationEmail()
    // {
    //     $model = new ResendVerificationEmailForm();
    //     if ($model->load(Yii::$app->request->post()) && $model->validate()) {
    //         if ($model->sendEmail()) {
    //             Yii::$app->session->setFlash('success', 'Check your email for further instructions.');
    //             return $this->goHome();
    //         }
    //         Yii::$app->session->setFlash('error', 'Sorry, we are unable to resend verification email for the provided email address.');
    //     }

    //     return $this->render('resendVerificationEmail', [
    //         'model' => $model
    //     ]);
    // }

