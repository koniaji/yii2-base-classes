<?php
/**
 * Created by PhpStorm.
 * User: amorev
 * Date: 21.11.2018
 * Time: 22:46
 */

namespace Zvinger\BaseClasses\app\components\log\target;


use yii\log\Target;

class TelegramLogTarget extends Target
{

    /**
     * Exports log [[messages]] to a specific destination.
     * Child classes must implement this method.
     */
    public function export()
    {
        foreach ($this->messages as $message) {
            $message1 = $this->formatMessage($message);
            \Yii::$app->telegram->message('admin', $message1);
        }
    }
}