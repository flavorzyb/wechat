<?php
namespace WeChat\Message;

/**
 * Class WxReceiveVoiceMsg
 * @package Webiz\Modules
<xml>
<ToUserName><![CDATA[toUser]]></ToUserName>
<FromUserName><![CDATA[fromUser]]></FromUserName>
<CreateTime>1357290913</CreateTime>
<MsgType><![CDATA[voice]]></MsgType>
<MediaId><![CDATA[media_id]]></MediaId>
<Format><![CDATA[Format]]></Format>
<MsgId>1234567890123456</MsgId>
</xml>
 */
class WxReceiveVoiceMsg extends WxReceiveMsg
{
    /**
     * 语音消息媒体id，可以调用多媒体文件下载接口拉取数据
     * @var string
     */
    protected $mediaId  = null;
    /**
     * 语音格式，如amr，speex等
     * @var string
     */
    protected $format   = null;

    /**
     * construct
     */
    public function __construct()
    {
        $this->msgType  = self::MSG_TYPE_VOICE;
    }

    /**
     * 语音消息媒体id，可以调用多媒体文件下载接口拉取数据
     * @return string
     */
    public function getMediaId()
    {
        return $this->mediaId;
    }

    /**
     * 语音消息媒体id，可以调用多媒体文件下载接口拉取数据
     * @param string $mediaId
     */
    public function setMediaId($mediaId)
    {
        $this->mediaId = $mediaId;
    }

    /**
     * 语音格式，如amr，speex等
     * @return string
     */
    public function getFormat()
    {
        return $this->format;
    }

    /**
     * 语音格式，如amr，speex等
     * @param string $format
     */
    public function setFormat($format)
    {
        $this->format = $format;
    }

    /**
     * to array
     * @return array
     */
    public function toArray()
    {
        $result             = parent::toArray();
        $result['mediaId']  = $this->mediaId;
        $result['format']   = $this->format;

        return $result;
    }
}
