<?php
namespace WeChat;


class WxUserSubscribeTest extends \PHPUnit_Framework_TestCase
{
    public function testWxUserSubscribe()
    {
        $subscribe = new WxUserSubscribe(WxUserSubscribe::UNSUBSCRIBE);
        self::assertEquals(WxUserSubscribe::UNSUBSCRIBE, $subscribe->getValue());
        self::assertFalse($subscribe->isSubscribe());

        $subscribe = new WxUserSubscribe(WxUserSubscribe::SUBSCRIBE);
        self::assertEquals(WxUserSubscribe::SUBSCRIBE, $subscribe->getValue());
        self::assertTrue($subscribe->isSubscribe());

        $subscribe = new WxUserSubscribe("error");
        self::assertEquals(WxUserSubscribe::SUBSCRIBE, $subscribe->getValue());
        self::assertTrue($subscribe->isSubscribe());
    }
}
