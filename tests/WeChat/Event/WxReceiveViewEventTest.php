<?php
namespace WeChat\Event;

class WxReceiveViewEventTest extends WxReceiveEventTest
{
    /**
     * @var WxReceiveViewEvent
     */
    protected $event    = null;

    protected function setUp()
    {
        $this->event    = new WxReceiveViewEvent();
    }

    /**
     * @return WxReceiveViewEvent
     */
    protected function getReceiveMsg()
    {
        return $this->event;
    }

    public function testToArrayReturnArray()
    {
        $data = $this->initMsg($this->getReceiveMsg());
        $data['event']      = WxReceiveViewEvent::EVENT_TYPE_VIEW;
        $data['eventKey']   = 'www.qq.com';

        $this->getReceiveMsg()->setEventKey($data['eventKey']);

        $this->assertEquals($data, $this->getReceiveMsg()->toArray());
    }

    public function testViewOptionsIsMutable()
    {
        $this->getReceiveMsg()->setEventKey('www.qq.com');
        $this->assertEquals('www.qq.com', $this->event->getEventKey());
    }

    public function testEventIsMutable()
    {
        $this->assertEquals(WxReceiveViewEvent::EVENT_TYPE_VIEW, $this->event->getEvent());
    }
}
