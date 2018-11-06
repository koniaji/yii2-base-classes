<?php
/**
 * Created by PhpStorm.
 * User: amorev
 * Date: 06.11.18
 * Time: 18:57
 */

namespace Zvinger\BaseClasses\app\modules\api\base\requests\auth;

/**
 * Class ResetPasswordInitRequest
 * @package Zvinger\BaseClasses\app\modules\api\base\requests\auth
 * @SWG\Definition()
 */
class SavePasswordRequest
{
    /**
     * @var string
     * @SWG\Property()
     */
    public $email;

    /**
     * @var string
     * @SWG\Property()
     */
    public $code;

    /**
     * @var string
     * @SWG\Property()
     */
    public $password;
}