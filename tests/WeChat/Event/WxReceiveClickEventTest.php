<?php
namespace WeChat\Event;


class WxReceiveClickEventTest extends WxReceiveViewEventTest
{
    /**
     * @var WxReceiveClickEvent
     */
    protected $event    = null;

    protected function setUp()
    {
        $this->event    = new WxReceiveClickEvent();
    }

    /**
     * @return WxReceiveClickEvent
     */
    protected function getReceiveMsg()
    {
        return $this->event;
    }

    public function testToArrayReturnArray()
    {
        $data = $this->initMsg($this->getReceiveMsg());
        $data['event']      = WxReceiveClickEvent::EVENT_TYPE_CLICK;
        $data['eventKey']   = 'EVENT_KEY';

        $this->getReceiveMsg()->setEventKey($data['eventKey']);

        $this->assertEquals($data, $this->getReceiveMsg()->toArray());
    }

    public function testViewOptionsIsMutable()
    {
        $this->getReceiveMsg()->setEventKey('EVENT_KEY');
        $this->assertEquals('EVENT_KEY', $this->event->getEventKey());
    }

    public function testEventIsMutable()
    {
        $this->assertEquals(WxReceiveClickEvent::EVENT_TYPE_CLICK, $this->event->getEvent());
    }
}