<?php
/**
 * Created by PhpStorm.
 * User: amorev
 * Date: 21.01.2019
 * Time: 10:18
 */

namespace Zvinger\BaseClasses\app\helpers\gii;


use yii\gii\Module;
use Zvinger\BaseClasses\app\helpers\gii\console\DatabaseController;
use Zvinger\BaseClasses\app\helpers\gii\generator\model\ModelGenerator;

class GiiModule extends Module
{
    /**
     * @var ModelGenerator[]
     */
    public $models = [];

    public function bootstrap($app)
    {
        parent::bootstrap($app);
        if ($app instanceof \yii\console\Application) {
            $app->controllerMap[$this->id.'-database'] = [
                'class' => DatabaseController::class,
                'module' => $this,
            ];
        }

    }
}
