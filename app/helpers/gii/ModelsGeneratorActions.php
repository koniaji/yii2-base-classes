<?php
/**
 * Created by PhpStorm.
 * User: zvinger
 * Date: 22.12.17
 * Time: 11:46
 */

namespace Zvinger\BaseClasses\app\helpers\gii;

use Zvinger\Auth\Mobsolutions\models\user\token\UserMobsolutionTokenObject;
use Zvinger\BaseClasses\app\components\data\dictionary\models\DBDictionaryInfo;
use Zvinger\BaseClasses\app\components\data\filterInfo\models\DBFilterMiscInfo;
use Zvinger\BaseClasses\app\models\work\user\object\VendorUserObject;
use Zvinger\BaseClasses\app\models\work\user\token\bearer\UserBearerTokenObject;

class ModelsGeneratorActions
{
    public static $globalNameSpaces = [
        'user'              => VendorUserObject::class,
        'user_bearer_token' => UserBearerTokenObject::class,
    ];

    public static function generateUserModels()
    {
        $nameSpaces = static::$globalNameSpaces;
        if (class_exists('\Zvinger\Auth\Mobsolutions\models\user\token\UserMobsolutionTokenObject')) {
            $nameSpaces['user_mobsol_token'] = '\Zvinger\Auth\Mobsolutions\models\user\token\UserMobsolutionTokenObject';
        }
        $nameSpaces = array_merge($nameSpaces, [
            'dictionary_info'  => DBDictionaryInfo::class,
            'filter_misc_info' => DBFilterMiscInfo::class,
        ]);
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
        \Yii::$app->runAction('gii/model', [
            'tableName'         => 'dictionary_info',
            'modelClass'        => 'DBDictionaryInfo',
            'ns'                => 'Zvinger\BaseClasses\app\components\data\dictionary\models',
            'generateRelations' => 'none',
            'tablesNamespaces'  => $nameSpaces,
        ]);
        \Yii::$app->runAction('gii/model', [
            'tableName'         => 'filter_misc_info',
            'modelClass'        => 'DBFilterMiscInfo',
            'ns'                => 'Zvinger\BaseClasses\app\components\data\filterInfo\models',
            'generateRelations' => 'none',
            'tablesNamespaces'  => $nameSpaces,
        ]);
    }
}