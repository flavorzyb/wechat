<?php
namespace WeChat\Message;

/**
 * Class WxReceiveMsg
 * @package Webiz\Modules
<xml>
<ToUserName><![CDATA[toUser]]></ToUserName>
<FromUserName><![CDATA[fromUser]]></FromUserName>
<CreateTime>1348831860</CreateTime>
<MsgType><![CDATA[text]]></MsgType>
<Content><![CDATA[this is a test]]></Content>
<MsgId>1234567890123456</MsgId>
</xml>
 */
class WxReceiveTextMsg extends WxReceiveMsg
{
    /**
     * 文本消息内容
     * @var string
     */
    protected $content      = null;

    /**
     * 构造函数
     */
    public function __construct()
    {
        $this->msgType  = self::MSG_TYPE_TEXT;
    }

    /**
     * 文本消息内容
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * 文本消息内容
     * @param string $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * to array
     * @return array
     */
    public function toArray()
    {
        $result             = parent::toArray();
        $result['content']  = $this->content;

        return $result;
    }
}
