<?php
namespace WeChat\Message;

class WxReceiveVoiceMsgTest extends WxReceiveMsgTest
{
    /**
     * @var WxReceiveVoiceMsg
     */
    protected $receiveMsg   = null;

    protected function setUp()
    {
        $this->receiveMsg   = new WxReceiveVoiceMsg();
    }

    /**
     * @return WxReceiveVoiceMsg
     */
    protected function getReceiveMsg()
    {
        return $this->receiveMsg;
    }

    public function testToArrayReturnArray()
    {
        $data = $this->initMsg($this->getReceiveMsg());

        $data['msgType'] = WxReceiveTextMsg::MSG_TYPE_VOICE;
        $data['mediaId'] = 'this is media id';
        $data['format']  = 'amr';

        $this->getReceiveMsg()->setMediaId($data['mediaId']);
        $this->getReceiveMsg()->setFormat($data['format']);
        $this->assertEquals($data, $this->getReceiveMsg()->toArray());
    }

    public function testMediaIdIsMutable()
    {
        $this->getReceiveMsg()->setMediaId('media_id');
        $this->assertEquals('media_id', $this->getReceiveMsg()->getMediaId());

        $this->assertEquals(WxReceiveTextMsg::MSG_TYPE_VOICE, $this->getReceiveMsg()->getMsgType());
    }

    public function testFormatIsMutable()
    {
        $this->getReceiveMsg()->setFormat('speex');
        $this->assertEquals('speex', $this->getReceiveMsg()->getFormat());
    }
}