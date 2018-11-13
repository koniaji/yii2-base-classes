<?php
/**
 * Created by PhpStorm.
 * User: zvinger
 * Date: 20.08.18
 * Time: 18:48
 */

namespace Zvinger\BaseClasses\app\components\data\filterInfo\models;


use yii\base\BaseObject;
use Zvinger\BaseClasses\app\components\data\filterInfo\VendorFilterInfoService;
use Zvinger\BaseClasses\app\exceptions\model\ModelValidateException;

abstract class BaseFilterElement extends BaseObject
{
    const ARRAY = 'array';
    const NUMBER = 'number';
    const TEXT = 'text';

    protected static $type;

    /**
     * Устанавливаемые значения
     * @var mixed
     */
    public $value;

    /**
     * Является ли эта информация ссылочной - или это просто raw value
     * @var bool
     */
    public $isDictionary = false;

    /**
     * Является ли это массивом, который нужно сохранить с возможностью фильтрации по элементам
     * @var bool
     */
    public $isMultiple = false;

    /**
     * Если стоит true, то перед занесением все другое будет стираться. Иначе - добавление
     * @var bool
     */
    public $clearBefore = true;

    public function isScalar()
    {
        return in_array(static::$type, [self::NUMBER, self::TEXT]);
    }

    public function isArray()
    {
        return static::$type == self::ARRAY;
    }


    public function beforeSet($key, VendorFilterInfoService $service)
    {

    }

    public function afterSet($key, VendorFilterInfoService $service, $result)
    {
        return $result;
    }

    public function setElementValue($key, VendorFilterInfoService $service)
    {
        $this->beforeSet($key, $service);
        if ($this->clearBefore) {
            DBFilterMiscInfo::deleteAll([
                    'key'         => $key,
                    'object_id'   => $service->getObjectId(),
                    'object_type' => $service->getObjectType(),
                ]
            );
        }
        $result = null;
        if (!$this->isMultiple) {
            $result = $this->setSingleElement($key, $service);
        } else {
            $result = $this->setMultipleElement($key, $service);
        }
        $result = $this->afterSet($key, $service, $result);

        return $result;
    }

    /**
     * @param $key
     * @param VendorFilterInfoService $service
     * @return int
     * @throws ModelValidateException
     */
    protected function setSingleElement($key, VendorFilterInfoService $service): int
    {
        $object = new DBFilterMiscInfo([
            'key'         => $key,
            'object_id'   => $service->getObjectId(),
            'object_type' => $service->getObjectType(),
        ]);
        if ($this->isDictionary) {
            $object->value_id = $this->value;
        } else {
            $object->value_data = $this->value;
        }
        if (!$object->save()) {
            throw new ModelValidateException($object);
        }

        return $object->id;
    }

    /**
     * @param $key
     * @param VendorFilterInfoService $service
     * @return int
     * @throws ModelValidateException
     */
    protected function setMultipleElement($key, VendorFilterInfoService $service): array
    {
        $result = [];
        foreach ($this->value as $item) {
            $object = new DBFilterMiscInfo([
                'key'         => $key,
                'object_id'   => $service->getObjectId(),
                'object_type' => $service->getObjectType(),
            ]);
            if ($this->isDictionary) {
                $object->value_id = $item;
            } else {
                $object->value_data = $item;
            }
            if (!$object->save()) {
                throw new ModelValidateException($object);
            }
            $result[] = $object->id;
        }

        return $result;
    }
}