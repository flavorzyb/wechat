<?php
namespace WeChat\Event;

use WeChat\XmlParser;

class ParserTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var XmlParser
     */
    protected $parser   = null;

    protected function setUp()
    {
        $this->parser   = new XmlParser();
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testParseUnknownEvent()
    {
        $str = '<xml>
                <ToUserName><![CDATA[toUser]]></ToUserName>
                <FromUserName><![CDATA[fromUser]]></FromUserName>
                <CreateTime>123456789</CreateTime>
                <MsgType><![CDATA[event]]></MsgType>
                <Event><![CDATA[UNKNOWN_EVENT]]></Event>
                <Latitude>23.137466</Latitude>
                <Longitude>113.352425</Longitude>
                <Precision>119.385040</Precision>
                </xml>';
        $this->parser->load($str);
    }

    public function testLocationEvent()
    {
        $time = time();
        $str = "<xml>
                <ToUserName><![CDATA[toUser]]></ToUserName>
                <FromUserName><![CDATA[fromUser]]></FromUserName>
                <CreateTime>{$time}</CreateTime>
                <MsgType><![CDATA[event]]></MsgType>
                <Event><![CDATA[LOCATION]]></Event>
                <Latitude>23.137466</Latitude>
                <Longitude>113.352425</Longitude>
                <Precision>119.385040</Precision>
                </xml>";

        $result = $this->parser->load($str);
        $this->assertInstanceOf('WeChat\Event\WxReceiveLocationEvent', $result);
        $this->assertEquals(date('Y-m-d H:i:s', $time), $result->getCreateTime());
        $this->toArrayNotNull($result->toArray());
    }

    public function testViewEvent()
    {
        $str = '<xml>
                <ToUserName><![CDATA[toUser]]></ToUserName>
                <FromUserName><![CDATA[FromUser]]></FromUserName>
                <CreateTime>123456789</CreateTime>
                <MsgType><![CDATA[event]]></MsgType>
                <Event><![CDATA[VIEW]]></Event>
                <EventKey><![CDATA[www.qq.com]]></EventKey>
                </xml>';

        $result = $this->parser->load($str);
        $this->assertInstanceOf('WeChat\Event\WxReceiveViewEvent', $result);
        $this->toArrayNotNull($result->toArray());
    }

    public function testClickEvent()
    {
        $str = '<xml>
                <ToUserName><![CDATA[toUser]]></ToUserName>
                <FromUserName><![CDATA[FromUser]]></FromUserName>
                <CreateTime>123456789</CreateTime>
                <MsgType><![CDATA[event]]></MsgType>
                <Event><![CDATA[CLICK]]></Event>
                <EventKey><![CDATA[EVENTKEY]]></EventKey>
                </xml>';

        $result = $this->parser->load($str);
        $this->assertInstanceOf('WeChat\Event\WxReceiveClickEvent', $result);
        $this->toArrayNotNull($result->toArray());
    }

    public function testScanEvent()
    {
        $str = '<xml>
                <ToUserName><![CDATA[toUser]]></ToUserName>
                <FromUserName><![CDATA[FromUser]]></FromUserName>
                <CreateTime>123456789</CreateTime>
                <MsgType><![CDATA[event]]></MsgType>
                <Event><![CDATA[SCAN]]></Event>
                <EventKey><![CDATA[SCENE_VALUE]]></EventKey>
                <Ticket><![CDATA[TICKET]]></Ticket>
                </xml>';

        $result = $this->parser->load($str);
        $this->assertInstanceOf('WeChat\Event\WxReceiveScanEvent', $result);
        $this->toArrayNotNull($result->toArray());
    }

    public function testScanSubscribeEvent()
    {
        $str = '<xml><ToUserName><![CDATA[toUser]]></ToUserName>
                <FromUserName><![CDATA[FromUser]]></FromUserName>
                <CreateTime>123456789</CreateTime>
                <MsgType><![CDATA[event]]></MsgType>
                <Event><![CDATA[subscribe]]></Event>
                <EventKey><![CDATA[qrscene_123123]]></EventKey>
                <Ticket><![CDATA[TICKET]]></Ticket>
                </xml>';

        $result = $this->parser->load($str);
        $this->assertInstanceOf('WeChat\Event\WxReceiveScanEvent', $result);
        $this->toArrayNotNull($result->toArray());
    }

    public function testSubscribeEvent()
    {
        $str = '<xml>
                <ToUserName><![CDATA[toUser]]></ToUserName>
                <FromUserName><![CDATA[FromUser]]></FromUserName>
                <CreateTime>123456789</CreateTime>
                <MsgType><![CDATA[event]]></MsgType>
                <Event><![CDATA[subscribe]]></Event>
                </xml>';

        $result = $this->parser->load($str);
        $this->assertInstanceOf('WeChat\Event\WxReceiveSubscribeEvent', $result);
        $this->toArrayNotNull($result->toArray());
    }

    protected function toArrayNotNull(array $data)
    {
        unset($data['id']);
        foreach ($data as $v) {
            $this->assertNotNull($v);
        }
    }
}