<?php
/**
 * Created by PhpStorm.
 * User: zvinger
 * Date: 30.04.18
 * Time: 18:05
 */

namespace Zvinger\BaseClasses\app\components\database\repository;


use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

abstract class BaseRepository
{
    /**
     * @var ActiveRecord
     */
    protected static $className;

    /**
     * @param callable $fillCallBack
     * @param $filter
     * @return array
     */
    protected function getApiModels(callable $fillCallBack, $filter = NULL): array
    {
        return $this->fillResultModels(
            $this->getRepositoryObjects($filter),
            $fillCallBack
        );
    }

    /**
     * @param $id
     * @return ActiveRecord
     */
    public function getObject($id)
    {
        if (empty($this->_objects[$id])) {
            $this->_objects[$id] = static::$className::findOne($id);
        }

        return $this->_objects[$id];
    }


    protected $_objects = [];

    protected function getRepositoryObjects($filter = NULL)
    {
        return $this->getQuery($filter)->all();
    }

    abstract protected function getQuery($filter): ActiveQuery;

    /**
     * @param array $repositoryObjects
     * @param callable $callBack
     * @return array
     */
    protected function fillResultModels($repositoryObjects = [], callable $callBack)
    {
        $result = [];
        foreach ($repositoryObjects as $repositoryObject) {
            $result[] = $this->fillResultModel($repositoryObject, $callBack);
        }

        return $result;
    }

    protected function fillResultModel($repositoryObject, callable $callBack)
    {
        return $callBack($repositoryObject);
    }
}