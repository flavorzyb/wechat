<?php
namespace WeChat\Message;

use WeChat\XmlParser;
use Exception;

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
    public function testParseUnsetMsgType()
    {
        $str = '<xml>
                <ToUserName><![CDATA[toUser]]></ToUserName>
                <FromUserName><![CDATA[fromUser]]></FromUserName>
                <CreateTime>1348831860</CreateTime>
                <Content><![CDATA[this is a test]]></Content>
                <MsgId>1234567890123456</MsgId>
                </xml>';
        $this->parser->load($str);
    }

    /**
     * @expectedException Exception
     */
    public function testParseUnknownMsgType()
    {
        $str = '<xml>
                <ToUserName><![CDATA[toUser]]></ToUserName>
                <FromUserName><![CDATA[fromUser]]></FromUserName>
                <CreateTime>1348831860</CreateTime>
                <MsgType><![CDATA[unknown type]]></MsgType>
                <Content><![CDATA[this is a test]]></Content>
                <MsgId>1234567890123456</MsgId>
                </xml>';
        $this->parser->load($str);
    }

//    /**
//     * @expectedException Exception
//     */
//    public function testParseErrorStr()
//    {
//        $str = 'error string';
//        $this->parser->load($str);
//    }

    public function testParseTextMsg()
    {
        $time = time();

        $str = "<xml>
                <ToUserName><![CDATA[toUser]]></ToUserName>
                <FromUserName><![CDATA[fromUser]]></FromUserName>
                <CreateTime>{$time}</CreateTime>
                <MsgType><![CDATA[text]]></MsgType>
                <Content><![CDATA[this is a test]]></Content>
                <MsgId>1234567890123456</MsgId>
                </xml>";
        $result = $this->parser->load($str);
        $this->assertInstanceOf('WeChat\Message\WxReceiveTextMsg', $result);
        $this->assertEquals(date('Y-m-d H:i:s', $time), $result->getCreateTime());
        $this->toArrayNotNull($result->toArray());
    }

    public function testParseTextMsgErrorContent()
    {
        $time = time();

        $str = "<xml>
                <ToUserName><![CDATA[toUser]]></ToUserName>
                <FromUserName><![CDATA[fromUser]]></FromUserName>
                <CreateTime>{$time}</CreateTime>
                <MsgType><![CDATA[text]]></MsgType>
                <Content></Content>
                <MsgId>1234567890123456</MsgId>
                </xml>";
        $result = $this->parser->load($str);
        $this->assertInstanceOf('WeChat\Message\WxReceiveTextMsg', $result);
        $this->assertEquals(date('Y-m-d H:i:s', $time), $result->getCreateTime());
        $this->toArrayNotNull($result->toArray());
    }

    public function testParseImageMsg()
    {
        $str = '<xml>
                <ToUserName><![CDATA[toUser]]></ToUserName>
                <FromUserName><![CDATA[fromUser]]></FromUserName>
                <CreateTime>1348831860</CreateTime>
                <MsgType><![CDATA[image]]></MsgType>
                <PicUrl><![CDATA[this is a url]]></PicUrl>
                <MediaId><![CDATA[media_id]]></MediaId>
                <MsgId>1234567890123456</MsgId>
                </xml>';

        $result = $this->parser->load($str);
        $this->assertInstanceOf('WeChat\Message\WxReceiveImageMsg', $result);
        $this->toArrayNotNull($result->toArray());
    }

    public function testParseLinkMsg()
    {
        $str = '<xml>
                <ToUserName><![CDATA[toUser]]></ToUserName>
                <FromUserName><![CDATA[fromUser]]></FromUserName>
                <CreateTime>1351776360</CreateTime>
                <MsgType><![CDATA[link]]></MsgType>
                <Title><![CDATA[公众平台官网链接]]></Title>
                <Description><![CDATA[公众平台官网链接]]></Description>
                <Url><![CDATA[url]]></Url>
                <MsgId>1234567890123456</MsgId>
                </xml>';
        $result = $this->parser->load($str);
        $this->assertInstanceOf('WeChat\Message\WxReceiveLinkMsg', $result);
        $this->toArrayNotNull($result->toArray());
    }

    public function testParseLocationMsg()
    {
        $str = '<xml>
                <ToUserName><![CDATA[toUser]]></ToUserName>
                <FromUserName><![CDATA[fromUser]]></FromUserName>
                <CreateTime>1351776360</CreateTime>
                <MsgType><![CDATA[location]]></MsgType>
                <Location_X>23.134521</Location_X>
                <Location_Y>113.358803</Location_Y>
                <Scale>20</Scale>
                <Label><![CDATA[位置信息]]></Label>
                <MsgId>1234567890123456</MsgId>
                </xml>';
        $result = $this->parser->load($str);
        $this->assertInstanceOf('WeChat\Message\WxReceiveLocationMsg', $result);
        $this->toArrayNotNull($result->toArray());
    }

    public function testParseVideoMsg()
    {
        $str = '<xml>
                <ToUserName><![CDATA[toUser]]></ToUserName>
                <FromUserName><![CDATA[fromUser]]></FromUserName>
                <CreateTime>1357290913</CreateTime>
                <MsgType><![CDATA[video]]></MsgType>
                <MediaId><![CDATA[media_id]]></MediaId>
                <ThumbMediaId><![CDATA[thumb_media_id]]></ThumbMediaId>
                <MsgId>1234567890123456</MsgId>
                </xml>';
        $result = $this->parser->load($str);
        $this->assertInstanceOf('WeChat\Message\WxReceiveVideoMsg', $result);
        $this->toArrayNotNull($result->toArray());
    }

    public function testParseShortVideoMsg()
    {
        $str = '<xml>
                <ToUserName><![CDATA[toUser]]></ToUserName>
                <FromUserName><![CDATA[fromUser]]></FromUserName>
                <CreateTime>1357290913</CreateTime>
                <MsgType><![CDATA[shortvideo]]></MsgType>
                <MediaId><![CDATA[media_id]]></MediaId>
                <ThumbMediaId><![CDATA[thumb_media_id]]></ThumbMediaId>
                <MsgId>1234567890123456</MsgId>
                </xml>';
        $result = $this->parser->load($str);
        $this->assertInstanceOf('WeChat\Message\WxReceiveShortVideoMsg', $result);
        $this->toArrayNotNull($result->toArray());
    }

    public function testParseVoiceMsg()
    {
        $str = '<xml>
                <ToUserName><![CDATA[toUser]]></ToUserName>
                <FromUserName><![CDATA[fromUser]]></FromUserName>
                <CreateTime>1357290913</CreateTime>
                <MsgType><![CDATA[voice]]></MsgType>
                <MediaId><![CDATA[media_id]]></MediaId>
                <Format><![CDATA[Format]]></Format>
                <MsgId>1234567890123456</MsgId>
                </xml>';
        $result = $this->parser->load($str);
        $this->assertInstanceOf('WeChat\Message\WxReceiveVoiceMsg', $result);
        $this->toArrayNotNull($result->toArray());
    }

    protected function toArrayNotNull(array $data)
    {
        unset($data['id']);
        unset($data['lessonId']);
        unset($data['upTime']);
        foreach ($data as $v) {
            $this->assertNotNull($v);
        }
    }
}