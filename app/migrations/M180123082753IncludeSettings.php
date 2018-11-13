<?php

namespace Zvinger\BaseClasses\app\migrations;

use yii\console\controllers\MigrateController;
use yii\db\Migration;

/**
 * Class M180123082753IncludeSettings
 */
class M180123082753IncludeSettings extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $controller = new MigrateController('migrate', \Yii::$app);
        $controller->run('up', [
            'migrationPath'       => '@vendor' . DIRECTORY_SEPARATOR . 'yii2mod' . DIRECTORY_SEPARATOR . 'yii2-settings' . DIRECTORY_SEPARATOR . 'migrations',
            'interactive'         => 0,
        ]);
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        echo "M180123082753IncludeSettings cannot be reverted.\n";

        return FALSE;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "M180123082753IncludeSettings cannot be reverted.\n";

        return false;
    }
    */
}
