<?php
/**
 * Created by PhpStorm.
 * User: zvinger
 * Date: 07.08.18
 * Time: 23:13
 */

namespace Zvinger\BaseClasses\app\modules\api\admin\v1\events;


use yii\base\Event;

class AdminUserSavedEvent extends Event
{
    /**
     * @var int
     */
    public $userId;

    public $request;
}