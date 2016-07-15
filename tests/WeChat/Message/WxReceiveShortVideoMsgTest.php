<?php
/**
 * Created by PhpStorm.
 * User: flavor
 * Date: 16/7/15
 * Time: 19:26
 */

namespace WeChat\Message;

class WxReceiveShortVideoMsgTest extends WxReceiveVideoMsgTest
{
    /**
     * @var WxReceiveShortVideoMsg
     */
    protected $receiveMsg   = null;

    protected function setUp()
    {
        $this->receiveMsg   = new WxReceiveShortVideoMsg();
    }

    /**
     * @return WxReceiveShortVideoMsg
     */
    protected function getReceiveMsg()
    {
        return $this->receiveMsg;
    }

    public function testToArrayReturnArray()
    {
        $data = $this->initMsg($this->getReceiveMsg());

        $data['msgType']        = WxReceiveShortVideoMsg::MSG_TYPE_SHORT_VIDEO;
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

        $this->assertEquals(WxReceiveShortVideoMsg::MSG_TYPE_SHORT_VIDEO, $this->getReceiveMsg()->getMsgType());
    }
}