<?php
/**
 * Created by PhpStorm.
 * User: zvinger
 * Date: 22.12.17
 * Time: 11:46
 */

namespace Zvinger\BaseClasses\app\helpers\gii;

use Zvinger\Auth\Mobsolutions\models\user\token\UserMobsolutionTokenObject;
use Zvinger\BaseClasses\app\models\work\user\object\VendorUserObject;
use Zvinger\BaseClasses\app\models\work\user\token\bearer\UserBearerTokenObject;

class ModelsGeneratorActions
{
    public static $globalNameSpaces = [
        'user'              => VendorUserObject::class,
        'user_bearer_token' => UserBearerTokenObject::class,
        'user_mobsol_token' => UserMobsolutionTokenObject::class,
    ];

    public static function generateUserModels()
    {
        $nameSpaces = static::$globalNameSpaces;
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
        \Yii::$app->runAction('gii/model', [
            'tableName'         => 'user_activation',
            'modelClass'        => 'DBUserActivationObject',
            'ns'                => 'Zvinger\BaseClasses\app\models\db\user\activation',
            'generateRelations' => 'none',
            'tablesNamespaces'  => $nameSpaces,
        ]);
    }
}