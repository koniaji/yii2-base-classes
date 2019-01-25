<?php
/**
 * Created by PhpStorm.
 * User: amorev
 * Date: 21.01.2019
 * Time: 10:21
 */

namespace Zvinger\BaseClasses\app\helpers\gii\console;


use yii\console\Controller;
use yii\helpers\Console;
use Zvinger\BaseClasses\app\helpers\gii\GiiModule;

class DatabaseController extends Controller
{
    /**
     * @var GiiModule
     */
    public $module;

    public function actionGenerateModels()
    {
        $modelGenerators = $this->module->models;
        $allLines = '';
        foreach ($modelGenerators as $generator) {
            Console::output("Start ".$generator->modelClass);
            $result = $generator->generate();
            $answers = [];
            foreach ($result as $item) {
                $answers[$item->id] = true;
            }
            $lines = '';
            $generator->save($result, $answers, $lines);
            $allLines .= $lines;
        }
        Console::output($allLines);
    }
}
