<?php
namespace WeChat\Message;

/**
 * Class WxSendVoiceMsg
 * @package Webiz\Modules
<xml>
<ToUserName><![CDATA[toUser]]></ToUserName>
<FromUserName><![CDATA[fromUser]]></FromUserName>
<CreateTime>12345678</CreateTime>
<MsgType><![CDATA[voice]]></MsgType>
<Voice>
<MediaId><![CDATA[media_id]]></MediaId>
</Voice>
</xml>
 */
class WxSendVoiceMsg extends WxSendMediaMsg
{
    public function __construct()
    {
        $this->msgType  = self::MSG_TYPE_VOICE;
    }
}
