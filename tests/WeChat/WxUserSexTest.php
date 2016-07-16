<?php
namespace WeChat;


class WxUserSexTest extends \PHPUnit_Framework_TestCase
{
    public function testWxUserSex()
    {
        $sex = new WxUserSex(WxUserSex::MALE);
        self::assertEquals(WxUserSex::MALE, $sex->getValue());

        $sex = new WxUserSex(WxUserSex::FEMALE);
        self::assertEquals(WxUserSex::FEMALE, $sex->getValue());

        $sex = new WxUserSex(WxUserSex::UNKNOWN);
        self::assertEquals(WxUserSex::UNKNOWN, $sex->getValue());

        $sex = new WxUserSex("error");
        self::assertEquals(WxUserSex::UNKNOWN, $sex->getValue());
    }
}
