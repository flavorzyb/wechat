<?php
namespace WeChat\Message;
/**
 * Class WxReceiveVideoMsg
 * @package Webiz\Modules
<xml>
<ToUserName><![CDATA[toUser]]></ToUserName>
<FromUserName><![CDATA[fromUser]]></FromUserName>
<CreateTime>1357290913</CreateTime>
<MsgType><![CDATA[shortvideo]]></MsgType>
<MediaId><![CDATA[media_id]]></MediaId>
<ThumbMediaId><![CDATA[thumb_media_id]]></ThumbMediaId>
<MsgId>1234567890123456</MsgId>
</xml>
 */
class WxReceiveShortVideoMsg extends WxReceiveVideoMsg
{
    /**
     * WxReceiveVideoMsg constructor.
     */
    public function __construct()
    {
        $this->msgType  = self::MSG_TYPE_SHORT_VIDEO;
    }
}
