<?php
namespace WeChat\Message;

class WxSendVideoMsgTest extends WxSendMsgTest
{
    /**
     * @var WxSendVideoMsg
     */
    protected $sendMsg  = null;

    protected function setUp()
    {
        $this->sendMsg  = new WxSendVideoMsg();
    }

    /**
     * @return WxSendVideoMsg
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

        $data['msgType'] = WxSendVideoMsg::MSG_TYPE_VIDEO;
        $data['mediaId'] = 'this is mediaId';
        $data['title'] = 'this is title';
        $data['description'] = 'this is description';
        $data['thumbMediaId'] = 'this is thumbMediaId';

        $this->getSendMsg()->setMediaId($data['mediaId']);
        $this->getSendMsg()->setTitle($data['title']);
        $this->getSendMsg()->setDescription($data['description']);
        $this->getSendMsg()->setThumbMediaId($data['thumbMediaId']);

        $this->assertEquals($data, $this->getSendMsg()->toArray());
    }

    public function testTitleAndDescription()
    {
        $this->getSendMsg()->setTitle('title 2222');
        $this->assertEquals('title 2222', $this->getSendMsg()->getTitle());

        $this->getSendMsg()->setDescription('description 2222');
        $this->assertEquals('description 2222', $this->getSendMsg()->getDescription());
    }

    public function testMediaIdIsMutable()
    {
        $this->getSendMsg()->setMediaId('this is a mediaId 2222');
        $this->assertEquals('this is a mediaId 2222', $this->getSendMsg()->getMediaId());
    }

    public function testMsgType()
    {
        $this->assertEquals(WxSendVideoMsg::MSG_TYPE_VIDEO, $this->getSendMsg()->getMsgType());
    }
}
