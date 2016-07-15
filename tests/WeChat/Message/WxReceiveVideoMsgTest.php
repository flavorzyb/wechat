<?php
namespace WeChat\Message;

class WxReceiveVideoMsgTest extends WxReceiveMsgTest
{
    /**
     * @var WxReceiveVideoMsg
     */
    protected $receiveMsg   = null;

    protected function setUp()
    {
        $this->receiveMsg   = new WxReceiveVideoMsg();
    }

    /**
     * @return WxReceiveVideoMsg
     */
    protected function getReceiveMsg()
    {
        return $this->receiveMsg;
    }

    public function testToArrayReturnArray()
    {
        $data = $this->initMsg($this->getReceiveMsg());

        $data['msgType']        = WxReceiveTextMsg::MSG_TYPE_VIDEO;
        $data['mediaId']        = 'this is media id';
        $data['thumbMediaId']   = 'thumb_media_id';

        $this->getReceiveMsg()->setMediaId($data['mediaId']);
        $this->getReceiveMsg()->setThumbMediaId($data['thumbMediaId']);
        $this->assertEquals($data, $this->getReceiveMsg()->toArray());
    }

    public function testMediaIdIsMutable()
    {
        $this->getReceiveMsg()->setMediaId('media_id');
        $this->assertEquals('media_id', $this->getReceiveMsg()->getMediaId());

        $this->assertEquals(WxReceiveTextMsg::MSG_TYPE_VIDEO, $this->getReceiveMsg()->getMsgType());
    }

    public function testThumbMediaIdIsMutable()
    {
        $this->getReceiveMsg()->setThumbMediaId('thumb_media_id');
        $this->assertEquals('thumb_media_id', $this->getReceiveMsg()->getThumbMediaId());
    }
}
