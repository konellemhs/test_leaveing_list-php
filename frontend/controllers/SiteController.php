<?php
namespace frontend\controllers;

use Yii;
use common\models\User;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use frontend\models\LoginForm;
use frontend\models\SignupForm;
use frontend\models\RequestForm;
use frontend\models\Usert;
use frontend\models\UsertSearch;
/**
 * Site controller
 */
class SiteController extends Controller
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['signup', 'login'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['index','list','logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['about'],
                        'allow' => true,
                        'roles' => ['employee'],
                    ],
                    [
                        'actions' => ['about'],
                        'allow' => false,
                        'roles' => ['boss'],
                         // редиректит пользователя в случае попытки совершить action не для его роли
                        'denyCallback' => function ($rule, $action) {                
                                return $action->controller->redirect('index');
                            },
                    ],
                    [
                        'actions' => ['update'],
                        'allow' => true,
                        'roles' => ['boss'],
                    ],
                    [
                        'actions' => ['update'],
                        'allow' => false,
                        'roles' => ['employee'],
                         // редиректит пользователя в случае попытки совершить action не для его роли
                        'denyCallback' => function ($rule, $action) {                
                                return $action->controller->redirect('index');
                            },
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

   

    /*
    actionSignup -  действие регистрации пользователя на сервисе,
     после регистрации просисходит автологин
    */
        public function actionSignup(){

            $model = new SignupForm();
            if ($model->load(Yii::$app->request->post())) {
            
                if ($user = $model->signup()) {                                                                                // возврат пользователя для автологина

                    if (Yii::$app->getUser()->login($user)) {																	// автологин пользователя
                    
                        Yii::$app->session->setFlash('success', 'Добро пожаловать, '. Yii::$app->user->identity->first_name);

                        if (Yii::$app->user->identity->fixied === 1) {													// вывод сообщения о успехе, если заяка уже зафиксирована
                                Yii::$app->session->setFlash('success', 'Ваша заявка на отпуск с '  .  Yii::$app->user->identity->date_start . ' по ' . Yii::$app->user->identity->date_finish . ' была зафиксирована. Хорошего отдыха!' );
                                }

                        return $this->goHome();
                    }
                } 
            }


            return $this->render('signup', [
                'model' => $model,
            ]);
        }


        public function actionLogin(){

                 if (!Yii::$app->user->isGuest) {
                return $this->goHome();
                }

                $model = new LoginForm();
                if ($model->load(Yii::$app->request->post())) {
                    try{

                        if($model->login()){
                             Yii::$app->session->setFlash('success', 'Добро пожаловать, '. Yii::$app->user->identity->first_name);
                             if (Yii::$app->user->identity->fixied === 1) {
                                  Yii::$app->session->setFlash('success', 'Ваша заявка на отпуск с '  .  Yii::$app->user->identity->date_start . ' по ' . Yii::$app->user->identity->date_finish . ' была зафиксирована. Хорошего отдыха!' );
        }
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

   public function actionUpdate($id)
    {
        
        
            $user = User::findIdentity($id);
            $user->fixied = 1;
            $user->save();
            // echo '<pre>'; 
            //          print_r(Yii::$app->user->identity->date_start); 
            //          echo '</pre>';
            Yii::$app->session->setFlash('success', 'Заявка на отпуск по сотруднику ' . $user->first_name . '  ' . $user->last_name  . '  с  ' .  $user->date_start . '  по  ' . $user->date_finish . '  зафиксирована');
            return $this->goBack();
       
   }

     public function actionIndex()
    {
        // if (Yii::$app->user->isGuest) {
        //        return Yii::$app->response->redirect('site\login');
        // }
       
    
        $searchModel = new UsertSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        if (Yii::$app->user->identity->role == '1') {
               return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
        }
        return $this->render('list', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionLogout()
    {   
        Yii::$app->user->logout();

        return $this->goHome();
    }

}



    
