<?php
/**
 * Created by PhpStorm.
 * User: flavor
 * Date: 15/8/20
 * Time: 下午3:34
 */

namespace WeChat\Message;

use Mockery as m;

class FormatterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Formatter
     */
    protected $formatter    = null;

    protected function setUp()
    {
        $this->formatter    = new Formatter();
    }

    protected function initSendMsg(WxSendMsg $msg)
    {
        $msg->setCreateTime(date('Y-m-d H:i:s'));
        $msg->setFromUserName("from user name");
        $msg->setToUserName("to user name");
    }

    public function testSendTextMsgToXml()
    {
        $msg = new WxSendTextMsg();
        $this->initSendMsg($msg);
        $msg->setContent("text content");

        $result = $this->formatter->toXmlString($msg);
        $this->assertTrue(strlen($result) > 0);

        $result = $this->formatter->toJsonString($msg);
        $data = json_decode($result, true);
        $this->assertTrue(isset($data['text']));
    }

    public function testSendImageMsgToXml()
    {
        $msg = new WxSendImageMsg();
        $this->initSendMsg($msg);
        $msg->setMediaId('media id');
        $result = $this->formatter->toXmlString($msg);
        $this->assertTrue(strlen($result) > 0);

        $result = $this->formatter->toJsonString($msg);
        $data = json_decode($result, true);
        $this->assertTrue(isset($data['image']));
    }

    public function testSendVoiceMsgToXml()
    {
        $msg = new WxSendVoiceMsg();
        $this->initSendMsg($msg);
        $msg->setMediaId('media id');
        $result = $this->formatter->toXmlString($msg);
        $this->assertTrue(strlen($result) > 0);

        $result = $this->formatter->toJsonString($msg);
        $data = json_decode($result, true);
        $this->assertTrue(isset($data['voice']));
    }

    public function testSendVideoMsgToXml()
    {
        $msg = new WxSendVideoMsg();
        $this->initSendMsg($msg);
        $msg->setMediaId('media id');
        $msg->setTitle("title");
        $msg->setDescription("description");
        $result = $this->formatter->toXmlString($msg);
        $this->assertTrue(strlen($result) > 0);

        $result = $this->formatter->toJsonString($msg);
        $data = json_decode($result, true);
        $this->assertTrue(isset($data['video']));
    }

    public function testSendMusicMsgToXml()
    {
        $msg = new WxSendMusicMsg();
        $this->initSendMsg($msg);
        $msg->setTitle("title");
        $msg->setDescription("description");
        $msg->setHQMusicUrl('hq music url');
        $msg->setMusicUrl('music url');
        $msg->setThumbMediaId('ThumbMediaId');

        $result = $this->formatter->toXmlString($msg);
        $this->assertTrue(strlen($result) > 0);

        $result = $this->formatter->toJsonString($msg);
        $data = json_decode($result, true);
        $this->assertTrue(isset($data['music']));
    }

    public function testSendNewsMsgToXml()
    {
        $msg = new WxSendNewsMsg();
        $this->initSendMsg($msg);

        $item = new WxSendNewsMsgItem();
        $item->setUrl('url 11');
        $item->setPicUrl('url 22');
        $item->setTitle('title 11');
        $item->setDescription('description 33');

        $msg->addArticleItem($item);
        $result = $this->formatter->toXmlString($msg);
        $this->assertTrue(strlen($result) > 0);

        $result = $this->formatter->toJsonString($msg);
        $data = json_decode($result, true);
        $this->assertTrue(isset($data['news']));
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testSendMsgToXmlStringThrowException()
    {
        $msg = m::mock('WeChat\Message\WxSendMsg');
        $this->formatter->toXmlString($msg);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testSendMsgToJsonStringThrowException()
    {
        $msg = m::mock('WeChat\Message\WxSendMsg');
        $this->formatter->toJsonString($msg);
    }
}
