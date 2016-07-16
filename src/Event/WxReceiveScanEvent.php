<?php
namespace WeChat\Event;
/**
 * Class WxReceiveScanEvent
 * @package Webiz\Modules
用户扫描带场景值二维码时，可能推送以下两种事件：

如果用户还未关注公众号，则用户可以关注公众号，关注后微信会将带场景值关注事件推送给开发者。
如果用户已经关注公众号，则微信会将带场景值扫描事件推送给开发者。
1. 用户未关注时，进行关注后的事件推送

推送XML数据包示例：

<xml><ToUserName><![CDATA[toUser]]></ToUserName>
<FromUserName><![CDATA[FromUser]]></FromUserName>
<CreateTime>123456789</CreateTime>
<MsgType><![CDATA[event]]></MsgType>
<Event><![CDATA[subscribe]]></Event>
<EventKey><![CDATA[qrscene_123123]]></EventKey>
<Ticket><![CDATA[TICKET]]></Ticket>
</xml>
参数	描述
ToUserName	开发者微信号
FromUserName	发送方帐号（一个OpenID）
CreateTime	消息创建时间 （整型）
MsgType	消息类型，event
Event	事件类型，subscribe
EventKey	事件KEY值，qrscene_为前缀，后面为二维码的参数值
Ticket	二维码的ticket，可用来换取二维码图片

2. 用户已关注时的事件推送

推送XML数据包示例：

<xml>
<ToUserName><![CDATA[toUser]]></ToUserName>
<FromUserName><![CDATA[FromUser]]></FromUserName>
<CreateTime>123456789</CreateTime>
<MsgType><![CDATA[event]]></MsgType>
<Event><![CDATA[SCAN]]></Event>
<EventKey><![CDATA[SCENE_VALUE]]></EventKey>
<Ticket><![CDATA[TICKET]]></Ticket>
</xml>
参数	描述
ToUserName	开发者微信号
FromUserName	发送方帐号（一个OpenID）
CreateTime	消息创建时间 （整型）
MsgType	消息类型，event
Event	事件类型，SCAN
EventKey	事件KEY值，是一个32位无符号整数，即创建二维码时的二维码scene_id
Ticket	二维码的ticket，可用来换取二维码图片
 */
class WxReceiveScanEvent extends WxReceiveEvent
{
    /**
     * 事件KEY值，qrscene_为前缀，后面为二维码的参数值
     * @var string
     */
    protected $eventKey = null;
    /**
     * 二维码的ticket，可用来换取二维码图片
     * @var string
     */
    protected $ticket   = null;

    /**
     * 事件KEY值，qrscene_为前缀，后面为二维码的参数值
     * @return string
     */
    public function getEventKey()
    {
        return $this->eventKey;
    }

    /**
     * 事件KEY值，qrscene_为前缀，后面为二维码的参数值
     * @param string $eventKey
     */
    public function setEventKey($eventKey)
    {
        $this->eventKey = $eventKey;
    }

    /**
     * 二维码的ticket，可用来换取二维码图片
     * @return string
     */
    public function getTicket()
    {
        return $this->ticket;
    }

    /**
     * 二维码的ticket，可用来换取二维码图片
     * @param string $ticket
     */
    public function setTicket($ticket)
    {
        $this->ticket = $ticket;
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
        $result['ticket']   = $this->ticket;

        return $result;
    }
}
