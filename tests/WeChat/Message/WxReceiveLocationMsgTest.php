<?php
namespace WeChat\Message;

class WxReceiveLocationMsgTest extends WxReceiveMsgTest
{
    /**
     * @var WxReceiveLocationMsg
     */
    protected $receiveMsg   = null;

    protected function setUp()
    {
        $this->receiveMsg   = new WxReceiveLocationMsg();
    }

    /**
     * @return WxReceiveLocationMsg
     */
    protected function getReceiveMsg()
    {
        return $this->receiveMsg;
    }

    public function testToArrayReturnArray()
    {
        $data = $this->initMsg($this->getReceiveMsg());

        $data['msgType']        = WxReceiveTextMsg::MSG_TYPE_LOCATION;
        $data['locationX']      = 12.763;
        $data['locationY']      = 13.4632;
        $data['scale']          = 20;
        $data['label']          = 'this is a label';

        $this->getReceiveMsg()->setLocationX($data['locationX']);
        $this->getReceiveMsg()->setLocationY($data['locationY']);
        $this->getReceiveMsg()->setScale($data['scale']);
        $this->getReceiveMsg()->setLabel($data['label']);
        $this->assertEquals($data, $this->getReceiveMsg()->toArray());
    }

    public function testLocationIsMutable()
    {
        $this->getReceiveMsg()->setLocationX(16.213);
        $this->assertEquals(16.213, $this->getReceiveMsg()->getLocationX());

        $this->getReceiveMsg()->setLocationY(16.213);
        $this->assertEquals(16.213, $this->getReceiveMsg()->getLocationY());

        $this->assertEquals(WxReceiveTextMsg::MSG_TYPE_LOCATION, $this->getReceiveMsg()->getMsgType());
    }

    public function testScaleAndLabelIsMutable()
    {
        $this->getReceiveMsg()->setScale(16);
        $this->assertEquals(16, $this->getReceiveMsg()->getScale());

        $this->getReceiveMsg()->setLabel('this is a label');
        $this->assertEquals('this is a label', $this->getReceiveMsg()->getLabel());
    }
}