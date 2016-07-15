<?php
namespace WeChat\Event;

class WxReceiveScanEventTest extends WxReceiveEventTest
{
    /**
     * @var WxReceiveScanEvent
     */
    protected $event    = null;

    protected function setUp()
    {
        $this->event    = new WxReceiveScanEvent();
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
        $data['event']      = WxReceiveSubscribeEvent::EVENT_TYPE_SUBSCRIBE;
        $data['eventKey']   = 'qrscene_123123';
        $data['ticket']     = 'TICKET';


        $this->getReceiveMsg()->setEvent($data['event']);
        $this->event->setEventKey($data['eventKey']);
        $this->event->setTicket($data['ticket']);
        $this->assertEquals($data, $this->getReceiveMsg()->toArray());
    }

    public function testEventKeyIsMutable()
    {
        $this->event->setEventKey('qrscene_123123');
        $this->assertEquals('qrscene_123123', $this->event->getEventKey());
    }

    public function testTicketIsMutable()
    {
        $this->event->setTicket('ticket_1234');
        $this->assertEquals('ticket_1234', $this->event->getTicket());
    }
}