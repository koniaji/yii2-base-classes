<?php
/**
 * Created by PhpStorm.
 * User: zvinger
 * Date: 20.08.18
 * Time: 17:54
 */

namespace Zvinger\BaseClasses\app\components\data\filterInfo;

use yii\base\BaseObject;
use yii\base\InvalidCallException;
use yii\base\UnknownPropertyException;
use Zvinger\BaseClasses\app\components\data\filterInfo\models\BaseFilterElement;
use Zvinger\BaseClasses\app\components\data\filterInfo\models\DBFilterMiscInfo;
use Zvinger\BaseClasses\app\components\data\filterInfo\models\SimpleValueElement;

class VendorFilterInfoService extends BaseObject
{
    /**
     * @var int
     */
    private $object_id;

    /**
     * @var string
     */
    protected static $object_type;

    protected $keys;

    public function __construct(int $object_id, string $object_type = null, $config = [])
    {
        parent::__construct($config);
        $this->object_id = $object_id;
        static::$object_type = $object_type;
    }

    /**
     * @return int
     */
    public function getObjectId(): int
    {
        return $this->object_id;
    }

    /**
     * @return string
     */
    public function getObjectType(): string
    {
        return static::$object_type;
    }

    protected function setObjectDataByKey(string $name, BaseFilterElement $value)
    {
        $value->setElementValue($name, $this);
    }

    /**
     * @param string $key
     * @param mixed $value
     */
    public static function getFilterIdsQuery(string $key, $value)
    {
        return DBFilterMiscInfo::find()->where([
            'and',
            ['object_type' => static::$object_type],
            ['key' => $key],
            ['value_id' => $value],
        ]);
    }

    public function setSimple($key, $value, $isDictionary)
    {
        return $this->setObjectDataByKey($key, new SimpleValueElement(
            [ //  тут пример для информации которая сохраняется в виде единичного экземпляра
              'value'        => $value,
              'isDictionary' => $isDictionary, //Если мы привязываемся к инфе из dictionary_info
            ]));
    }
}