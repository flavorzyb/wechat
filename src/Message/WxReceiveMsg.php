<?php
namespace WeChat\Message;

use WeChat\WxReceive;

abstract class WxReceiveMsg extends WxReceive
{
    /**
     * 消息id，64位整型
     * @var int
     */
    protected $msgId        = null;

    /**
     * 消息id，64位整型
     * @return int
     */
    public function getMsgId()
    {
        return $this->msgId;
    }

    /**
     * 消息id，64位整型
     * @param int $msgId
     */
    public function setMsgId($msgId)
    {
        $this->msgId = $msgId;
    }

    /**
     * to array
     *
     * @return array
     */
    public function toArray()
    {
        $result = parent::toArray();
        $result['msgId']    = $this->msgId;

        return $result;
    }
}