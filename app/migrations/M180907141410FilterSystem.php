<?php

namespace Zvinger\BaseClasses\app\migrations;

use yii\db\Migration;

/**
 * Class M180820145703FilterSystem
 */
class M180907141410FilterSystem extends Migration
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

        $this->createTable('{{%filter_misc_info}}', [
            'id'          => $this->primaryKey(),
            'object_type' => $this->string(),
            'object_id'   => $this->integer(),
            'key'         => $this->string(),
            'value_id'    => $this->integer(),
            'value_data'  => $this->string(),
        ], $tableOptions);

        $this->createTable('{{%dictionary_info}}', [
            'id'          => $this->primaryKey(),
            'parent_id'   => $this->integer(),
            'title'       => $this->string(),
            'description' => $this->text(),
            'sort'        => $this->integer(),
            'created_at'  => $this->integer(),
            'updated_at'  => $this->integer(),
            'created_by'  => $this->integer(),
            'updated_by'  => $this->integer(),
        ], $tableOptions);

        $this->createIndex('INDEX-filter_misc_info-object_type-object_id-key', '{{%filter_misc_info}}', ['object_type', 'object_id', 'key']);
        $this->addForeignKey('FK-dictionary_info-parent_id', '{{%dictionary_info}}', 'parent_id', '{{%dictionary_info}}', 'id', 'cascade', 'cascade');
        $this->addForeignKey('FK-filter_misc_info-value_id', '{{%filter_misc_info}}', 'value_id', '{{%dictionary_info}}', 'id', 'cascade', 'cascade');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('FK-dictionary_info-parent_id', '{{%dictionary_info}}');
        $this->dropForeignKey('FK-filter_misc_info-value_id', '{{%filter_misc_info}}');
        $this->dropTable('{{%dictionary_info}}');
        $this->dropTable('{{%filter_misc_info}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "M180820145703FilterSystem cannot be reverted.\n";

        return false;
    }
    */
}
