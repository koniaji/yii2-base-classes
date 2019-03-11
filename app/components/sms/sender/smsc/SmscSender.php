<?php
/**
 * Created by PhpStorm.
 * User: zvinger
 * Date: 26.12.17
 * Time: 17:58
 */

namespace Zvinger\BaseClasses\app\components\sms\sender\smsc;

use ladamalina\smsc\Smsc;
use Zvinger\BaseClasses\app\components\sms\models\SmsSendData;
use Zvinger\BaseClasses\app\components\sms\sender\base\BaseSender;

class SmscSender extends BaseSender
{
    public $login;

    public $password;

    protected function sendByService(SmsSendData $data)
    {
        $this->getService()->send_sms($data->phone, $data->message,0,0,0,0, $data->from);
    }

    private $_service;

    /**
     * @return Smsc
     */
    private function getService()
    {
        if (empty($this->_service)) {
            $this->_service = new Smsc([
                'login'    => $this->login,  // login
                'password' => $this->password, // plain password or lowercase password MD5-hash
                'post'     => TRUE, // use http POST method
                'https'    => TRUE,    // use secure HTTPS connection
                'charset'  => 'utf-8',   // charset: windows-1251, koi8-r or utf-8 (default)
                'debug'    => FALSE,    // debug mode
            ]);
        }

        return $this->_service;
    }


}