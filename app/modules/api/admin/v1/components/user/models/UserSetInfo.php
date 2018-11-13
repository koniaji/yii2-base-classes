<?php
/**
 * Created by PhpStorm.
 * User: zvinger
 * Date: 24.04.18
 * Time: 13:48
 */

namespace Zvinger\BaseClasses\app\modules\api\admin\v1\components\user\models;


class UserSetInfo
{
    public $username;

    public $email;

    public $password;

    public $roles = [];
}