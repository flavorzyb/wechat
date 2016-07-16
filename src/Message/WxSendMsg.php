<?php
namespace WeChat\Message;

/**
 * Class WxSendMsg
 * @package Webiz\Modules
<xml>
<ToUserName><![CDATA[toUser]]></ToUserName>
<FromUserName><![CDATA[fromUser]]></FromUserName>
<CreateTime>12345678</CreateTime>
<MsgType><![CDATA[text]]></MsgType>
<Content><![CDATA[你好]]></Content>
</xml>
 */
abstract class WxSendMsg
{
    /**
     * 文本类型消息
     */
    const MSG_TYPE_TEXT         = "text";

    /**
     * 图片消息
     */
    const MSG_TYPE_IMAGE        = "image";

    /**
     * 语音消息
     */
    const MSG_TYPE_VOICE        = "voice";

    /**
     * 视频消息
     */
    const MSG_TYPE_VIDEO        = "video";

    /**
     * 音乐消息
     */
    const MSG_TYPE_MUSIC        = 'music';

    /**
     * 图文消息
     */
    const MSG_TYPE_NEWS         = 'news';

    /**
     * 接收方帐号（收到的OpenID）
     * @var string
     */
    protected $toUserName   = null;
    /**
     * 开发者微信号
     * @var string
     */
    protected $fromUserName = null;
    /**
     * 消息创建时间 （整型）
     * @var int
     */
    protected $createTime   = null;
    /**
     * 消息类型
     * @var string
     */
    protected $msgType      = null;

    /**
     * 接收方帐号（收到的OpenID）
     * @return string
     */
    public function getToUserName()
    {
        return $this->toUserName;
    }

    /**
     * 接收方帐号（收到的OpenID）
     * @param string $toUserName
     */
    public function setToUserName($toUserName)
    {
        $this->toUserName = $toUserName;
    }

    /**
     * 开发者微信号
     * @return string
     */
    public function getFromUserName()
    {
        return $this->fromUserName;
    }

    /**
     * 开发者微信号
     * @param string $fromUserName
     */
    public function setFromUserName($fromUserName)
    {
        $this->fromUserName = $fromUserName;
    }

    /**
     * 消息创建时间 （整型）
     * @return int
     */
    public function getCreateTime()
    {
        return $this->createTime;
    }

    /**
     * 消息创建时间 （整型）
     * @param int $createTime
     */
    public function setCreateTime($createTime)
    {
        $this->createTime = $createTime;
    }

    /**
     * 消息类型
     * @return string
     */
    public function getMsgType()
    {
        return $this->msgType;
    }

    /**
     * to array
     *
     * @return array
     */
    public function toArray()
    {
        return [
                'toUserName'    => $this->toUserName,
                'fromUserName'  => $this->fromUserName,
                'createTime'    => $this->createTime,
                'msgType'       => $this->msgType,
            ];
    }
}
