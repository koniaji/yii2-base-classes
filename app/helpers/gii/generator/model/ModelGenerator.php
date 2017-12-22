<?php
/**
 * Created by PhpStorm.
 * User: zvinger
 * Date: 20.12.17
 * Time: 18:42
 */

namespace Zvinger\BaseClasses\app\helpers\gii\generator\model;

use yii\gii\generators\model\Generator;

class ModelGenerator extends Generator
{
    public $tablesNamespaces = [];

    public $templates = [];

    public function init()
    {
        $this->templates['default'] = \Yii::getAlias("@yii/gii/generators/model/default");
        parent::init();
    }


    protected function generateClassName($tableName, $useSchemaName = NULL)
    {
        if (!empty($this->tablesNamespaces[$tableName])) {
            if ($this->tableName !== $tableName) {
                return '\\' . $this->tablesNamespaces[$tableName];
            }
        }

        return parent::generateClassName($tableName, $useSchemaName); // TODO: Change the autogenerated stub
    }
}