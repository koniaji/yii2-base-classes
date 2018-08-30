<?php

namespace Zvinger\BaseClasses\app\models\db\user\activation;

use Yii;

/**
 * This is the model class for table "user_activation".
 *
 * @property int $id
 * @property int $user_id
 * @property string $activation_type
 * @property string $activation_hash
 * @property int $active
 */
class DBUserActivationObject extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_activation';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'active'], 'integer'],
            [['activation_type'], 'string', 'max' => 32],
            [['activation_hash'], 'string', 'max' => 255],
            [['user_id', 'activation_type'], 'unique', 'targetAttribute' => ['user_id', 'activation_type']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => \Zvinger\BaseClasses\app\models\work\user\object\VendorUserObject::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'activation_type' => 'Activation Type',
            'activation_hash' => 'Activation Hash',
            'active' => 'Active',
        ];
    }
}
