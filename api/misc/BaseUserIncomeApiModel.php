<?php
/**
 * Created by PhpStorm.
 * User: zvinger
 * Date: 25.04.18
 * Time: 16:42
 */

namespace Zvinger\BaseClasses\api\misc;


use yii\base\BaseObject;
use yii\web\BadRequestHttpException;


abstract class BaseUserIncomeApiModel extends BaseObject
{
    protected $errorMessage;

    /**
     * @param null $data
     * @return static
     * @throws BadRequestHttpException
     */
    public static function createRequest($data = NULL)
    {
        if ($data === NULL) {
            $data = static::getBaseData();
        }
        $request = new static;

        $object = $request->loadRequest($data);
        if (!$object->validate()) {
            throw new BadRequestHttpException($object->errorMessage);
        }

        return $object;
    }

    public function validate()
    {
        return TRUE;
    }

    /**
     * @param $data
     * @return static
     */
    public function loadRequest($data)
    {
        return \Yii::configure($this, $data);
    }

    protected function validateRequired($fields = [])
    {
        foreach ($fields as $field) {
            if (!isset($this->{$field}) || $this->{$field} === NULL) {
                $this->errorMessage = 'Empty Request field: ' . $field;

                return FALSE;
            }
        }

        return TRUE;
    }

    public static function getBaseData()
    {
        return [];
    }
}