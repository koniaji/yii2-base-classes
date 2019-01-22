<?php
/**
 * Created by PhpStorm.
 * User: zvinger
 * Date: 27.05.18
 * Time: 11:35
 */

namespace Zvinger\BaseClasses\app\modules\fileStorage\controllers;


use yii\web\Controller;
use Zvinger\BaseClasses\app\modules\fileStorage\actions\FSGlideAction;
use Zvinger\BaseClasses\app\modules\fileStorage\VendorFileStorageModule;

class GlideController extends BaseVendorFileStorageModuleController
{
    /**
     * @var VendorFileStorageModule
     */
    public $module;

    public function actions()
    {
        return [
            'index' => [
                'class'           => FSGlideAction::class,
                'componentGetter' => function () {
                    return $this->module->glide;
                },
            ],
        ];
    }
}
