<?php

namespace Zvinger\BaseClasses\app\migrations;

use yii\db\Migration;

/**
 * Class M171220072315User
 */
class M171220072315User extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $tableOptions = NULL;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $tableName = '{{%user}}';
        $this->createTable($tableName, [
            'id'            => $this->primaryKey(),
            'username'      => $this->string(32),
            'email'         => $this->string(255),
            'password_hash' => $this->string(255),
            'status'        => $this->integer(),
            'created_at'    => $this->integer(),
            'updated_at'    => $this->integer(),
            'logged_at'     => $this->integer(),
        ], $tableOptions);
        $this->createIndex('INDEX_USER_USERNAME', $tableName, 'username', TRUE);
        $this->createIndex('INDEX_USER_EMAIL', $tableName, 'email', TRUE);

        $tableName = '{{%user_bearer_token}}';
        $this->createTable($tableName, [
            'id'         => $this->primaryKey(),
            'user_id'    => $this->integer(),
            'token'      => $this->string(255),
            'status'     => $this->integer(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ], $tableOptions);
        $this->createIndex('INDEX_user_bearer_token_token', $tableName, 'token', TRUE);
        $this->addForeignKey('FK_user_bearer_token_user_id', $tableName, 'user_id', '{{%user}}', 'id', 'cascade', 'cascade');
        $this->createIndex("INDEX_user_bearer_token_status", $tableName, 'status');
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        echo "M171220072315User cannot be reverted.\n";

        return FALSE;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "M171220072315User cannot be reverted.\n";

        return false;
    }
    */
}
