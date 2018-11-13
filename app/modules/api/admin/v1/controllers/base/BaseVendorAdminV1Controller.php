<?php
/**
 * Created by PhpStorm.
 * User: zvinger
 * Date: 21.02.18
 * Time: 17:22
 */

namespace Zvinger\BaseClasses\app\modules\api\admin\v1\controllers\base;

use yii\filters\auth\HttpBearerAuth;
use yii\rest\OptionsAction;
use Zvinger\BaseClasses\api\controllers\BaseApiController;
use Zvinger\BaseClasses\app\modules\api\admin\v1\AdminApiVendorModule;

class BaseVendorAdminV1Controller extends BaseApiController
{
    /**
     * @var AdminApiVendorModule
     */
    public $module;

    public function actions()
    {
        return [
            'options' => [
                'class' => OptionsAction::class,
            ],
        ];
    }

    public function behaviors()
    {
        $old = parent::behaviors();
        $behaviors = [];
        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::class,
        ];

        $array_merge = array_merge($old, $behaviors);

        return $array_merge;
    }
}