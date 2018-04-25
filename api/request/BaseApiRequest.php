<?php
/**
 * Created by PhpStorm.
 * User: zvinger
 * Date: 24.04.18
 * Time: 23:10
 */

namespace Zvinger\BaseClasses\api\request;


use yii\base\BaseObject;
use yii\web\BadRequestHttpException;

abstract class BaseApiRequest extends BaseObject
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
            $data = \Yii::$app->request->post();
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
}