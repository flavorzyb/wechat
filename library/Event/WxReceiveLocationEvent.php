<?php
namespace WeChat\Event;

/**
 * Class WxReceiveLocationEvent
 * @package Webiz\Modules
<xml>
<ToUserName><![CDATA[toUser]]></ToUserName>
<FromUserName><![CDATA[fromUser]]></FromUserName>
<CreateTime>123456789</CreateTime>
<MsgType><![CDATA[event]]></MsgType>
<Event><![CDATA[LOCATION]]></Event>
<Latitude>23.137466</Latitude>
<Longitude>113.352425</Longitude>
<Precision>119.385040</Precision>
</xml>
 *
参数	描述
ToUserName	开发者微信号
FromUserName	发送方帐号（一个OpenID）
CreateTime	消息创建时间 （整型）
MsgType	消息类型，event
Event	事件类型，LOCATION
Latitude	地理位置纬度
Longitude	地理位置经度
Precision	地理位置精度

 */
class WxReceiveLocationEvent extends WxReceiveEvent
{
    /**
     * 地理位置纬度
     * @var float
     */
    protected $latitude     = null;
    /**
     * 地理位置经度
     * @var float
     */
    protected $longitude    = null;
    /**
     * 地理位置精度
     * @var float
     */
    protected $precision    = null;


    /**
     * WxReceiveLocationEvent constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->event = self::EVENT_TYPE_LOCATION;
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
     * 地理位置纬度
     * @return float
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * 地理位置纬度
     * @param float $latitude
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;
    }

    /**
     * 地理位置经度
     * @return float
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * 地理位置经度
     * @param float $longitude
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;
    }

    /**
     * 地理位置精度
     * @return float
     */
    public function getPrecision()
    {
        return $this->precision;
    }

    /**
     * 地理位置精度
     * @param float $precision
     */
    public function setPrecision($precision)
    {
        $this->precision = $precision;
    }

    /**
     * to array
     * @return array
     */
    public function toArray()
    {
        $result = parent::toArray();
        $result['latitude']     = $this->latitude;
        $result['longitude']    = $this->longitude;
        $result['precision']    = $this->precision;

        return $result;
    }
}
