<?php
namespace WeChat\Message;


class WxSendTextMsgTest extends WxSendMsgTest
{
    /**
     * @var WxSendTextMsg
     */
    protected $sendMsg  = null;

    protected function setUp()
    {
        $this->sendMsg  = new WxSendTextMsg();
    }

    /**
     * @return WxSendTextMsg
     */
    protected function getSendMsg()
    {
        return $this->sendMsg;
    }

    /**
     *
     */
    public function testToArrayReturnArray()
    {
        $data = $this->initMsg($this->getSendMsg());

        $data['msgType'] = WxSendTextMsg::MSG_TYPE_TEXT;
        $data['content'] = 'this is content';

        $this->getSendMsg()->setContent($data['content']);

        $this->assertEquals($data, $this->getSendMsg()->toArray());
    }

    public function testContentIsMutable()
    {
        $this->getSendMsg()->setContent('this is a content 2222');
        $this->assertEquals('this is a content 2222', $this->getSendMsg()->getContent());
    }

    public function testMsgType()
    {
        $this->assertEquals(WxSendTextMsg::MSG_TYPE_TEXT, $this->getSendMsg()->getMsgType());
    }
}
