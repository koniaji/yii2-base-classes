<?php
/**
 * Created by PhpStorm.
 * User: zvinger
 * Date: 21.02.18
 * Time: 17:14
 */

namespace Zvinger\BaseClasses\app\modules\api\admin\v1\components\user\models;

use yii\base\BaseObject;

/**
 * Class UserApiAdminV1Model
 * @package Zvinger\BaseClasses\app\modules\api\admin\v1\components\user\models
 * @SWG\Definition()
 */
class UserApiAdminV1Model extends BaseObject
{
    /**
     * @var int
     * @SWG\Property()
     *
     */
    public $id;

    /**
     * @var string
     * @SWG\Property()
     */
    public $email;

    /**
     * @var string
     * @SWG\Property()
     */
    public $username;

    /**
     * @var int
     * @SWG\Property()
     */
    public $status;

    /**
     * @var string[]
     * @SWG\Property()
     */
    public $roles = [];

    /**
     * @var int
     * @SWG\Property()
     */
    public $loggedAt;
}