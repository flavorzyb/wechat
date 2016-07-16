<?php
namespace WeChat\Message;

/**
 * Class WxSendVideoMsg
 * @package Webiz\Modules
<xml>
<ToUserName><![CDATA[toUser]]></ToUserName>
<FromUserName><![CDATA[fromUser]]></FromUserName>
<CreateTime>12345678</CreateTime>
<MsgType><![CDATA[video]]></MsgType>
<Video>
<MediaId><![CDATA[media_id]]></MediaId>
<Title><![CDATA[title]]></Title>
<Description><![CDATA[description]]></Description>
</Video>
</xml>
 */
class WxSendVideoMsg extends WxSendMediaMsg
{
    /**
     * 缩略图ID
     * @var string
     */
    protected $thumbMediaId = null;
    /**
     * 视频消息的标题
     * @var string
     */
    protected $title        = null;
    /**
     * 视频消息的描述
     * @var string
     */
    protected $description  = null;

    public function __construct()
    {
        $this->msgType  = self::MSG_TYPE_VIDEO;
    }

    /**
     * 视频消息的标题
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * 视频消息的标题
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * 视频消息的描述
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * 视频消息的描述
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * get
     * @return string
     */
    public function getThumbMediaId()
    {
        return $this->thumbMediaId;
    }

    /**
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
        $result                 = parent::toArray();
        $result['title']        = $this->title;
        $result['description']  = $this->description;
        $result['thumbMediaId'] = $this->thumbMediaId;

        return $result;
    }
}
