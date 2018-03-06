<?php

namespace Zvinger\BaseClasses\app\components\data\miscInfo\models;

use yii\db\Query;

/**
 * This is the ActiveQuery class for [[UserMiscInfoObject]].
 *
 * @see BaseVendorMiscInfoObject
 */
class BaseVendorUserMiscInfoQuery extends \yii\db\ActiveQuery
{
    /** @var SingleMiscInfoFilter[] */
    private $miscDataFilter = [];

    public function addMiscDataFilter($key, $filter)
    {
        if (is_scalar($filter)) {
            $filter = ['=', 'value', $filter];
        }

        $this->miscDataFilter[] = new SingleMiscInfoFilter($key, $filter);
    }

    public function byKey($key)
    {
        return $this->andWhere(['key' => $key]);
    }

    public function byObject($object_id)
    {
        return $this->andWhere(['object_id' => $object_id]);
    }

    public function byType($type)
    {
        return $this->andWhere(['object_type' => $type]);
    }

    /**
     * @inheritdoc
     * @return BaseVendorMiscInfoObject[]|array
     */
    public function all($db = NULL)
    {
        $this->handleMiscDataFilter();

        return parent::all($db);
    }

    protected function handleMiscDataFilter()
    {
        if ($this->miscDataFilter) {
            $objectIds = $this->getCurrentFilterObjectIds();
            $this->andWhere(['object_id' => $objectIds]);
        }
    }


    /**
     * @inheritdoc
     * @return BaseVendorMiscInfoObject|array|null
     */
    public function one($db = NULL)
    {
        $this->handleMiscDataFilter();

        return parent::one($db);
    }

    /**
     * @return false|null|string
     */
    protected function getCurrentFilterObjectIds()
    {
        if (empty($this->miscDataFilter)) {
            return;
        }
        $data = $this->miscDataFilter;
        $keys = [];
        foreach ($data as $datum) {
            $keys[] = $datum->key;
        }
        $keys = array_unique($keys);
        $query = new static($this->modelClass);
        $query
            ->select(['object_id', 'val' => 'count(`value`)'])
            ->where([
                'and',
                ['object_type' => 'user'], //todo заменить
                ['key' => $keys],
            ])
            ->groupBy(['object_id', 'key', 'value']);
        $havingCondition = ['or'];
        foreach ($data as $value) {
            if (is_bool($value)) {
                $value = intval($value);
            }
            $key = $value->key;
            $havingCondition[] = ['and', ['key' => $key], $value->filter];
        }
        $query->having($havingCondition);
        $queryIds = new Query();
        $queryIds->from(['filter' => $query])
            ->select(['object_id'])
            ->groupBy(['object_id'])
            ->having(['count(val)' => count($keys)]);
        $objectIds = $queryIds->all();

        return $objectIds;
    }
}
