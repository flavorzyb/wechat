<?php
namespace WeChat\Message;

/**
 * Class WxReceiveImageMsg
 * @package Webiz\Modules
 *
<xml>
<ToUserName><![CDATA[toUser]]></ToUserName>
<FromUserName><![CDATA[fromUser]]></FromUserName>
<CreateTime>1348831860</CreateTime>
<MsgType><![CDATA[image]]></MsgType>
<PicUrl><![CDATA[this is a url]]></PicUrl>
<MediaId><![CDATA[media_id]]></MediaId>
<MsgId>1234567890123456</MsgId>
</xml>
 */

class WxReceiveImageMsg extends WxReceiveMsg
{
    /**
     * 图片消息媒体id，可以调用多媒体文件下载接口拉取数据
     * @var string
     */
    protected $mediaId  = null;
    /**
     * 图片链接
     * @var string
     */
    protected $picUrl   = null;
    /**
     * WxReceiveImageMsg constructor.
     */
    public function __construct()
    {
        $this->msgType  = self::MSG_TYPE_IMAGE;
    }

    /**
     * 图片消息媒体id，可以调用多媒体文件下载接口拉取数据
     * @return string
     */
    public function getMediaId()
    {
        return $this->mediaId;
    }

    /**
     * 图片消息媒体id，可以调用多媒体文件下载接口拉取数据
     * @param string $mediaId
     */
    public function setMediaId($mediaId)
    {
        $this->mediaId = $mediaId;
    }

    /**
     * 图片链接
     * @return string
     */
    public function getPicUrl()
    {
        return $this->picUrl;
    }

    /**
     * 图片链接
     * @param string $picUrl
     */
    public function setPicUrl($picUrl)
    {
        $this->picUrl = $picUrl;
    }

    /**
     * to array
     *
     * @return array
     */
    public function toArray()
    {
        $result             = parent::toArray();
        $result['mediaId']  = $this->mediaId;
        $result['picUrl']   = $this->picUrl;

        return $result;
    }
}
