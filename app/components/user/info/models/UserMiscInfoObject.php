<?php

namespace Zvinger\BaseClasses\app\components\user\info\models;

use Yii;
use yii\db\ActiveRecord;
use Zvinger\BaseClasses\app\models\work\user\object\VendorUserObject;

/**
 * This is the model class for table "user_misc_info".
 *
 * @property int $id
 * @property int $user_id
 * @property string $key
 * @property string $value
 * @property int $json
 * @property int $created_at
 * @property int $updated_at
 *
 * @property VendorUserObject $user
 */
class UserMiscInfoObject extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_misc_info';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'created_at', 'updated_at'], 'integer'],
            [['value'], 'string'],
            [['key'], 'string', 'max' => 100],
            [['json'], 'boolean'],
            [['user_id', 'key'], 'unique', 'targetAttribute' => ['user_id', 'key']],
            [['user_id'], 'exist', 'skipOnError' => TRUE, 'targetClass' => VendorUserObject::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'         => 'ID',
            'user_id'    => 'User ID',
            'key'        => 'Key',
            'value'      => 'Value',
            'json'       => 'Json',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(VendorUserObject::className(), ['id' => 'user_id']);
    }

    /**
     * @inheritdoc
     * @return UserMiscInfoQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new UserMiscInfoQuery(get_called_class());
    }
}
