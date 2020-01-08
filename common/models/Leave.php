<?php
namespace common\models;


use yii\db\ActiveRecord;
    
    /*
        Модель работы  с таблицей 'leave'  
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
class Leave extends ActiveRecord 
{
       /**
     * {@inheritdoc}
     */
       public static function tableName()
        {
            return 'leave';
        }

   
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_first_name' => 'Имя',
            'user_last_name' => 'Фамилия',
            'date_start' => 'Дата начала отпуска',
            'date_finish' => 'Дата окончания отпуска',
           'fixied' => 'Fixied',
        ];
    }

    /*
        Метод нахождения заявки по ее id
    */
   
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }
    
    public function getId()
    {
        return $this->id;
    }
   
     /*
        Метод нахождения заявки через id пользователя
        Принимает на вход параметр 'user_id' 
        Возвращает заявку 
    */
    public static function findByUserid($user_id){

        return static::findOne(['user_id' => $user_id /*,'status' => self::STATUS_ACTIVE*/]);
    }

  
}
