<?php
namespace WeChat\Message;

use WeChat\WxReceiveTest;
use WeChat\WxReceive;

abstract class WxReceiveMsgTest extends WxReceiveTest
{
    protected function initMsg(WxReceive $msg)
    {
        $data = parent::initMsg($msg);
        $data['msgId']  = mt_rand();

        $msg->setMsgId($data['msgId']);

        return $data;
    }

    public function testMsgIdIsMutable()
    {
        $msg = mt_rand();
        $this->getReceiveMsg()->setMsgId($msg);
        $this->assertEquals($msg, $this->getReceiveMsg()->getMsgId());
    }
}