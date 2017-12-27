<?php
/**
 * Created by PhpStorm.
 * User: zvinger
 * Date: 26.12.17
 * Time: 16:29
 */

namespace Zvinger\BaseClasses\app\components\email\components;

use yii\swiftmailer\Mailer;

class ZvingerMailer extends Mailer
{
    public $defaultFrom ;
}