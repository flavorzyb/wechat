<?php
namespace WeChat\Event;

class WxReceiveSubscribeEventTest extends WxReceiveEventTest
{
    /**
     * @var WxReceiveSubscribeEvent
     */
    protected $event    = null;

    protected function setUp()
    {
        $this->event    = new WxReceiveSubscribeEvent();
    }

    /**
     * @return WxReceiveSubscribeEvent
     */
    protected function getReceiveMsg()
    {
        return $this->event;
    }

    public function testToArrayReturnArray()
    {
        $data = $this->initMsg($this->getReceiveMsg());
        $data['event'] = WxReceiveSubscribeEvent::EVENT_TYPE_SUBSCRIBE;

        $this->getReceiveMsg()->setEvent($data['event']);
        $this->assertEquals($data, $this->getReceiveMsg()->toArray());
    }
}