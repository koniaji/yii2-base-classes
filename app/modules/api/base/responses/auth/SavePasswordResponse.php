<?php
/**
 * Created by PhpStorm.
 * User: amorev
 * Date: 06.11.18
 * Time: 19:13
 */

namespace Zvinger\BaseClasses\app\modules\api\base\responses\auth;

/**
 * Class SavePasswordResponse
 * @package Zvinger\BaseClasses\app\modules\api\base\responses\auth
 * @SWG\Definition()
 */
class SavePasswordResponse
{
    /**
     * @var string
     * @SWG\Property()
     */
    public $token;
}