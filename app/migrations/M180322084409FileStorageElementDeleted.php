<?php

namespace Zvinger\BaseClasses\app\migrations;

use yii\db\Migration;

/**
 * Class M180322084409FileStorageElementDeleted
 */
class M180322084409FileStorageElementDeleted extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%file_storage_element}}', 'deleted', 'tinyint');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "M180322084409FileStorageElementDeleted cannot be reverted.\n";

        return FALSE;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "M180322084409FileStorageElementDeleted cannot be reverted.\n";

        return false;
    }
    */
}
