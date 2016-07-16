<?php
namespace WeChat\Event;

use WeChat\WxReceive;

abstract class WxReceiveEvent extends WxReceive
{
    /**
     * 订阅事件
     */
    const EVENT_TYPE_SUBSCRIBE      = "subscribe";

    /**
     * 取消订阅
     */
    const EVENT_TYPE_UN_SUBSCRIBE   = "unsubscribe";

    /**
     * SCAN
     */
    const EVENT_TYPE_SCAN           = "SCAN";

    /**
     * LOCATION
     */
    const EVENT_TYPE_LOCATION       = "LOCATION";

    /**
     * CLICK
     */
    const EVENT_TYPE_CLICK          = "CLICK";

    /**
     * VIEW
     */
    const EVENT_TYPE_VIEW           = "VIEW";

    /**
     * 构造函数
     */
    public function __construct()
    {
        $this->msgType  = self::MSG_TYPE_EVENT;
    }

    /**
     * event type
     * @var string
     */
    protected $event    = null;

    /**
     * event type
     * @return string
     */
    public function getEvent()
    {
        return $this->event;
    }

    /**
     * event type
     * @param null $event
     */
    public function setEvent($event)
    {
        $this->event = $event;
    }

    /**
     * to array
     *
     * @return array
     */
    public function toArray()
    {
        $result             = parent::toArray();
        $result['event']    = $this->event;

        return $result;
    }
}
