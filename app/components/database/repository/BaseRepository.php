<?php
/**
 * Created by PhpStorm.
 * User: zvinger
 * Date: 30.04.18
 * Time: 18:05
 */

namespace Zvinger\BaseClasses\app\components\database\repository;


use yii\data\ActiveDataProvider;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use Zvinger\BaseClasses\app\exceptions\model\ModelValidateException;

abstract class BaseRepository
{
    /**
     * @var ActiveRecord
     */
    protected static $className;

    /**
     * @param callable|ApiRepositoryInterface $fillCallBack
     * @param $filter
     * @return array
     */
    public function getApiModels($fillCallBack, $filter = NULL): array
    {
        if ($fillCallBack instanceof ApiRepositoryInterface) {
            $fillCallBack = $fillCallBack->getFillModelCallback();
        }

        return $this->fillResultModels(
            $this->getRepositoryObjects($filter),
            $fillCallBack
        );
    }

    /**
     * @param $id
     * @param callable|array|ApiRepositoryInterface $fillCallBack
     * @return mixed
     */
    public function getApiModel($id, $fillCallBack)
    {
        if ($fillCallBack instanceof ApiRepositoryInterface) {
            $fillCallBack = $fillCallBack->getFillModelCallback();
        }

        return $this->fillResultModel($this->getObject($id), $fillCallBack);
    }

    /**
     * @param $id
     * @param bool $eager
     * @return ActiveRecord
     */
    public function getObject($id, $eager = FALSE)
    {
        if ($eager) {
            unset($this->_objects[$id]);
        }
        if (empty($this->_objects[$id])) {
            $this->_objects[$id] = static::$className::findOne($id);
        }

        return $this->_objects[$id];
    }


    protected $_objects = [];

    public function getRepositoryObjects($filter = NULL)
    {
        return $this->getQuery($filter)->all();
    }

    protected function getQuery($filter): ActiveQuery
    {
        return static::$className::find();
    }

    /**
     * @param $filter
     * @return ActiveDataProvider
     */
    public function getDataProvider($filter = NULL)
    {
        $dataProvider = new ActiveDataProvider();
        $dataProvider->query = $this->getQuery($filter);

        return $dataProvider;
    }

    /**
     * @param array $repositoryObjects
     * @param callable $callBack
     * @return array
     */
    protected function fillResultModels($repositoryObjects = [], $callBack)
    {
        $result = [];
        foreach ($repositoryObjects as $repositoryObject) {
            $result[] = $this->fillResultModel($repositoryObject, $callBack);
        }

        return $result;
    }

    protected function fillResultModel($repositoryObject, $callBack)
    {
        return $callBack($repositoryObject);
    }

    public function updateApiObject($saveModel, $object_id, ApiRepositoryInterface $apiRepository)
    {
        $fillObjectCallback = $apiRepository->getFillObjectCallback();
        $fillObjectCallback($this->getObject($object_id), $saveModel);
        $fillModelCallback = $apiRepository->getFillModelCallback();

        return $this->fillResultModel($this->getObject($object_id, TRUE), $fillModelCallback);
    }

    /**
     * @param $saveModel
     * @param ApiRepositoryInterface $apiRepository
     * @return mixed
     * @throws ModelValidateException
     */
    public function createApiObject($saveModel, ApiRepositoryInterface $apiRepository)
    {
        $fillObjectCallback = $apiRepository->getFillObjectCallback();
        /** @var ActiveRecord $object */
        $object = $fillObjectCallback($this->createObject(), $saveModel);
        if (!$object->save()) {
            throw new ModelValidateException($object);
        }

        return $this->getApiModel($object->id, $apiRepository->getFillModelCallback());
    }

    protected function createObject()
    {
        return new static::$className;
    }
}