<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $username
 * @property string $password
 * @property string $first_name
 * @property string $last_name
 * @property string $role
 * @property string|null $date_start
 * @property string|null $date_finish
 * @property int $fixied
 */
class Usert extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'password', 'first_name', 'last_name'], 'required'],
            [['fixied'], 'integer'],
            [['username', 'password', 'first_name', 'last_name', 'role', 'date_start', 'date_finish'], 'string', 'max' => 255],
            [['username'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'password' => 'Password',
            'first_name' => 'Имя',
            'last_name' => 'Фамилия',
            'role' => 'Role',
            'date_start' => 'Дата начала отпуска',
            'date_finish' => 'Дата окончания отпуска',
            'fixied' => 'Fixied',
        ];
    }
}
