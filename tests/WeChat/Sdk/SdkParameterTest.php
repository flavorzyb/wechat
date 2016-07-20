<?php
namespace WeChat\Sdk;


class SdkParameterTest extends \PHPUnit_Framework_TestCase
{
    public function testOptionsIsMutable()
    {
        $params = new SdkParameter();
        $params->setAppId("appId");
        $params->setAppSecret("appSecret");
        $params->setTokenString("tokenString");
        $params->setTokenFilePath("tokenFilePath");
        $params->setTicketFilePath("TicketFilePath");

        self::assertEquals("appId", $params->getAppId());
        self::assertEquals("appSecret", $params->getAppSecret());
        self::assertEquals("tokenFilePath", $params->getTokenFilePath());
        self::assertEquals("tokenString", $params->getTokenString());
        self::assertEquals("TicketFilePath", $params->getTicketFilePath());
    }
}
