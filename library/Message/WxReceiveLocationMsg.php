<?php
namespace WeChat\Message;
/**
 * Class WxReceiveLocationMsg
 * @package Webiz\Modules
<xml>
<ToUserName><![CDATA[toUser]]></ToUserName>
<FromUserName><![CDATA[fromUser]]></FromUserName>
<CreateTime>1351776360</CreateTime>
<MsgType><![CDATA[location]]></MsgType>
<Location_X>23.134521</Location_X>
<Location_Y>113.358803</Location_Y>
<Scale>20</Scale>
<Label><![CDATA[位置信息]]></Label>
<MsgId>1234567890123456</MsgId>
</xml>
 */
class WxReceiveLocationMsg extends WxReceiveMsg
{
    /**
     * 地理位置维度
     * @var float
     */
    protected $locationX    = null;
    /**
     * 地理位置经度
     * @var float
     */
    protected $locationY    = null;
    /**
     * 地图缩放大小
     * @var int
     */
    protected $scale        = null;
    /**
     * 地理位置信息
     * @var string
     */
    protected $label        = null;

    /**
     * WxReceiveLocationMsg constructor.
     */
    public function __construct()
    {
        $this->msgType  = self::MSG_TYPE_LOCATION;
    }


    /**
     * 地理位置维度
     * @return float
     */
    public function getLocationX()
    {
        return $this->locationX;
    }

    /**
     * 地理位置维度
     * @param float $locationX
     */
    public function setLocationX($locationX)
    {
        $this->locationX = $locationX;
    }

    /**
     * 地理位置经度
     * @return float
     */
    public function getLocationY()
    {
        return $this->locationY;
    }

    /**
     * 地理位置经度
     * @param float $locationY
     */
    public function setLocationY($locationY)
    {
        $this->locationY = $locationY;
    }

    /**
     * 地图缩放大小
     * @return int
     */
    public function getScale()
    {
        return $this->scale;
    }

    /**
     * 地图缩放大小
     * @param int $scale
     */
    public function setScale($scale)
    {
        $this->scale = $scale;
    }

    /**
     * 地理位置信息
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * 地理位置信息
     * @param string $label
     */
    public function setLabel($label)
    {
        $this->label = $label;
    }

    /**
     * to array
     * @return array
     */
    public function toArray()
    {
        $result     = parent::toArray();

        $result['locationX']    = $this->locationX;
        $result['locationY']    = $this->locationY;
        $result['scale']        = $this->scale;
        $result['label']        = $this->label;

        return $result;
    }
}
