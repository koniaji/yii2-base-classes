<?php
/**
 * Created by PhpStorm.
 * User: zvinger
 * Date: 28.12.17
 * Time: 12:01
 */

namespace Zvinger\BaseClasses\app\components\data\miscInfo;

use yii\base\BaseObject;
use yii\base\InvalidCallException;
use yii\base\UnknownPropertyException;
use yii\helpers\Json;
use Zvinger\BaseClasses\app\components\data\miscInfo\models\BaseVendorMiscInfoObject;
use Zvinger\BaseClasses\app\exceptions\model\ModelValidateException;

/**
 * Class VendorUserMiscInfoService
 * @package Zvinger\BaseClasses\app\components\user\info
 *
 * @property mixed misc_data
 */
class VendorUserMiscInfoService extends BaseObject
{
    public $defaultFieldValues = [];

    private $_object_id;

    protected $_object_type;

    /**
     * UserMiscInfoService constructor.
     * @param $object_id
     * @param $object_type
     * @param array $params
     */
    public function __construct($object_id, $object_type = NULL, $params = [])
    {
        if ($object_type === NULL && empty($this->_object_type)) {
            throw new \InvalidArgumentException("No object type given");
        }
        if (!empty($object_type)) {
            $this->_object_type = $object_type;
        }
        $this->_object_id = $object_id;
        parent::__construct($params);
    }


    /**
     * @param string $name
     * @return bool|mixed
     * @throws UnknownPropertyException
     */
    public function __get($name)
    {
        $value = $this->getObjectDataByKey($name);
        if ($value === FALSE) {
            try {
                $value = parent::__get($name);
            } catch (UnknownPropertyException $e) {
                if (key_exists($name, $this->defaultFieldValues)) {
                    $value = $this->defaultFieldValues[$name];
                } else {
                    throw $e;
                }
            }
        }

        return $value;
    }

    /**
     * @param string $name
     * @param mixed $value
     * @throws ModelValidateException
     */
    public function __set($name, $value)
    {
        try {
            parent::__set($name, $value);
        } catch (UnknownPropertyException $e) {
            $this->setObjectDataByKey($name, $value);
        } catch (InvalidCallException $e) {
            $this->setObjectDataByKey($name, $value);
        }
    }

    protected function getObjectDataByKey($key)
    {
        $object = $this->getCurrentInfoObject($key);
        if (empty($object)) {
            return FALSE;
        }
        if ($object->json) {
            $result = Json::decode($object->value);
        } else {
            $result = $object->value;
        }

        return $result;
    }

    /**
     * @param $key
     * @param $value
     * @throws ModelValidateException
     */
    private function setObjectDataByKey($key, $value)
    {
        $object = $this->getCurrentInfoObject($key);
        if (empty($object)) {
            $object = new BaseVendorMiscInfoObject([
                'object_id'   => $this->_object_id,
                'object_type' => $this->_object_type,
                'key'         => $key,
            ]);
        }
        $object->json = FALSE;
        if (!is_scalar($value)) {
            $value = Json::encode($value);
            $object->json = TRUE;
        }
        $object->value = (string)$value;
        $result = $object->save();
        if (!$result) {
            throw new ModelValidateException($object);
        }
    }

    /**
     * @param $data
     * @throws ModelValidateException
     */
    public function multiSet($data)
    {
        foreach ($data as $key => $value) {
            $this->__set($key, $value);
        }
    }

    /**
     * @param $key
     * @return BaseVendorMiscInfoObject
     */
    private function getCurrentInfoObject($key)
    {
        $object = BaseVendorMiscInfoObject::find()
            ->byObject($this->_object_id)
            ->byType($this->_object_type)
            ->byKey($key)
            ->one();

        return $object;
    }

    /**
     * @param $key
     * @param null $default
     * @return bool|mixed|null
     * @deprecated use $defaultFieldValues for default values
     */
    public function getNoCheck($key, $default = NULL)
    {
        try {
            $value = $this->{$key};
        } catch (UnknownPropertyException $e) {
            $value = $default;
        }

        return $value;
    }
}