<?php
namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\User;
use yii\behaviors\TimestampBehavior;
/**
 * Signup form
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
 [['username', 'password','role','first_name','last_name'], 'required', 'message' => 'Заполните поле'],
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

    // public function setPassword($password)
    //     {
    //     $this->password = Yii::$app->security->generatePasswordHash($password);
    //      }

 public function signup()
    {
        if (!$this->validate()) {
            return null;
        }
        
        $user = new User();
        $user->last_name  = $this->last_name;
        $user->first_name = $this->first_name;
        $user->username   = $this->username;
        $user->setPassword($this->password);
        $user->role      = $this->role;

        return $user->save();   

    }

                


    // public function behaviors()
    // {
    //     return [
    //         TimestampBehavior::className(),
    //     ];
    // }
}
    




    /**
     * {@inheritdoc}
//      */
//     public function rules()
//     {
//         return [
//             ['username', 'trim'],
//             ['username', 'required'],
//             ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This username has already been taken.'],
//             ['username', 'string', 'min' => 2, 'max' => 255],

//             ['email', 'trim'],
//             ['email', 'required'],
//             ['email', 'email'],
//             ['email', 'string', 'max' => 255],
//             ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This email address has already been taken.'],

//             ['password', 'required'],
//             ['password', 'string', 'min' => 6],
//         ];
//     }

//     /**
//      * Signs user up.
//      *
//      * @return bool whether the creating new account was successful and email was sent
//      */
//     public function signup()
//     {
//         if (!$this->validate()) {
//             return null;
//         }
        
//         $user = new User();
//         $user->username = $this->username;
//         $user->email = $this->email;
//         $user->setPassword($this->password);
//         $user->generateAuthKey();
//         $user->generateEmailVerificationToken();
//         return $user->save() && $this->sendEmail($user);

//     }

//     /**
//      * Sends confirmation email to user
//      * @param User $user user model to with email should be send
//      * @return bool whether the email was sent
//      */
//     protected function sendEmail($user)
//     {
//         return Yii::$app
//             ->mailer
//             ->compose(
//                 ['html' => 'emailVerify-html', 'text' => 'emailVerify-text'],
//                 ['user' => $user]
//             )
//             ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
//             ->setTo($this->email)
//             ->setSubject('Account registration at ' . Yii::$app->name)
//             ->send();
//     }
// }
