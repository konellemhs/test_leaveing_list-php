<?php
namespace frontend\controllers;

use Yii;
use common\models\User;
use common\models\Leave;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use frontend\models\LoginForm;
use frontend\models\SignupForm;
use frontend\models\RequestForm;
use common\models\LeaveSearch;
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
                        'actions' => ['index','leavingList','role','logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['request'],
                        'allow' => true,
                        'roles' => ['employee'],
                    ],
                    [
                        'actions' => ['request'],
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

                         if (Yii::$app->user->identity->status == User::STATUS_FIX) {													// вывод сообщения о успехе, если заяка уже зафиксирована
                                 Yii::$app->session->setFlash('success', 'Ваша заявка на отпуск  была зафиксирована. Хорошего отдыха!' );
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
                        if (Yii::$app->user->identity->status == User::STATUS_FIX) {													// вывод сообщения о успехе, если заяка уже зафиксирована
                         Yii::$app->session->setFlash('success', 'Ваша заявка на отпуск  была зафиксирована. Хорошего отдыха!' );
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
       
    public function actionRequest(){
            
            if(\Yii::$app->user->can('leaving'))
                {
                    return $this->goHome();
                }
            $model = new RequestForm();
            
            if ($model->load(Yii::$app->request->post()) && $model->request()) {
    
                 Yii::$app->session->setFlash('info','Ваша заявка принята в обработку...');
          
                return $this->goHome();
            }


        return $this->render('request', [
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
    /*
        Action фиксирования заявки руководителем
    */
   public function actionUpdate($id)
    {   /*
            Находим пользователя и заявку
            Устанавливаем ему статус зафиксированного пользователя
            Меняем роль пользователя на leaving
        */
            $leave = Leave::findIdentity($id);
            $user = User::findIdentity($leave->user_id);
            $leave->fixied = 1;
            $user->status = User::STATUS_FIX;
            $user->save();
            $leave->save();

             $role = Yii::$app->authManager->getRole('leaving');
             Yii::$app->authManager->assign($role, $leave->user_id);

   //         Yii::$app->session->setFlash('success', 'Заявка на отпуск по сотруднику ' . $user->first_name . '  ' . $user->last_name  . '  с  ' .  $user->date_start . '  по  ' . $user->date_finish . '  зафиксирована');
            return $this->goBack();
       
   }


    /*
        Action основной страницы с gridView
    */

     public function actionIndex()
    {
        
        $searchModel = new LeaveSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        if (Yii::$app->user->identity->role == '1') {
               return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
        }
        return $this->render('leavingList', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionLogout()
    {   
        Yii::$app->user->logout();

        return $this->goHome();
    }



    // public function actionRole(){
    //     //         $role = Yii::$app->authManager->createRole('boss');
    //     // $role->description = 'Руководитель';
    //     // Yii::$app->authManager->add($role);
         
    //     // $user = Yii::$app->authManager->createRole('employee');
    //     // $user->description = 'Сотрудник';
    //     // Yii::$app->authManager->add($user);
        
    //     $fix = Yii::$app->authManager->createRole('leaving');
    //     $fix->description = 'Зафиксированный сотрудник';
    //     Yii::$app->authManager->add($fix);
     
    //     echo 21354;
                
    //         }

}



    
