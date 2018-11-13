<?php
/**
 * Created by PhpStorm.
 * User: zvinger
 * Date: 26.12.17
 * Time: 13:03
 */

namespace Zvinger\BaseClasses\app\components\email\models;

use yii\base\BaseObject;

class SendData extends BaseObject
{
    /** @var string */
    public $from;

    /** @var string */
    public $to;

    /** @var string */
    public $subject;

    /** @var string */
    public $body;

    /** @var bool */
    public $isHtml = TRUE;
}