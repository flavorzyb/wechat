<?php
namespace WeChat\Event;

/**
 * Class WxReceiveClickEvent
 * @package Webiz\Modules
 *
<xml>
<ToUserName><![CDATA[toUser]]></ToUserName>
<FromUserName><![CDATA[FromUser]]></FromUserName>
<CreateTime>123456789</CreateTime>
<MsgType><![CDATA[event]]></MsgType>
<Event><![CDATA[CLICK]]></Event>
<EventKey><![CDATA[EVENTKEY]]></EventKey>
</xml>
参数说明：

参数	描述
ToUserName	开发者微信号
FromUserName	发送方帐号（一个OpenID）
CreateTime	消息创建时间 （整型）
MsgType	消息类型，event
Event	事件类型，CLICK
EventKey	事件KEY值，与自定义菜单接口中KEY值对应
 */
class WxReceiveClickEvent extends WxReceiveViewEvent
{

    /**
     * WxReceiveClickEvent constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->event    = self::EVENT_TYPE_CLICK;
    }
}
