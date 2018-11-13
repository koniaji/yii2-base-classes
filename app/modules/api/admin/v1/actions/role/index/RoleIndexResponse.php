<?php
/**
 * Created by PhpStorm.
 * User: zvinger
 * Date: 24.04.18
 * Time: 13:35
 */

namespace Zvinger\BaseClasses\app\modules\api\admin\v1\actions\role\index;


/**
 * Class RoleIndexResponse
 * @package Zvinger\BaseClasses\app\modules\api\admin\v1\actions\role\index
 * @SWG\Definition()
 */
class RoleIndexResponse
{
    /**
     * Массив ролей системы
     * @var string[]
     * @SWG\Property()
     */
    public $roles = [];
}