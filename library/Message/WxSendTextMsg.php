<?php
namespace WeChat\Message;

/**
 * Class WxSendTextMsg
 * @package Webiz\Modules
<xml>
<ToUserName><![CDATA[toUser]]></ToUserName>
<FromUserName><![CDATA[fromUser]]></FromUserName>
<CreateTime>12345678</CreateTime>
<MsgType><![CDATA[text]]></MsgType>
<Content><![CDATA[你好]]></Content>
</xml>
 */
class WxSendTextMsg extends WxSendMsg
{
    /**
     * 回复的消息内容（换行：在content中能够换行，微信客户端就支持换行显示）
     * @var string
     */
    protected $content  = null;

    /**
     * 构造函数
     */
    public function __construct()
    {
        $this->msgType  = self::MSG_TYPE_TEXT;
    }

    /**
     * 回复的消息内容
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * 回复的消息内容
     * @param string $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * to array
     *
     * @return array
     */
    public function toArray()
    {
        $result = parent::toArray();
        $result['content']  = $this->content;

        return $result;
    }
}
