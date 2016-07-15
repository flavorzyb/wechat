<?php
namespace WeChat\Message;


class WxSendNewsMsgTest extends WxSendMsgTest
{
    /**
     * @var WxSendNewsMsg
     */
    protected $sendMsg  = null;

    protected function setUp()
    {
        $this->sendMsg  = new WxSendNewsMsg();
    }

    /**
     * @return WxSendNewsMsg
     */
    protected function getSendMsg()
    {
        return $this->sendMsg;
    }

    protected function createItem()
    {
        $result    = new WxSendNewsMsgItem();
        $data   = [
            'title'         => 'this is title' . mt_rand(),
            'description'   => 'this is a description' . mt_rand(),
            'picUrl'        => 'this is pic url' . mt_rand(),
            'url'           => 'this is url' . mt_rand(),
        ];

        $result->setTitle($data['title']);
        $result->setDescription($data['description']);
        $result->setPicUrl($data['picUrl']);
        $result->setUrl($data['url']);

        return $result;
    }
    /**
     *
     */
    public function testToArrayReturnArray()
    {
        $data = $this->initMsg($this->getSendMsg());
        $data['msgType']    = WxSendNewsMsg::MSG_TYPE_NEWS;
        $data['articles']   = [];
        for ($i = 0; $i < 9; $i++) {
            $item = $this->createItem();
            $data['articles'][] = $item->toArray();
            $this->getSendMsg()->addArticleItem($item);
        }

        $this->assertEquals($data, $this->getSendMsg()->toArray());
    }

    public function testContentIsMutable()
    {
        for ($i = 0; $i < 19; $i++) {
            $item = $this->createItem();
            $this->getSendMsg()->addArticleItem($item);
        }

        $this->assertEquals(10, $this->getSendMsg()->getArticleCount());
        $articles = $this->getSendMsg()->getAllArticleItems();
        $this->assertEquals(10, sizeof($articles));
    }

    public function testMsgType()
    {
        $this->assertEquals(WxSendNewsMsg::MSG_TYPE_NEWS, $this->getSendMsg()->getMsgType());
    }
}
