<?php
namespace WeChat\Event;

use WeChat\WxReceiveTest;
use WeChat\WxReceive;

abstract class WxReceiveEventTest extends WxReceiveTest
{
    protected function initMsg(WxReceive $msg)
    {
        $data = parent::initMsg($msg);
        $data['msgType']    = WxReceiveEvent::MSG_TYPE_EVENT;

        return $data;
    }

    public function testEventIsMutable()
    {
        $this->getReceiveMsg()->setEvent(WxReceiveEvent::EVENT_TYPE_SUBSCRIBE);
        $this->assertEquals(WxReceiveEvent::EVENT_TYPE_SUBSCRIBE, $this->getReceiveMsg()->getEvent());
    }

    public function testMsgType()
    {
        $this->assertEquals(WxReceiveEvent::MSG_TYPE_EVENT, $this->getReceiveMsg()->getMsgType());
    }
}