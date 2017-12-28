<?php
/**
 * Created by PhpStorm.
 * User: zvinger
 * Date: 28.12.17
 * Time: 12:01
 */

namespace Zvinger\BaseClasses\app\components\user\info;

use yii\base\BaseObject;
use yii\base\InvalidCallException;
use yii\base\UnknownPropertyException;
use yii\helpers\Json;
use Zvinger\BaseClasses\app\components\user\info\models\UserMiscInfoObject;
use Zvinger\BaseClasses\app\exceptions\model\ModelValidateException;

/**
 * Class VendorUserMiscInfoService
 * @package Zvinger\BaseClasses\app\components\user\info
 *
 * @property mixed misc_data
 */
class VendorUserMiscInfoService extends BaseObject
{
    private $_user_id;

    /**
     * UserMiscInfoService constructor.
     * @param $_userId
     * @param array $params
     */
    public function __construct($_userId, $params = [])
    {
        $this->_user_id = $_userId;
        parent::__construct($params);
    }


    /**
     * @param string $name
     * @return bool|mixed
     * @throws \yii\base\UnknownPropertyException
     */
    public function __get($name)
    {
        $keyedData = $this->getUserDataByKey($name);
        if ($keyedData === FALSE) {
            return parent::__get($name);
        }

        return $keyedData;
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
            $this->setUserDataByKey($name, $value);
        } catch (InvalidCallException $e) {
            $this->setUserDataByKey($name, $value);
        }
    }

    private function getUserDataByKey($key)
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
    private function setUserDataByKey($key, $value)
    {
        $object = $this->getCurrentInfoObject($key);
        if (empty($object)) {
            $object = new UserMiscInfoObject([
                'user_id' => $this->_user_id,
                'key'     => $key,
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
     * @return UserMiscInfoObject
     */
    private function getCurrentInfoObject($key)
    {
        $object = UserMiscInfoObject::find()->byUser($this->_user_id)->byKey($key)->one();

        return $object;
    }
}