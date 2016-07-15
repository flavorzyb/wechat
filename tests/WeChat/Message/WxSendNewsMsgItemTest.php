<?php
namespace WeChat\Message;


class WxSendNewsMsgItemTest extends \PHPUnit_Framework_TestCase
{
    public function testSendNewsMsgItem()
    {
        $msg    = new WxSendNewsMsgItem();
        $data   = [
                    'title'         => 'this is title',
                    'description'   => 'this is a description',
                    'picUrl'        => 'this is pic url',
                    'url'           => 'this is url',
                ];

        $msg->setTitle($data['title']);
        $this->assertEquals($data['title'], $msg->getTitle());
        $msg->setDescription($data['description']);
        $this->assertEquals($data['description'], $msg->getDescription());
        $msg->setPicUrl($data['picUrl']);
        $this->assertEquals($data['picUrl'], $msg->getPicUrl());
        $msg->setUrl($data['url']);
        $this->assertEquals($data['url'], $msg->getUrl());

        $this->assertEquals($data, $msg->toArray());
    }
}
