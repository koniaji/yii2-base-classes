<?php
/**
 * Created by PhpStorm.
 * User: zvinger
 * Date: 30.04.18
 * Time: 18:05
 */

namespace Zvinger\BaseClasses\app\components\database\repository;


use app\components\database\repository\miniFund\shareInfo\MiniFundShareInfoFilter;
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
            $fillCallBack = function ($object) use ($fillCallBack) {
                return $fillCallBack->fillApiModelFromObject($object);
            };
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
            return $fillCallBack->fillApiModelFromObject($this->getObject($id));
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

    /**
     * @param MiniFundShareInfoFilter $filter
     * @return ActiveQuery
     */
    protected function getQuery($filter): ActiveQuery
    {
        $query = static::$className::find();

        return $query;
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

    protected function fillSimpleModel($from, $to, $keys = [])
    {
        if (is_string($to)) {
            $to = new $to();
        }
        foreach ($from as $key => $value) {
            if (empty($keys) || in_array($key, $keys)) {
                $to->{$key} = $value;
            }
        }

        return $to;
    }

    protected function fillSimpleModelsArray($from, $to, $keys = [])
    {
        $result = [];
        foreach ($from as $item) {
            $result[] = $this->fillSimpleModel($item, $to, $keys);
        }

        return $result;
    }

    /**
     * @param $saveModel
     * @param $object_id
     * @param ApiRepositoryInterface $apiRepository
     * @return mixed
     * @throws ModelValidateException
     */
    public function updateApiObject($saveModel, $object_id, ApiRepositoryInterface $apiRepository)
    {
        $this->saveObject($apiRepository->fillObjectFromApiModel($this->getObject($object_id), $saveModel));

        return $apiRepository->fillApiModelFromObject($this->getObject($object_id, TRUE));
    }

    /**
     * @param $saveModel
     * @param ApiRepositoryInterface $apiRepository
     * @return mixed
     * @throws ModelValidateException
     */
    public function createApiObject($saveModel, ApiRepositoryInterface $apiRepository)
    {
        /** @var ActiveRecord $object */
        $object = $apiRepository->fillObjectFromApiModel($this->createObject(), $saveModel);
        $this->saveObject($object);

        return $apiRepository->fillApiModelFromObject($this->getObject($object->id));
    }

    protected function createObject()
    {
        return new static::$className;
    }

    /**
     * @param ActiveRecord $object
     * @throws ModelValidateException
     */
    protected function saveObject(ActiveRecord $object)
    {
        if (!$object->save()) {
            throw new ModelValidateException($object);
        }
    }


}