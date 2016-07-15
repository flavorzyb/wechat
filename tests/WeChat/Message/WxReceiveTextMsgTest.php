<?php
namespace WeChat\Message;

class WxReceiveTextMsgTest extends WxReceiveMsgTest
{
    /**
     * @var WxReceiveTextMsg
     */
    protected $receiveMsg   = null;

    protected function setUp()
    {
        $this->receiveMsg   = new WxReceiveTextMsg();
    }

    /**
     * @return WxReceiveTextMsg
     */
    protected function getReceiveMsg()
    {
        return $this->receiveMsg;
    }

    public function testToArrayReturnArray()
    {
        $data = $this->initMsg($this->getReceiveMsg());

        $data['msgType'] = WxReceiveTextMsg::MSG_TYPE_TEXT;
        $data['content'] = 'this is test content';
        $this->getReceiveMsg()->setContent($data['content']);
        $this->assertEquals($data, $this->getReceiveMsg()->toArray());
    }

    public function testContentIsMutable()
    {
        $this->getReceiveMsg()->setContent("this is test content");
        $this->assertEquals("this is test content", $this->getReceiveMsg()->getContent());

        $this->assertEquals(WxReceiveTextMsg::MSG_TYPE_TEXT, $this->getReceiveMsg()->getMsgType());
    }
}