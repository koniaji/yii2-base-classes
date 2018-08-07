<?php
/**
 * Created by PhpStorm.
 * User: zvinger
 * Date: 07.08.18
 * Time: 23:32
 */

namespace Zvinger\BaseClasses\app\modules\api\admin\v1\events;


use yii\base\Event;
use Zvinger\BaseClasses\app\modules\api\admin\v1\components\user\models\UserApiAdminV1Model;

class AdminUserBeforeSendEvent extends Event
{
    /**
     * @var UserApiAdminV1Model
     */
    public $userModel;
}