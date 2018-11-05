<?php

namespace Zvinger\BaseClasses\app\migrations;

use yii\db\Migration;

/**
 * Class M171229082027BaseMiscInfo
 */
class M171229082027BaseMiscInfo extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $oldTableName = '{{%user_misc_info}}';
        $this->dropIndex('INDEX_user_misc_info_user_id', $oldTableName);
        $this->dropForeignKey('FK_user_misc_info_user_id', $oldTableName);
        $this->dropIndex('INDEX_user_misc_info_user_id_key', $oldTableName);
        $this->renameColumn($oldTableName, 'user_id', 'object_id');
        $newTableName = '{{%data_misc_info}}';
        $this->renameTable($oldTableName, $newTableName);
        $this->addColumn($newTableName, 'object_type', 'varchar(255)');
        $this->createIndex('INDEX_user_misc_info_user_id', $newTableName, ['object_type', 'object_id', 'key']);
        $this->alterColumn($newTableName, 'object_type', 'varchar(100) after id');
        $this->update($newTableName, ['object_type' => 'user']);
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        echo "M171229082027BaseMiscInfo cannot be reverted.\n";

        return FALSE;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "M171229082027BaseMiscInfo cannot be reverted.\n";

        return false;
    }
    */
}
