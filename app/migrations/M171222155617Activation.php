<?php

namespace Zvinger\BaseClasses\app\migrations;

use yii\db\Migration;

/**
 * Class M171222155617Activation
 */
class M171222155617Activation extends Migration
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

        $this->createTable('{{user_activation}}', [
            'id'              => $this->primaryKey(),
            'user_id'         => $this->integer(),
            'activation_type' => $this->string(32),
            'activation_hash' => $this->string(255),
            'active'          => $this->integer(),
        ], $tableOptions);
        $this->addForeignKey("FK_USER_ACTIVATION_USER_ID", '{{user_activation}}', 'user_id', '{{%user}}', 'id', 'cascade', 'cascade');
        $this->createIndex('INDEX_USER_ACTIVATION_USER_ID_TYPE', '{{user_activation}}', ['user_id',
            'activation_type'], TRUE);
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        echo "M171222155617Activation cannot be reverted.\n";

        return FALSE;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "M171222155617Activation cannot be reverted.\n";

        return false;
    }
    */
}
