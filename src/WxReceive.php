<?php
namespace WeChat;

abstract class WxReceive
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
     * 小视频消息
     */
    const MSG_TYPE_SHORT_VIDEO  = "shortvideo";

    /**
     * 地理位置消息
     */
    const MSG_TYPE_LOCATION     = "location";

    /**
     * 链接消息
     */
    const MSG_TYPE_LINK         = "link";

    /**
     * 事件消息
     */
    const MSG_TYPE_EVENT        = "event";

    /**
     * 记录ID
     * @var int
     */
    protected $id           = null;

    /**
     * 开发者微信号
     * @var string
     */
    protected $toUserName   = null;

    /**
     * 发送方帐号（一个OpenID）
     * @var string
     */
    protected $fromUserName = null;

    /**
     * 消息创建时间 （整型）
     * @var string
     */
    protected $createTime   = null;

    /**
     * 消息类型
     * @var string
     */
    protected $msgType      = null;

    /**
     * 记录ID
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * 记录ID
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * 开发者微信号
     * @return string
     */
    public function getToUserName()
    {
        return $this->toUserName;
    }

    /**
     * 开发者微信号
     * @param string $toUserName
     */
    public function setToUserName($toUserName)
    {
        $this->toUserName = $toUserName;
    }

    /**
     * 发送方帐号（一个OpenID）
     * @return string
     */
    public function getFromUserName()
    {
        return $this->fromUserName;
    }

    /**
     * 发送方帐号（一个OpenID）
     * @param string $fromUserName
     */
    public function setFromUserName($fromUserName)
    {
        $this->fromUserName = $fromUserName;
    }

    /**
     * 消息创建时间
     * @return string
     */
    public function getCreateTime()
    {
        return $this->createTime;
    }

    /**
     * 消息创建时间
     * @param string $createTime
     */
    public function setCreateTime($createTime)
    {
        $this->createTime = $createTime;
    }

    /**
     * 获取消息类型
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
        $result = [];
        $result['id']            = $this->id;
        $result['toUserName']    = $this->toUserName;
        $result['fromUserName']  = $this->fromUserName;
        $result['createTime']    = $this->createTime;
        $result['msgType']       = $this->msgType;
        return $result;
    }
}
