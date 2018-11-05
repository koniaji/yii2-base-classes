<?php
/**
 * Created by PhpStorm.
 * User: zvinger
 * Date: 24.12.17
 * Time: 9:10
 */

namespace Zvinger\BaseClasses\api\actions\activation;

use app\modules\api\lawyer\v1\controllers\AccountController;
use yii\base\Action;
use Zvinger\Auth\Mobsolutions\components\MobileSolutionsAuthComponent;

class RevalidateUserAction extends Action
{
    /**
     * @var MobileSolutionsAuthComponent
     */
    public $authComponent;

    public $type;

    /**
     * @var AccountController
     */
    public $controller;

    /**
     * @throws \Zvinger\Telegram\exceptions\component\NoTokenProvidedException
     * @throws \Zvinger\Telegram\exceptions\message\EmptyChatIdException
     * @throws \Zvinger\Telegram\exceptions\message\EmptyMessageTextException
     * @throws \yii\base\InvalidConfigException
     */
    public function run()
    {
        if (empty($this->authComponent)) {
            $this->authComponent = $this->controller->module->authComponent;
        }
        $this->authComponent->revalidateUser(\Yii::$app->user->id, $this->type);
    }
}