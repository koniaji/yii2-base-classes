<?php
/**
 * Created by PhpStorm.
 * User: zvinger
 * Date: 23.12.17
 * Time: 0:55
 */

namespace Zvinger\BaseClasses\app\components\user\identity\events;

use yii\base\Event;
use Zvinger\BaseClasses\app\models\work\user\object\VendorUserObject;

class EventActivationUpdated extends Event
{
    /** @var VendorUserObject */
    public $userObject;
}