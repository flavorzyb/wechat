<?php
namespace WeChat\Message;
/**
 * Class WxReceiveVideoMsg
 * @package Webiz\Modules
<xml>
<ToUserName><![CDATA[toUser]]></ToUserName>
<FromUserName><![CDATA[fromUser]]></FromUserName>
<CreateTime>1357290913</CreateTime>
<MsgType><![CDATA[video]]></MsgType>
<MediaId><![CDATA[media_id]]></MediaId>
<ThumbMediaId><![CDATA[thumb_media_id]]></ThumbMediaId>
<MsgId>1234567890123456</MsgId>
</xml>
 */
class WxReceiveVideoMsg extends WxReceiveMsg
{
    /**
     * 视频消息媒体id，可以调用多媒体文件下载接口拉取数据
     * @var string
     */
    protected $mediaId      = null;

    /**
     * 视频消息缩略图的媒体id，可以调用多媒体文件下载接口拉取数据
     * @var string
     */
    protected $thumbMediaId = null;

    /**
     * WxReceiveVideoMsg constructor.
     */
    public function __construct()
    {
        $this->msgType  = self::MSG_TYPE_VIDEO;
    }

    /**
     * 视频消息媒体id，可以调用多媒体文件下载接口拉取数据
     * @return string
     */
    public function getMediaId()
    {
        return $this->mediaId;
    }

    /**
     * 视频消息媒体id，可以调用多媒体文件下载接口拉取数据
     * @param string $mediaId
     */
    public function setMediaId($mediaId)
    {
        $this->mediaId = $mediaId;
    }

    /**
     * 视频消息缩略图的媒体id，可以调用多媒体文件下载接口拉取数据
     * @return string
     */
    public function getThumbMediaId()
    {
        return $this->thumbMediaId;
    }

    /**
     * 视频消息缩略图的媒体id，可以调用多媒体文件下载接口拉取数据
     * @param string $thumbMediaId
     */
    public function setThumbMediaId($thumbMediaId)
    {
        $this->thumbMediaId = $thumbMediaId;
    }

    /**
     * to array
     * @return array
     */
    public function toArray()
    {
        $result = parent::toArray();

        $result['mediaId']      = $this->mediaId;
        $result['thumbMediaId'] = $this->thumbMediaId;

        return $result;
    }
}
