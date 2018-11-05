<?php
/**
 * Created by PhpStorm.
 * User: zvinger
 * Date: 21.12.17
 * Time: 10:24
 */

namespace Zvinger\BaseClasses\app\modules\api\base\responses\auth;

/**
 * @SWG\Definition(
 *     required={"username", "email"}
 *     )
 */
class BaseAuthLoginResponse
{
    /**
     * @var string
     * @SWG\Property()
     */
    public $token;

    /**
     * @var int
     * @SWG\Property()
     */
    public $user;
}