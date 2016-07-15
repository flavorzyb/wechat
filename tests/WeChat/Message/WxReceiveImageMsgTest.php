<?php
namespace WeChat\Message;

class WxReceiveImageMsgTest extends WxReceiveMsgTest
{
    /**
     * @var WxReceiveImageMsg
     */
    protected $receiveMsg   = null;

    protected function setUp()
    {
        $this->receiveMsg   = new WxReceiveImageMsg();
    }

    /**
     * @return WxReceiveImageMsg
     */
    protected function getReceiveMsg()
    {
        return $this->receiveMsg;
    }

    public function testToArrayReturnArray()
    {
        $data = $this->initMsg($this->getReceiveMsg());

        $data['msgType'] = WxReceiveTextMsg::MSG_TYPE_IMAGE;
        $data['mediaId'] = 'this is media id';
        $data['picUrl']  = 'this is a pic url';

        $this->getReceiveMsg()->setPicUrl($data['picUrl']);
        $this->getReceiveMsg()->setMediaId($data['mediaId']);
        $this->assertEquals($data, $this->getReceiveMsg()->toArray());
    }

    public function testMediaIdIsMutable()
    {
        $this->getReceiveMsg()->setMediaId('media_id');
        $this->assertEquals('media_id', $this->getReceiveMsg()->getMediaId());

        $this->assertEquals(WxReceiveTextMsg::MSG_TYPE_IMAGE, $this->getReceiveMsg()->getMsgType());
    }

    public function testPicUrlIsMutable()
    {
        $this->getReceiveMsg()->setPicUrl('this is a pic url');
        $this->assertEquals('this is a pic url', $this->getReceiveMsg()->getPicUrl());
    }
}