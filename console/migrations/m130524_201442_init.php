<?php

use yii\db\Migration;

class m130524_201442_init extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%user}}', [
            'id'          => $this->primaryKey(),
            'username'    => $this->string()->notNull()->unique(),
            'password'    => $this->string()->notNull(),
            'first_name'  => $this->string()->notNull(),
            'last_name'   => $this->string()->notNull(),
            'role'        => $this->string()->notNull()->defaultValue('user'),
            'date_start'  => $this->string(),
            'date_finish' => $this->string(),
            'fixied'      => $this->boolean()->notNull()->defaultValue(0)

        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%user}}');
    }
}
