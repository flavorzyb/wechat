<?php
namespace WeChat\Message;
/**
 * Class WxReceiveLinkMsg
 * @package Webiz\Modules
<xml>
<ToUserName><![CDATA[toUser]]></ToUserName>
<FromUserName><![CDATA[fromUser]]></FromUserName>
<CreateTime>1351776360</CreateTime>
<MsgType><![CDATA[link]]></MsgType>
<Title><![CDATA[公众平台官网链接]]></Title>
<Description><![CDATA[公众平台官网链接]]></Description>
<Url><![CDATA[url]]></Url>
<MsgId>1234567890123456</MsgId>
</xml>
 */
class WxReceiveLinkMsg extends WxReceiveMsg
{
    /**
     * 消息标题
     * @var string
     */
    protected $title        = null;

    /**
     * 消息描述
     * @var string
     */
    protected $description  = null;

    /**
     * 消息链接
     * @var string
     */
    protected $url          = null;

    /**
     * WxReceiveLinkMsg constructor.
     */
    public function __construct()
    {
        $this->msgType  = self::MSG_TYPE_LINK;
    }

    /**
     * 消息标题
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * 消息标题
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * 消息描述
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * 消息描述
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * 消息链接
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * 消息链接
     * @param string $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * to array
     * @return array
     */
    public function toArray()
    {
        $result = parent::toArray();

        $result['title']        = $this->title;
        $result['description']  = $this->description;
        $result['url']          = $this->url;

        return $result;
    }
}
