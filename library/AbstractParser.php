<?php
namespace WeChat;

abstract class AbstractParser
{
    /**
     * @param WxReceive $msg
     * @param array $data
     * @return WxReceive
     */
    protected function initReceive(WxReceive $msg, array $data)
    {
        $msg->setCreateTime(isset($data['CreateTime']) ? date('Y-m-d H:i:s', intval($data['CreateTime'])) : '');
        $msg->setFromUserName(isset($data['FromUserName']) ? trim($data['FromUserName']) : '');
        $msg->setToUserName(isset($data['ToUserName']) ? trim($data['ToUserName']) : '');

        return $msg;
    }
}
