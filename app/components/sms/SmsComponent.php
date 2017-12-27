<?php
/**
 * Created by PhpStorm.
 * User: zvinger
 * Date: 26.12.17
 * Time: 17:31
 */

namespace Zvinger\BaseClasses\app\components\sms;

use yii\base\BaseObject;
use yii\base\InvalidConfigException;
use yii\di\ServiceLocator;
use Zvinger\BaseClasses\app\components\sms\exceptions\SmsException;
use Zvinger\BaseClasses\app\components\sms\models\SmsSendData;
use Zvinger\BaseClasses\app\components\sms\sender\base\BaseSender;

class SmsComponent extends BaseObject
{
    public $senders;

    private $_sender_locator;

    public $debug = FALSE;

    public $defaultSender = 'default';

    private $_sent_sms = [];

    /**
     * @param SmsSendData $smsSendData
     * @param $sender_type
     * @return bool
     * @throws SmsException
     */
    public function send(SmsSendData $smsSendData, $sender_type = NULL)
    {
        if ($sender_type === NULL) {
            $sender_type = $this->defaultSender;
        }
        $this->_sent_sms[] = [$smsSendData, $sender_type];
        if ($this->debug) {
            \Yii::info("DEBUG_SMS sending :" . print_r($smsSendData, 1));
            try {
                \Yii::$app->telegram->message('admin', 'SMS: ' . print_r($smsSendData, 1));
            } catch (\Exception $e) {
            }

            return TRUE;
        }

        return $this->getSender($sender_type)->send($smsSendData);
    }

    /**
     * @param $type
     * @return BaseSender
     * @throws SmsException
     */
    public function getSender($type)
    {
        try {
            $mailer = $this->getSenderLocator()->get($type);

            return $mailer;
        } catch (InvalidConfigException $e) {
            throw new SmsException("There is no such configured sender: " . $type);
        }
    }

    private function getSenderLocator()
    {
        if (empty($this->_sender_locator)) {
            $this->_sender_locator = new ServiceLocator([
                'components' => $this->senders,
            ]);
        }

        return $this->_sender_locator;
    }

    /**
     * @return array
     */
    public function getSentSms(): array
    {
        return $this->_sent_sms;
    }
}