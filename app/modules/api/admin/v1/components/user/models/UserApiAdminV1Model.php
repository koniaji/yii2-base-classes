<?php
/**
 * Created by PhpStorm.
 * User: zvinger
 * Date: 21.02.18
 * Time: 17:14
 */

namespace Zvinger\BaseClasses\app\modules\api\admin\v1\components\user\models;

use yii\base\BaseObject;

class UserApiAdminV1Model extends BaseObject
{
    public $id;

    public $email;

    public $username;

    public $status;
}