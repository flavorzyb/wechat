<?php

namespace WeChat\Event;

/**
 * Class WxReceiveViewEvent
 * @package Webiz\Modules
<xml>
<ToUserName><![CDATA[toUser]]></ToUserName>
<FromUserName><![CDATA[FromUser]]></FromUserName>
<CreateTime>123456789</CreateTime>
<MsgType><![CDATA[event]]></MsgType>
<Event><![CDATA[VIEW]]></Event>
<EventKey><![CDATA[www.qq.com]]></EventKey>
</xml>

参数	描述
ToUserName	开发者微信号
FromUserName	发送方帐号（一个OpenID）
CreateTime	消息创建时间 （整型）
MsgType	消息类型，event
Event	事件类型，VIEW
EventKey	事件KEY值，设置的跳转URL
 */
class WxReceiveViewEvent extends WxReceiveEvent
{
    /**
     * 事件KEY值，设置的跳转URL
     * @var string
     */
    protected $eventKey = null;

    /**
     * WxReceiveViewEvent constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->event    = self::EVENT_TYPE_VIEW;
    }

    /**
     * setting event
     * @param string $event
     * @codeCoverageIgnore
     */
    public function setEvent($event)
    {
        //can not change event
    }

    /**
     * 事件KEY值，设置的跳转URL
     * @return string
     */
    public function getEventKey()
    {
        return $this->eventKey;
    }

    /**
     * 事件KEY值，设置的跳转URL
     * @param string $eventKey
     */
    public function setEventKey($eventKey)
    {
        $this->eventKey = $eventKey;
    }

    /**
     * to array
     *
     * @return array
     */
    public function toArray()
    {
        $result = parent::toArray();

        $result['eventKey'] = $this->eventKey;

        return $result;
    }
}
