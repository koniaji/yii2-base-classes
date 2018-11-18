<?php
/**
 * Created by PhpStorm.
 * User: amorev
 * Date: 06.11.18
 * Time: 18:59
 */

namespace Zvinger\BaseClasses\app\modules\api\base\responses\auth;

/**
 * Class ResetPasswordResponse
 * @package Zvinger\BaseClasses\app\modules\api\base\responses\auth
 * @SWG\Definition()
 */
class ResetPasswordInitResponse
{
    /**
     * @var bool
     * @SWG\Property()
     */
    public $success;
}