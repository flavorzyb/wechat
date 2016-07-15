<?php
namespace WeChat\Message;

class WxSendVoiceMsgTest extends WxSendMsgTest
{
    /**
     * @var WxSendVoiceMsg
     */
    protected $sendMsg  = null;

    protected function setUp()
    {
        $this->sendMsg  = new WxSendVoiceMsg();
    }

    /**
     * @return WxSendVoiceMsg
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

        $data['msgType'] = WxSendVoiceMsg::MSG_TYPE_VOICE;
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
        $this->assertEquals(WxSendVoiceMsg::MSG_TYPE_VOICE, $this->getSendMsg()->getMsgType());
    }
}
