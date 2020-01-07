<?php

use yii\db\Migration;

class m130524_201442_leave extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%leave}}', [
            'id'               => $this->primaryKey(),
            'user_id'          => $this->integer()->notNull(),
            'user_first_name'  => $this->string()->notNull(),
            'user_last_name'   => $this->string()->notNull(),
            'date_start'       => $this->string()->notNull(),
            'date_finish'      => $this->string()->notNull(),
            'fixied'           => $this->boolean()->notNull()->defaultValue(0)

        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%leave}}');
    }
}
