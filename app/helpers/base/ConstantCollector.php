<?php
/**
 * Created by PhpStorm.
 * User: zvinger
 * Date: 10.02.18
 * Time: 10:22
 */

namespace Zvinger\BaseClasses\app\helpers\base;

use yii\helpers\ArrayHelper;
use Zvinger\BaseClasses\app\helpers\SingleTones;

abstract class ConstantCollector extends SingleTones
{
    const KEY_ID = 'id';
    const KEY_TITLE = 'title';
    const KEY_KEY = 'key';

    protected $_objects = [];

    /**
     * @var array|false
     */
    private $_all_objects = FALSE;

    protected function getBaseObjectsCurrent()
    {
        return $this->_objects;
    }

    final private function getBaseObjects()
    {
        if (empty($this->_objects)) {
            $this->_objects = $this->getBaseObjectsCurrent();
        }

        return $this->_objects;
    }

    /**
     * @return ConstantElement[]
     */
    public function getAllObjects()
    {
        if ($this->_all_objects === FALSE) {
            $result = [];
            foreach ($this->getBaseObjects() as $channel) {
                $row = \Yii::configure(new ConstantElement(), $channel);
                $result[] = $row;
            }

            $this->_all_objects = $result;
        }

        return $this->_all_objects;
    }

    /**
     * @var ConstantElement[]
     */
    private $_objects_by = [];

    /**
     * @param string $getBy
     * @param null $key
     * @return ConstantElement|ConstantElement[]
     */
    public function getObjectsBy($getBy = self::KEY_ID, $key = NULL)
    {
        if (empty($this->_objects_by[$getBy])) {
            $objects = $this->getAllObjects();
            $this->_objects_by[$getBy] = ArrayHelper::map($objects, $getBy, function ($row) {
                return $row;
            });
        }

        if (!$key !== NULL) {
            return ArrayHelper::getValue($this->_objects_by[$getBy], $key);
        }

        return $this->_objects_by[$getBy];
    }
}