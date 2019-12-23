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
class UserLeaveList extends \yii\db\ActiveRecord
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
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'role' => 'Role',
            'date_start' => 'Date Start',
            'date_finish' => 'Date Finish',
            'fixied' => 'Fixied',
        ];
    }
}
