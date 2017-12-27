<?php
/**
 * Created by PhpStorm.
 * User: zvinger
 * Date: 26.12.17
 * Time: 11:29
 */

namespace Zvinger\BaseClasses\app\components\email;

use yii\base\BaseObject;
use yii\base\InvalidConfigException;
use yii\di\ServiceLocator;
use yii\swiftmailer\Mailer;
use Zvinger\BaseClasses\app\components\email\components\ZvingerMailer;
use Zvinger\BaseClasses\app\components\email\exceptions\EmailComponentException;
use Zvinger\BaseClasses\app\components\email\models\SendData;

class EmailComponent extends BaseObject
{
    public $mailers;

    public $debugMailer = 'mailcatcher';

    public $debug = FALSE;

    public $defaulMailer = 'default';

    private $_mailer_locator;

    /**
     * @param $type
     * @return ZvingerMailer|Mailer
     * @throws EmailComponentException
     */
    public function getMailer($type)
    {
        try {
            /** @var Mailer $mailer */
            $mailer = $this->getMailerLocator()->get($type);

            return $mailer;
        } catch (InvalidConfigException $e) {
            throw new EmailComponentException("There is no such configured mailer: " . $type);
        }
    }

    private function getMailerLocator()
    {
        if (empty($this->_mailer_locator)) {
            $this->_mailer_locator = new ServiceLocator([
                'components' => $this->mailers,
            ]);
        }

        return $this->_mailer_locator;
    }

    /**
     * @param SendData $data
     * @param $mailerType
     * @return bool
     * @throws EmailComponentException
     */
    public function send(SendData $data, $mailerType = NULL)
    {
        if ($this->debug) {
            $mailerType = $this->debugMailer;
        }
        if (empty($mailerType)) {
            $mailerType = $this->defaulMailer;
        }

        $mailer = $this->getMailer($mailerType);
        if (empty($data->from)) {
            $data->from = $mailer->defaultFrom;
        }
        $message = $mailer
            ->compose()
            ->setTo($data->to)
            ->setSubject($data->subject);
        if ($data->from) {
            $message->setFrom($data->from);
        }
        if ($data->isHtml) {
            $message->setHtmlBody($data->body);
        } else {
            $message->setTextBody($data->body);
        }

        return $message->send();
    }
}