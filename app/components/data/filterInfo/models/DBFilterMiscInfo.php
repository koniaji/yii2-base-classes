<?php

namespace Zvinger\BaseClasses\app\components\data\filterInfo\models;

use Yii;

/**
 * This is the model class for table "filter_misc_info".
 *
 * @property int $id
 * @property string $object_type
 * @property int $object_id
 * @property string $key
 * @property int $value_id
 * @property string $value_data
 */
class DBFilterMiscInfo extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'filter_misc_info';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['object_id', 'value_id'], 'integer'],
            [['object_type', 'key', 'value_data'], 'string', 'max' => 255],
            [['value_id'], 'exist', 'skipOnError' => true, 'targetClass' => \Zvinger\BaseClasses\app\components\data\dictionary\models\DBDictionaryInfo::className(), 'targetAttribute' => ['value_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'object_type' => 'Object Type',
            'object_id' => 'Object ID',
            'key' => 'Key',
            'value_id' => 'Value ID',
            'value_data' => 'Value Data',
        ];
    }
}
