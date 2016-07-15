<?php
namespace WeChat\Message;


class WxSendMusicMsgTest extends WxSendMsgTest
{
    /**
     * @var WxSendMusicMsg
     */
    protected $sendMsg  = null;

    protected function setUp()
    {
        $this->sendMsg  = new WxSendMusicMsg();
    }

    /**
     * @return WxSendMusicMsg
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

        $data['msgType'] = WxSendMusicMsg::MSG_TYPE_MUSIC;
        $data['title'] = 'this is title';
        $data['description'] = 'this is mediaId';
        $data['thumbMediaId'] = 'this is thumbMediaId';
        $data['hQMusicUrl'] = 'this is hQMusicUrl';
        $data['hQMusicUrl'] = 'this is hQMusicUrl';
        $data['musicUrl'] = 'this is hQMusicUrl';

        $this->getSendMsg()->setTitle($data['title']);
        $this->getSendMsg()->setDescription($data['description']);
        $this->getSendMsg()->setThumbMediaId($data['thumbMediaId']);
        $this->getSendMsg()->setHQMusicUrl($data['hQMusicUrl']);
        $this->getSendMsg()->setMusicUrl($data['musicUrl']);

        $this->assertEquals($data, $this->getSendMsg()->toArray());
    }

    public function testTitleAndDescription()
    {
        $this->getSendMsg()->setTitle('title 2222');
        $this->assertEquals('title 2222', $this->getSendMsg()->getTitle());

        $this->getSendMsg()->setDescription('description 2222');
        $this->assertEquals('description 2222', $this->getSendMsg()->getDescription());
    }

    public function testThumbMediaIdAndHQMusicUrl()
    {
        $this->getSendMsg()->setHQMusicUrl('this is music url');
        $this->assertEquals('this is music url', $this->getSendMsg()->getHQMusicUrl());

        $this->getSendMsg()->setThumbMediaId('this is thumbMediaId url');
        $this->assertEquals('this is thumbMediaId url', $this->getSendMsg()->getThumbMediaId());

        $this->getSendMsg()->setMusicUrl('this is url');
        $this->assertEquals('this is url', $this->getSendMsg()->getMusicUrl());
    }

    public function testMsgType()
    {
        $this->assertEquals(WxSendMusicMsg::MSG_TYPE_MUSIC, $this->getSendMsg()->getMsgType());
    }
}
