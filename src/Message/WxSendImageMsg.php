<?php
namespace WeChat\Message;

/**
 * Class WxSendImageMsg
 * @package Webiz\Modules
<xml>
<ToUserName><![CDATA[toUser]]></ToUserName>
<FromUserName><![CDATA[fromUser]]></FromUserName>
<CreateTime>12345678</CreateTime>
<MsgType><![CDATA[image]]></MsgType>
<Image>
<MediaId><![CDATA[media_id]]></MediaId>
</Image>
</xml>
 */
class WxSendImageMsg extends WxSendMediaMsg
{
    public function __construct()
    {
        $this->msgType  = self::MSG_TYPE_IMAGE;
    }
}
