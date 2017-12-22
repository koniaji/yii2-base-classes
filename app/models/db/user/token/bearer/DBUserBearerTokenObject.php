<?php

namespace Zvinger\BaseClasses\app\models\db\user\token\bearer;

use Yii;

/**
 * This is the model class for table "user_bearer_token".
 *
 * @property int $id
 * @property int $user_id
 * @property string $token
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 */
class DBUserBearerTokenObject extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_bearer_token';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'status', 'created_at', 'updated_at'], 'integer'],
            [['token'], 'string', 'max' => 255],
            [['token'], 'unique'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => \Zvinger\BaseClasses\app\models\work\user\object\VendorUserObject::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'token' => 'Token',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
