<?php
namespace WeChat\Message;

class WxReceiveLinkMsgTest extends WxReceiveMsgTest
{
    /**
     * @var WxReceiveLinkMsg
     */
    protected $receiveMsg   = null;

    protected function setUp()
    {
        $this->receiveMsg   = new WxReceiveLinkMsg();
    }

    /**
     * @return WxReceiveLinkMsg
     */
    protected function getReceiveMsg()
    {
        return $this->receiveMsg;
    }

    public function testToArrayReturnArray()
    {
        $data = $this->initMsg($this->getReceiveMsg());

        $data['msgType'] = WxReceiveLinkMsg::MSG_TYPE_LINK;
        $data['title'] = 'this is title';
        $data['description']  = 'this is description';
        $data['url']  = 'this is url';

        $this->getReceiveMsg()->setTitle($data['title']);
        $this->getReceiveMsg()->setDescription($data['description']);
        $this->getReceiveMsg()->setUrl($data['url']);
        $this->assertEquals($data, $this->getReceiveMsg()->toArray());
    }

    public function testTitleIsMutable()
    {
        $this->getReceiveMsg()->setTitle('this is title');
        $this->assertEquals('this is title', $this->getReceiveMsg()->getTitle());

        $this->getReceiveMsg()->setDescription('this is description');
        $this->assertEquals('this is description', $this->getReceiveMsg()->getDescription());

        $this->getReceiveMsg()->setUrl('this is url');
        $this->assertEquals('this is url', $this->getReceiveMsg()->getUrl());


        $this->assertEquals(WxReceiveLinkMsg::MSG_TYPE_LINK, $this->getReceiveMsg()->getMsgType());
    }
}