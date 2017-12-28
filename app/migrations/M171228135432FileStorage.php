<?php

namespace Zvinger\BaseClasses\app\migrations;

use yii\db\Migration;

/**
 * Class M171228135432FileStorage
 */
class M171228135432FileStorage extends Migration
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
        $tableName = '{{%file_storage_element}}';
        $this->createTable($tableName, [
            'id'        => $this->primaryKey(),
            'component' => $this->string(32),
            'type'      => $this->string(100),
            'path'      => $this->string(500),
            'info'      => $this->text(),

            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ], $tableOptions);
        $this->createIndex("INDEX_file_storage_element_component", $tableName, 'component');
        $this->createIndex("INDEX_file_storage_element_type", $tableName, 'type');
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        echo "M171228135432FileStorage cannot be reverted.\n";

        return FALSE;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "M171228135432FileStorage cannot be reverted.\n";

        return false;
    }
    */
}
