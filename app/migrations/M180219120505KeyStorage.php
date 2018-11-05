<?php

namespace Zvinger\BaseClasses\app\migrations;

use yii\db\Migration;

/**
 * Class M180219120505KeyStorage
 */
class M180219120505KeyStorage extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci';
        }

        $this->createTable('{{%key_storage_item}}', [
            'key' => $this->string(128)->notNull(),
            'value' => $this->text()->notNull(),
            'comment' => $this->text(),
            'updated_at'=>$this->integer(),
            'created_at'=>$this->integer()
        ], $tableOptions);

        $this->addPrimaryKey('pk_key_storage_item_key', '{{%key_storage_item}}', 'key');
        $this->createIndex('idx_key_storage_item_key', '{{%key_storage_item}}', 'key', true);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%key_storage_item}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "M180219120505KeyStorage cannot be reverted.\n";

        return false;
    }
    */
}
