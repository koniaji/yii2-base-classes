<?php

namespace Zvinger\BaseClasses\app\migrations;

use yii\db\Migration;

/**
 * Class M171228091022UserMiscInfo
 */
class M171228091022UserMiscInfo extends Migration
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
        $tableName = '{{%user_misc_info}}';
        $this->createTable($tableName, [
            'id'      => $this->primaryKey(),
            'user_id' => $this->integer(11),
            'key'     => $this->string(100),
            'value'   => $this->text(),

            'json'       => $this->integer() . ' default 0',
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ], $tableOptions);
        $this->createIndex("INDEX_user_misc_info_user_id", $tableName, 'user_id');
        $this->createIndex('INDEX_user_misc_info_user_id_key', $tableName, ['user_id', 'key'], TRUE);
        $this->addForeignKey('FK_user_misc_info_user_id', $tableName, 'user_id', '{{%user}}', 'id', 'cascade', 'cascade');
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        echo "M171228091022UserMiscInfo cannot be reverted.\n";

        return FALSE;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "M171228091022UserMiscInfo cannot be reverted.\n";

        return false;
    }
    */
}
