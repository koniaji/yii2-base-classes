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
use yii\db\Query;
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
     * @return
     */
    public static function getFilterIdsQuery(array $elements = [])
    {
        $query = DBFilterMiscInfo::find();
        $keys = array_keys($elements);
        $query
            ->select(['object_id', 'val_id' => 'count(`value_id`)', 'val_data' => 'count(`value_data`)'])
            ->where([
                'and',
                ['object_type' => static::$object_type],
                ['key' => $keys],
            ])
            ->groupBy(['object_id', 'key', 'value_id', 'value_data']);
        $havingCondition = ['or'];
        foreach ($elements as $key => $element) {
            $havingCondition[] = ['and', ['key' => $key], $element];
        }
        $query->having($havingCondition);
        $queryIds = new Query();
        $queryIds->from(['filter' => $query])
            ->select(['object_id'])
            ->groupBy(['object_id'])
            ->having(['count(object_id)' => count($keys)]);
        $objectIds = $queryIds->column();

        return $objectIds;
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