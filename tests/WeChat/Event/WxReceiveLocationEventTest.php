<?php
namespace WeChat\Event;


class WxReceiveLocationEventTest extends WxReceiveEventTest
{
    /**
     * @var WxReceiveLocationEvent
     */
    protected $event    = null;

    protected function setUp()
    {
        $this->event    = new WxReceiveLocationEvent();
    }

    /**
     * @return WxReceiveScanEvent
     */
    protected function getReceiveMsg()
    {
        return $this->event;
    }

    public function testToArrayReturnArray()
    {
        $data = $this->initMsg($this->getReceiveMsg());
        $data['event']      = WxReceiveLocationEvent::EVENT_TYPE_LOCATION;
        $data['latitude']   = 23.137466;
        $data['longitude']   = 113.352425;
        $data['precision']   = 119.385040;


        $this->event->setLatitude($data['latitude']);
        $this->event->setLongitude($data['longitude']);
        $this->event->setPrecision($data['precision']);
        $this->assertEquals($data, $this->getReceiveMsg()->toArray());
    }

    public function testLocationOptionsIsMutable()
    {
        $this->event->setLatitude(23.137466);
        $this->assertEquals(23.137466, $this->event->getLatitude());

        $this->event->setLongitude(113.352425);
        $this->assertEquals(113.352425, $this->event->getLongitude());

        $this->event->setPrecision(119.385040);
        $this->assertEquals(119.385040, $this->event->getPrecision());
    }

    public function testEventIsMutable()
    {
        $this->assertEquals(WxReceiveLocationEvent::EVENT_TYPE_LOCATION, $this->event->getEvent());
    }
}