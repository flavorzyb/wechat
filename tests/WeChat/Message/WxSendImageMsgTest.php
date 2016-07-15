<?php
namespace WeChat\Message;


class WxSendImageMsgTest extends WxSendMsgTest
{
    /**
     * @var WxSendImageMsg
     */
    protected $sendMsg  = null;

    protected function setUp()
    {
        $this->sendMsg  = new WxSendImageMsg();
    }

    /**
     * @return WxSendImageMsg
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

        $data['msgType'] = WxSendImageMsg::MSG_TYPE_IMAGE;
        $data['mediaId'] = 'this is mediaId';

        $this->getSendMsg()->setMediaId($data['mediaId']);

        $this->assertEquals($data, $this->getSendMsg()->toArray());
    }

    public function testMediaIdIsMutable()
    {
        $this->getSendMsg()->setMediaId('this is a mediaId 2222');
        $this->assertEquals('this is a mediaId 2222', $this->getSendMsg()->getMediaId());
    }

    public function testMsgType()
    {
        $this->assertEquals(WxSendImageMsg::MSG_TYPE_IMAGE, $this->getSendMsg()->getMsgType());
    }
}
