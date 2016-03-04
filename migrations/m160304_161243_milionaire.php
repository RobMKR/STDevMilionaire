<?php

use yii\db\Migration;

class m160304_161243_milionaire extends Migration
{
    public function up()
    {

      $this->createTable('users', [
           'id' => Schema::TYPE_PK,
           'username' => Schema::TYPE_STRING . ' NOT NULL',
           'password' => Schema::TYPE_STRING . ' NOT NULL',
           'role' => Schema::TYPE_INT . ' NULL'
       ]);

       $this->createTable('questions', [
            'id' => Schema::TYPE_PK,
            'question' => Schema::TYPE_STRING . ' NOT NULL',
            'true_answers' => Schema::TYPE_STRING . ' NOT NULL',
            'false_answers' => Schema::TYPE_STRING . ' NOT NULL',
            'points' => Schema::TYPE_INT . ' NOT NULL'
        ]);

        $this->createTable('highscores', [
             'id' => Schema::TYPE_PK,
             'user' => Schema::TYPE_STRING . ' NOT NULL',
             'points' => Schema::TYPE_INT . ' NOT NULL',
             'timestamp' => Schema::TYPE_INT . ' NOT NULL'
         ]);
    }

    public function down()
    {
        echo "m160304_161243_milionaire cannot be reverted.\n";

        return false;
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
