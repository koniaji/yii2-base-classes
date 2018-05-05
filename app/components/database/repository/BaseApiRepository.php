<?php
/**
 * Created by PhpStorm.
 * User: zvinger
 * Date: 05.05.18
 * Time: 14:43
 */

namespace Zvinger\BaseClasses\app\components\database\repository;


abstract class BaseApiRepository implements ApiRepositoryInterface
{
    /**
     * @var BaseRepository
     */
    protected $repository;

    public function setRepository(BaseRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param $id
     * @param $request
     * @return \yii\db\ActiveRecord
     */
    public function updateModel($id, $request)
    {
        return $this->repository->updateApiObject($request, $id, $this);
    }

    public function getModel($id)
    {
        return $this->repository->getApiModel($id, $this);
    }

    /**
     * @param null $filter
     * @return array
     */
    public function getModelsList($filter = NULL)
    {
        return $this->repository->getApiModels($this);
    }

    /**
     * @param $request
     * @return mixed
     * @throws \Zvinger\BaseClasses\app\exceptions\model\ModelValidateException
     */
    public function createModel($request)
    {
        return $this->repository->createApiObject($request, $this);
    }

}