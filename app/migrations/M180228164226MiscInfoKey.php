<?php

namespace Zvinger\BaseClasses\app\migrations;

use yii\db\Migration;

/**
 * Class M180228164226MiscInfoKey
 */
class M180228164226MiscInfoKey extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createIndex('data_misc_info_object_type_key_index', '{{%data_misc_info}}', ['object_type', 'key']);
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        echo "M180228164226MiscInfoKey cannot be reverted.\n";

        return FALSE;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "M180228164226MiscInfoKey cannot be reverted.\n";

        return false;
    }
    */
}
