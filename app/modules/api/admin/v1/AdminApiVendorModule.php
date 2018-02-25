<?php
/**
 * Created by PhpStorm.
 * User: zvinger
 * Date: 20.12.17
 * Time: 19:18
 */

namespace Zvinger\BaseClasses\app\modules\api\admin\v1;

use Zvinger\BaseClasses\app\modules\api\admin\AdminApiModule;
use yii\base\Application;
use yii\base\BootstrapInterface;
use Zvinger\BaseClasses\app\modules\api\admin\v1\components\user\VendorAdminUserComponent;

/**
 * Class AdminApiVendorModule
 * @package Zvinger\BaseClasses\app\modules\api\admin\v1
 * @property VendorAdminUserComponent $userComponent
 */
class AdminApiVendorModule extends AdminApiModule implements BootstrapInterface
{

    /**
     * Bootstrap method to be called during application bootstrap stage.
     * @param Application $app the application currently running
     */
    public function bootstrap($app)
    {
        $app->urlManager->addRules([
            ['class' => 'yii\rest\UrlRule', 'controller' => $this->uniqueId . '/user'],
        ]);
        $app->components = [
            'userComponent' => VendorAdminUserComponent::class,
        ];
    }
}