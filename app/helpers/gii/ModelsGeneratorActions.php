<?php
/**
 * Created by PhpStorm.
 * User: zvinger
 * Date: 22.12.17
 * Time: 11:46
 */

namespace Zvinger\BaseClasses\app\helpers\gii;

class ModelsGeneratorActions
{
    public static function generateUserModels()
    {
        $nameSpaces = [
            'user'              => \Zvinger\BaseClasses\app\models\work\user\object\VendorUserObject::class,
            'user_bearer_token' => \Zvinger\BaseClasses\app\models\work\user\token\bearer\UserBearerTokenObject::class,
            'user_mobsol_token' => \Zvinger\Auth\Mobsolutions\models\user\token\UserMobsolutionTokenObject::class,
        ];
        \Yii::$app->runAction('gii/model', [
            'tableName'         => 'user',
            'modelClass'        => 'DBUserObject',
            'ns'                => 'Zvinger\BaseClasses\app\models\db\user\object',
            'generateRelations' => 'none',
            'tablesNamespaces'  => $nameSpaces,
        ]);
        \Yii::$app->runAction('gii/model', [
            'tableName'         => 'user_bearer_token',
            'modelClass'        => 'DBUserBearerTokenObject',
            'ns'                => 'Zvinger\BaseClasses\app\models\db\user\token\bearer',
            'generateRelations' => 'none',
            'tablesNamespaces'  => $nameSpaces,
        ]);
    }
}