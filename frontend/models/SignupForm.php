<?php
namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\User;
use yii\behaviors\TimestampBehavior;
/*
 
  Signup newt_form()
   Модель для регистрации
 */
class SignupForm extends Model
{
    public $last_name;
    public $first_name;
    public $username;
    public $role;
    public $password;


    public function rules() {
                return [
                        [['username', 'password','role','first_name','last_name' ], 'required', 'message' => 'Заполните поле'],
                        ['username', 'unique', 'targetClass' => User::className(),  'message' => 'Этот логин уже занят'],
                    ];
    }
    
    public function attributeLabels() {
        return [
            'first_name' => 'Имя',
            'last_name'  => 'Фамилия',
            'username'   => 'Логин',
            'password'   => 'Пароль',
            'role'       => 'Должность',
        ];
    }
        /*
            setRole принимает в аргументы id сотрудника и role, указанную  сотрудником при регистрации
            Выполнияется установка ролей пользователя через authManager
            Метод ничего не возвращает
        */
    private function setRole($params, $id){

        switch ($params) {
            case '1':
               $role = Yii::$app->authManager->getRole('boss');
               Yii::$app->authManager->assign($role, $id);
                break;
            
            default:
                $role = Yii::$app->authManager->getRole('employee');
                Yii::$app->authManager->assign($role, $id);
                break;
        }
    }


    public function signup() {

        if (!$this->validate()) {
            return null;
        }
        //создаем новую запись в таблице user
        $user = new User(); 
                                    
        $user->last_name  = $this->last_name;
        $user->first_name = $this->first_name;
        $user->username   = $this->username;
        $user->setPassword($this->password);
        $user->role       = $this->role;
        $user->status     = User::STATUS_NONE;
        
         //сохранение пользователя
         if ($user->save()) {    
              // Инициализируем установку роли для пользователя                  
          $this->setRole($this->role , $user->id); 
       }                                            
        return $user;   

    }


  
}
    



