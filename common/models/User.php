<?php
namespace common\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
    
    /*
      модель работы с таблицей "user"
    */

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $verification_token
 * @property string $auth_key
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 */
class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_NONE = 0;
    const STATUS_WAIT = 1;
    const STATUS_FIX  = 2;

    public static function findIdentity($id)
    {
        return static::findOne($id);
    }
    
    public function getId()
    {
        return $this->id;
    }
    
    public static function 
    findIdentityByAccessToken($token, $type = null)
    {
      
    }
    
    public function getAuthKey()
    {
       
    }
 
    public function validateAuthKey($authKey)
    {
      
    }

    public function getUser()
     {
           if ($this->user === false) {
                $this->user = Users::findOne(['username'=>$this->username, 
                                                'password'=>$this->password]);
           }
                 
          return $this->user;
    }


    public function setPassword($password)
    {
        $this->password = Yii::$app->security->generatePasswordHash($password);
    }
  
           /*
              Метод проверки пароля на соответсвие
              Принимает пароль от пользователя
              Возвращает boolean

            */
    public function validatePassword($password)
    {

        $hash = $this->password;
         
        return Yii::$app->security->validatePassword($password, $hash);
    }

    /*
     Метод поиска записи пользователя с помощью username
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username]);
    }

}
