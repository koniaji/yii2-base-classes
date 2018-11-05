<?php

namespace Zvinger\BaseClasses\app\modules\fileStorage\models\fileStorageElement;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "file_storage_element".
 *
 * @property int $id
 * @property int $component
 * @property string $type
 * @property string $path
 * @property string $info
 * @property string $deleted
 * @property int $created_at
 * @property int $updated_at
 */
class FileStorageElementObject extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'file_storage_element';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::class,
        ];
    }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created_at', 'updated_at'], 'integer'],
            [['info'], 'string'],
            [['component'], 'string', 'max' => 32],
            [['type'], 'string', 'max' => 100],
            [['path'], 'string', 'max' => 500],
            [['deleted'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'component' => 'Component',
            'type' => 'Type',
            'path' => 'Path',
            'info' => 'Info',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @inheritdoc
     * @return FileStorageElementQuery the active query used by this AR class.
     */
    public static function findNotDeleted()
    {
        return static::findDeleted()->andWhere('deleted is null');
    }

    /**
     * @inheritdoc
     * @return FileStorageElementQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new FileStorageElementQuery(get_called_class());
    }
}
