<?php
namespace WeChat;

use Mockery as m;
use Simple\Http\Client;
use Wechat\Message\WxSendTextMsg;
use \Exception;
use WeChat\Sdk\AccessToken;
use WeChat\Sdk\JsApiTicket;

class MockSDK extends Sdk
{
    protected $client = null;
    public function getHttpClient()
    {
        if (null == $this->client) {
            $this->client = parent::getHttpClient();
        }

        return $this->client;
    }

    public function setHttpClient(Client $client)
    {
        $this->client = $client;
    }
}

class SdkTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var MockSDK
     */
    protected $sdk  = null;
    protected $appId = "wxd0e9c95e";
    protected $appSecret = "44e8ae2cb1fd864d6d6";
    protected $tokenString = "93881ad73f6494c383";
    protected $tokenFilePath = null;
    protected $jsApiTokenFilePath = null;
    protected function setUp()
    {
        $this->tokenFilePath = __DIR__ . '/access_token_sdk.log';
        $this->jsApiTokenFilePath = __DIR__ . '/js_api_token_sdk.log';
        $this->sdk  = new MockSDK($this->appId, $this->appSecret, $this->tokenFilePath);
        $this->sdk->setTokenString($this->tokenString);
        $this->sdk->setAccessToken($this->getAccessTokenMockObject());
        $this->sdk->setFileSystem($this->getMockFileStemInstance());
        $this->sdk->setJsApiTicket($this->getJsApiTicketMockInstance());
    }

    protected function tearDown()
    {
        if (is_file($this->tokenFilePath)) {
            unlink($this->tokenFilePath);
        }
        if (is_file($this->jsApiTokenFilePath)) {
            unlink($this->jsApiTokenFilePath);
        }
        parent::tearDown();
    }

    public function testGetOptions()
    {
        $this->sdk  = new MockSDK($this->appId, $this->appSecret, $this->tokenFilePath);
        $this->sdk->setTokenString($this->tokenString);
        self::assertNull($this->sdk->getAccessToken());
        self::assertNull($this->sdk->getJsApiTicket());

        $accessToken = new AccessToken($this->appId, $this->appSecret, $this->tokenFilePath);
        $this->sdk->setAccessToken($accessToken);
        $this->sdk->setJsApiTicket(new JsApiTicket($accessToken, $this->jsApiTokenFilePath));

        $this->assertEquals($this->tokenString, $this->sdk->getTokenString());
        $this->assertEquals($this->appId, $this->sdk->getAppId());
        $this->assertEquals($this->appSecret, $this->sdk->getAppSecret());
        $this->assertEquals($this->tokenFilePath, $this->sdk->getTokenFilePath());
        $this->assertInstanceOf('Simple\Http\Client', $this->sdk->getHttpClient());
        $this->assertInstanceOf('Simple\Filesystem\Filesystem', $this->sdk->getFileSystem());
        $this->assertInstanceOf('WeChat\Message\Formatter', $this->sdk->getFormatter());
        $this->assertInstanceOf('WeChat\Sdk\AccessToken', $this->sdk->getAccessToken());
        $this->assertInstanceOf('WeChat\Sdk\JsApiTicket', $this->sdk->getJsApiTicket());
    }

    protected function getMockFileStemInstance()
    {
        $result = m::mock('\Simple\Filesystem\Filesystem');
        $result->shouldReceive('put')->andReturn(123);

        return $result;
    }

    protected function getAccessTokenMockObject()
    {
        $result = m::mock('WeChat\Sdk\AccessToken');
        $result->shouldReceive('getAccessToken')->andReturn('EzRtOIyhtajmOULGdxC8ttpP-q8hnUSAp5miw7UNbvEmkgBhSnwgpzZoJq2E4qywuUYrim0OHw5QqXyE0jlYSNsORLzmpBVXsS3rkG6ZmVA');
        return $result;
    }

    protected function getHttpClientMockInstance()
    {
        $result = m::mock('Simple\Http\Client');

        $result->shouldReceive('setUrl');
        $result->shouldReceive('setHeaderArray');
        $result->shouldReceive('setMethod');
        $result->shouldReceive('setPostFields');
        $result->shouldReceive('setPostDataArray');

        return $result;
    }

    /**
     * @return m\MockInterface
     */
    protected function getHttpClientMockExecReturnTrue()
    {
        $result = $this->getHttpClientMockInstance();
        $result->shouldReceive('exec')->andReturn(true);
        return $result;
    }

    /**
     * @return m\MockInterface
     */
    protected function getHttpClientMockExecReturnFalse()
    {
        $result = $this->getHttpClientMockInstance();
        $result->shouldReceive('exec')->andReturn(false);
        return $result;
    }

    protected function getJsApiTicketMockInstance() {
        $result = m::mock('WeChat\Sdk\JsApiTick');
        $result->shouldReceive("getTicket")->andReturn("abcdefghijklmnopqrstuvwxyz0123456789");

        return $result;
    }

    public function testMenu()
    {
        $str = ' {
                 "button":[
                 {
                      "type":"click",
                      "name":"今日歌曲",
                      "key":"V1001_TODAY_MUSIC"
                  },
                  {
                       "name":"菜单",
                       "sub_button":[
                       {
                           "type":"view",
                           "name":"搜索",
                           "url":"http://www.soso.com/"
                        },
                        {
                           "type":"view",
                           "name":"视频",
                           "url":"http://v.qq.com/"
                        },
                        {
                           "type":"click",
                           "name":"赞一下我们",
                           "key":"V1001_GOOD"
                        }]
                   }]
             }';

        $httpClient = $this->getHttpClientMockExecReturnTrue();
        $httpClient->shouldReceive('getResponse')->andReturn(json_encode(['errcode'=>0, 'errmsg'=>'']))->once();

        $this->sdk->setHttpClient($httpClient);
        $result = $this->sdk->createMenu($str);
        $this->assertTrue($result);

        $httpClient->shouldReceive('getResponse')->andReturn('{"menu":{"button":[{"type":"click","name":"今日歌曲","key":"V1001_TODAY_MUSIC","sub_button":[]},{"type":"click","name":"歌手简介","key":"V1001_TODAY_SINGER","sub_button":[]},{"name":"菜单","sub_button":[{"type":"view","name":"搜索","url":"http://www.soso.com/","sub_button":[]},{"type":"view","name":"视频","url":"http://v.qq.com/","sub_button":[]},{"type":"click","name":"赞一下我们","key":"V1001_GOOD","sub_button":[]}]}]}}')->once();
        $result = $this->sdk->selectMenu();
        $this->assertNotEmpty($result);

        $httpClient->shouldReceive('getResponse')->andReturn(json_encode(['errcode'=>0, 'errmsg'=>'']))->once();
        $result = $this->sdk->deleteMenu();
        $this->assertTrue($result);
    }

    /**
     * @expectedException Exception
     */
    public function testCreateMenuExecReturnFalseThrowException()
    {
        $httpClient = $this->getHttpClientMockExecReturnFalse();
        $this->sdk->setHttpClient($httpClient);
        $this->sdk->createMenu('{}');
    }

    /**
     * @expectedException Exception
     */
    public function testCreateMenuResultErrorThrowException()
    {
        $httpClient = $this->getHttpClientMockExecReturnTrue();
        $httpClient->shouldReceive('getResponse')->andReturn(json_encode([]))->once();
        $this->sdk->setHttpClient($httpClient);
        $this->sdk->createMenu('{}');
    }

    /**
     * @expectedException Exception
     */
    public function testSelectMenuExecReturnFalseThrowException()
    {
        $httpClient = $this->getHttpClientMockExecReturnFalse();
        $this->sdk->setHttpClient($httpClient);
        $this->sdk->selectMenu();
    }

    /**
     * @expectedException Exception
     */
    public function testSelectMenuResultErrorThrowException()
    {
        $httpClient = $this->getHttpClientMockExecReturnTrue();
        $httpClient->shouldReceive('getResponse')->andReturn(json_encode(['errcode'=>1231, 'errmsg'=>'']))->once();
        $this->sdk->setHttpClient($httpClient);
        $this->sdk->selectMenu();
    }
    /**
     * @expectedException Exception
     */
    public function testDeleteMenuExecReturnFalseThrowException()
    {
        $httpClient = $this->getHttpClientMockExecReturnFalse();
        $this->sdk->setHttpClient($httpClient);
        $this->sdk->deleteMenu();
    }

    /**
     * @expectedException Exception
     */
    public function testDeleteMenuResultErrorThrowException()
    {
        $httpClient = $this->getHttpClientMockExecReturnTrue();
        $httpClient->shouldReceive('getResponse')->andReturn(json_encode([]))->once();
        $this->sdk->setHttpClient($httpClient);
        $this->sdk->deleteMenu();
    }

    public function testGetCustomServiceAccountList()
    {
        $httpClient = $this->getHttpClientMockExecReturnTrue();
        $result = '{
                    "kf_list": [
                        {
                            "kf_account": "test1@test",
                            "kf_nick": "ntest1",
                            "kf_id": "1001",
                            "kf_headimgurl": "http://mmbiz.qpic.cn/mmbiz/4whpV1VZl2iccsvYbHvnphkyGtnvjfUS8Ym0GSaLic0FD3vN0V8PILcibEGb2fPfEOmw/0"
                        }
                    ]
                }';


        $httpClient->shouldReceive('getResponse')->andReturn($result)->once();
        $this->sdk->setHttpClient($httpClient);
        $result = $this->sdk->getCustomServiceAccountList();
        $this->assertTrue(sizeof($result) > 0);
    }

    /**
     * @expectedException Exception
     */
    public function testGetCustomServiceAccountListExecReturnFalseThrowException()
    {
        $httpClient = $this->getHttpClientMockExecReturnFalse();
        $this->sdk->setHttpClient($httpClient);
        $this->sdk->getCustomServiceAccountList();
    }

    /**
     * @expectedException Exception
     */
    public function testGetCustomServiceAccountListResultErrorThrowException()
    {
        $httpClient = $this->getHttpClientMockExecReturnTrue();
        $httpClient->shouldReceive('getResponse')->andReturn(json_encode(['errcode'=>1123, 'errmsg'=>'']))->once();
        $this->sdk->setHttpClient($httpClient);
        $this->sdk->getCustomServiceAccountList();
    }

    public function testAddCustomService()
    {
        $httpClient = $this->getHttpClientMockExecReturnTrue();
        $this->sdk->setHttpClient($httpClient);

        $account    = env('WECHAT_CUSTOM_SERVICE_ACCOUNT');
        $nickname   = env('WECHAT_CUSTOM_SERVICE_NICKNAME');
        $password   = env('WECHAT_CUSTOM_SERVICE_PASSWORD');

        $httpClient->shouldReceive('getResponse')->andReturn(json_encode(['errcode'=>0, 'errmsg'=>'']))->once();
        $result = $this->sdk->addCustomServiceAccount($account, $nickname, $password);
        $this->assertTrue($result);
    }

    /**
     * @expectedException Exception
     */
    public function testAddCustomServiceExecReturnFalseThrowException()
    {
        $httpClient = $this->getHttpClientMockExecReturnFalse();
        $this->sdk->setHttpClient($httpClient);
        $account    = env('WECHAT_CUSTOM_SERVICE_ACCOUNT');
        $nickname   = env('WECHAT_CUSTOM_SERVICE_NICKNAME');
        $password   = env('WECHAT_CUSTOM_SERVICE_PASSWORD');

        $this->sdk->addCustomServiceAccount($account, $nickname, $password);
    }

    /**
     * @expectedException Exception
     */
    public function testAddCustomServiceResultErrorThrowException()
    {
        $httpClient = $this->getHttpClientMockExecReturnTrue();
        $httpClient->shouldReceive('getResponse')->andReturn(json_encode([]))->once();
        $this->sdk->setHttpClient($httpClient);

        $account    = env('WECHAT_CUSTOM_SERVICE_ACCOUNT');
        $nickname   = env('WECHAT_CUSTOM_SERVICE_NICKNAME');
        $password   = env('WECHAT_CUSTOM_SERVICE_PASSWORD');

        $this->sdk->addCustomServiceAccount($account, $nickname, $password);
    }

    public function testValidSignature()
    {
        $signature  = '2739e9bc26f3e37ad45ae0ec4c98caf0cf82e039';
        $timestamp  = '1440384428';
        $nonce      = '551611692';

        $this->assertTrue($this->sdk->validSignature($signature, $timestamp, $nonce));
    }

    /**
     * @expectedException Exception
     */
    public function testValidSignatureThrowException()
    {
        $signature  = 'a9267ca55f3d89d2d63d342c74816d4a1dad08f8';
        $timestamp  = '1440384428';
        $nonce      = '551611692';
        $this->sdk->setTokenString(null);
        $this->sdk->validSignature($signature, $timestamp, $nonce);
    }

    public function testCreateTemplateQRCodeTicket()
    {
        $value = 1234;
        $httpClient = $this->getHttpClientMockExecReturnTrue();
        $result = '{"ticket":"gQG58DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xLzdqczBZV2JtbXIzajRfWUtNQlhEAAIE51jcVQMEgDoJAA==","expire_seconds":604800,"url":"http:\/\/weixin.qq.com\/q\/7js0YWbmmr3j4_YKMBXD"}';
        $httpClient->shouldReceive('getResponse')->andReturn($result)->once();
        $this->sdk->setHttpClient($httpClient);
        $result = $this->sdk->createTemplateQRCodeTicket($value);
        $this->assertTrue(isset($result['ticket']));
        $this->assertTrue(isset($result['url']));
        $this->assertTrue(isset($result['expire_seconds']));
    }

    public function testCreateLimitQRCodeTicket()
    {
        $value = 1234;
        $httpClient = $this->getHttpClientMockExecReturnTrue();
        $result = '{"ticket":"gQG58DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xLzdqczBZV2JtbXIzajRfWUtNQlhEAAIE51jcVQMEgDoJAA==","expire_seconds":604800,"url":"http:\/\/weixin.qq.com\/q\/7js0YWbmmr3j4_YKMBXD"}';
        $httpClient->shouldReceive('getResponse')->andReturn($result)->once();
        $this->sdk->setHttpClient($httpClient);
        $result = $this->sdk->createLimitQRCodeTicket($value);
        $this->assertTrue(isset($result['ticket']));
        $this->assertTrue(isset($result['url']));
        $this->assertTrue(isset($result['expire_seconds']));
    }

    /**
     * @expectedException Exception
     */
    public function testCreateTemplateQRCodeTicketExecReturnFalseThrowException()
    {
        $httpClient = $this->getHttpClientMockExecReturnFalse();
        $this->sdk->setHttpClient($httpClient);
        $value = 1234;
        $this->sdk->createLimitQRCodeTicket($value);
    }

    /**
     * @expectedException Exception
     */
    public function testCreateTemplateQRCodeTicketResultErrorThrowException()
    {
        $httpClient = $this->getHttpClientMockExecReturnTrue();
        $httpClient->shouldReceive('getResponse')->andReturn(json_encode(['errcode'=>120, 'errmsg'=>'']))->once();
        $this->sdk->setHttpClient($httpClient);

        $value = 1234;
        $this->sdk->createLimitQRCodeTicket($value);
    }

    public function testGetQRImageUrl()
    {
        $this->assertTrue(strlen($this->sdk->getQRImageUrl('test')) > 0);
    }

    public function testGetMediaUrlReturnString()
    {
        $result = $this->sdk->getMediaUrl('5mzSvUAqehGeJcXKjMQYHAUdF5uCQuBSri6iTheG5qW6tfgYE3HlKVRFspvUAZnp');
        $this->assertTrue(is_string($result));
        $this->assertTrue(strlen($result) > 0);
    }

    public function testDownloadMediaReturnBoolean()
    {
        $httpClient = $this->getHttpClientMockExecReturnTrue();
        $httpClient->shouldReceive('getResponse')->andReturn('test');
        $this->sdk->setHttpClient($httpClient);

        $mediaId = '5mzSvUAqehGeJcXKjMQYHAUdF5uCQuBSri6iTheG5qW6tfgYE3HlKVRFspvUAZnp';
        $this->assertTrue($this->sdk->downloadMedia($mediaId, "./" . DIRECTORY_SEPARATOR . md5($mediaId)));
    }

    /**
     * @expectedException Exception
     */
    public function testDownloadMediaExecReturnFalseThrowsException()
    {
        $httpClient = $this->getHttpClientMockExecReturnFalse();
        $this->sdk->setHttpClient($httpClient);

        $mediaId = '5mzSvUAqehGeJcXKjMQYHAUdF5uCQuBSri6iTheG5qW6tfgYE3HlKVRFspvUAZnp';
        $this->sdk->downloadMedia($mediaId, "./" . DIRECTORY_SEPARATOR . md5($mediaId));
    }

    public function testUploadTempMedia()
    {
        $data   = [
                    'type' => 'image',
                    'media_id' => '5mzSvUAqehGeJcXKjMQYHAUdF5uCQuBSri6iTheG5qW6tfgYE3HlKVRFspvUAZnp',
                    'created_at' => time(),
        ];

        $httpClient = $this->getHttpClientMockExecReturnTrue();
        $httpClient->shouldReceive('getResponse')->andReturn(json_encode($data));
        $this->sdk->setHttpClient($httpClient);

        $result = $this->sdk->uploadTempImage(__DIR__ . '/qrcode.jpg');
        $this->assertEquals($data, $result);

        $result = $this->sdk->uploadTempVideo(__DIR__ . '/qrcode.jpg');
        $this->assertEquals($data, $result);

        $result = $this->sdk->uploadTempThumb(__DIR__ . '/qrcode.jpg');
        $this->assertEquals($data, $result);

        $result = $this->sdk->uploadTempVoice(__DIR__ . '/qrcode.jpg');
        $this->assertEquals($data, $result);
    }

    /**
     * @expectedException Exception
     */
    public function testUploadTempMediaExecReturnFalseThrowsException()
    {
        $httpClient = $this->getHttpClientMockExecReturnFalse();
        $this->sdk->setHttpClient($httpClient);
        $this->sdk->uploadTempImage(__DIR__ . '/qrcode.jpg');
    }

    /**
     * @expectedException Exception
     */
    public function testUploadTempMediaResponseErrorThrowsException()
    {
        $httpClient = $this->getHttpClientMockExecReturnTrue();
        $httpClient->shouldReceive('getResponse')->andReturn('{"errcode":40004,"errmsg":"invalid media type"}');
        $this->sdk->setHttpClient($httpClient);

        $this->sdk->uploadTempImage(__DIR__ . '/qrcode.jpg');
    }

    public function testDownloadQRImageReturnBoolean()
    {
        $httpClient = $this->getHttpClientMockExecReturnTrue();
        $httpClient->shouldReceive('getResponse')->andReturn('test');
        $this->sdk->setHttpClient($httpClient);

        $ticket = 'gQH47joAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL2taZ2Z3TVRtNzJXV1Brb3ZhYmJJAAIEZ23sUwMEmm3sUw==';
        $result = $this->sdk->downloadQRImage($ticket, __DIR__ . '/qrcode.jpg');
        $this->assertTrue($result);
    }

    /**
     * @expectedException Exception
     */
    public function testDownloadQRImageExecReturnFalseThrowsException()
    {
        $httpClient = $this->getHttpClientMockExecReturnFalse();
        $this->sdk->setHttpClient($httpClient);

        $ticket = 'gQH47joAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL2taZ2Z3TVRtNzJXV1Brb3ZhYmJJAAIEZ23sUwMEmm3sUw==';
        $this->sdk->downloadQRImage($ticket, __DIR__ . '/qrcode.jpg');
    }

    public function testGetUserInfoReturnArray()
    {
        $data = [
                'subscribe' => 1,
                'openid' => 'o6_bmjrPTlm6_2sgVt7hMZOPfL2M',
                'nickname' => 'Band',
                'sex' => 1,
                'language' => 'zh_CN',
                'city' => '广州',
                'province' => '广东',
                'country' => '中国',
                'headimgurl' => 'http://wx.qlogo.cn/mmopen/g3MonUZtNHk',
                'subscribe_time' => '1382694957',
                'unionid' => 'o6_bmasdasdsad6_2sgVt7hMZOPfL',
                'remark' => '',
                'groupid' => '0',
        ];
        $httpClient = $this->getHttpClientMockExecReturnTrue();
        $httpClient->shouldReceive('getResponse')->andReturn(json_encode($data));
        $this->sdk->setHttpClient($httpClient);

        $result = $this->sdk->getUserInfo($data['openid']);
        $this->assertEquals($data, $result);
    }

    /**
     * @expectedException Exception
     */
    public function testGetUserInfoExecReturnFalseThrowsException()
    {
        $httpClient = $this->getHttpClientMockExecReturnFalse();
        $this->sdk->setHttpClient($httpClient);
        $this->sdk->getUserInfo('o6_bmjrPTlm6_2sgVt7hMZOPfL2M');
    }

    /**
     * @expectedException Exception
     */
    public function testGetUserInfoResponseErrorThrowsException()
    {
        $httpClient = $this->getHttpClientMockExecReturnTrue();
        $httpClient->shouldReceive('getResponse')->andReturn('{"errcode":40004,"errmsg":"invalid media type"}');
        $this->sdk->setHttpClient($httpClient);
        $this->sdk->getUserInfo('o6_bmjrPTlm6_2sgVt7hMZOPfL2M');
    }

    public function testSendCustomServiceMessageReturnBoolean()
    {
        $httpClient = $this->getHttpClientMockExecReturnTrue();
        $httpClient->shouldReceive('getResponse')->andReturn('{"errcode":0,"errmsg":""}');
        $this->sdk->setHttpClient($httpClient);
        $this->assertTrue($this->sdk->sendCustomServiceMessage(new WxSendTextMsg()));
    }

    /**
     * @expectedException Exception
     */
    public function testSendCustomServiceMessageExecReturnFalseThrowsException()
    {
        $httpClient = $this->getHttpClientMockExecReturnFalse();
        $this->sdk->setHttpClient($httpClient);
        $this->assertTrue($this->sdk->sendCustomServiceMessage(new WxSendTextMsg()));
    }
    /**
     * @expectedException Exception
     */
    public function testSendCustomServiceMessageResponseErrorThrowsException()
    {
        $httpClient = $this->getHttpClientMockExecReturnTrue();
        $httpClient->shouldReceive('getResponse')->andReturn('');
        $this->sdk->setHttpClient($httpClient);

        $this->assertTrue($this->sdk->sendCustomServiceMessage(new WxSendTextMsg()));
    }

    public function testDeleteCustomServiceAccountReturnBoolean()
    {
        $httpClient = $this->getHttpClientMockExecReturnTrue();
        $httpClient->shouldReceive('getResponse')->andReturn('{"errcode":0,"errmsg":""}');
        $this->sdk->setHttpClient($httpClient);
        $this->assertTrue($this->sdk->deleteCustomServiceAccount('test@test1', 'nickname', '123456'));
    }

    /**
     * @expectedException Exception
     */
    public function testDeleteCustomServiceAccountResponseErrorThrowsException()
    {
        $httpClient = $this->getHttpClientMockExecReturnTrue();
        $httpClient->shouldReceive('getResponse')->andReturn('');
        $this->sdk->setHttpClient($httpClient);
        $this->assertTrue($this->sdk->deleteCustomServiceAccount('test@test1', 'nickname', '123456'));
    }

    /**
     * @expectedException Exception
     */
    public function testDeleteCustomServiceAccountExecFalseThrowsException()
    {
        $httpClient = $this->getHttpClientMockExecReturnFalse();
        $this->sdk->setHttpClient($httpClient);
        $this->assertTrue($this->sdk->deleteCustomServiceAccount('test@test1', 'nickname', '123456'));
    }

    public function testUpdateCustomServiceAccountReturnBoolean()
    {
        $httpClient = $this->getHttpClientMockExecReturnTrue();
        $httpClient->shouldReceive('getResponse')->andReturn('{"errcode":0,"errmsg":""}');
        $this->sdk->setHttpClient($httpClient);
        $this->assertTrue($this->sdk->updateCustomServiceAccount('test@test1', 'nickname', '123456'));
    }

    /**
     * @expectedException Exception
     */
    public function testUpdateCustomServiceAccountResponseErrorThrowsException()
    {
        $httpClient = $this->getHttpClientMockExecReturnTrue();
        $httpClient->shouldReceive('getResponse')->andReturn('');
        $this->sdk->setHttpClient($httpClient);
        $this->assertTrue($this->sdk->updateCustomServiceAccount('test@test1', 'nickname', '123456'));
    }

    /**
     * @expectedException Exception
     */
    public function testUpdateCustomServiceAccountExecFalseThrowsException()
    {
        $httpClient = $this->getHttpClientMockExecReturnFalse();
        $this->sdk->setHttpClient($httpClient);
        $this->assertTrue($this->sdk->updateCustomServiceAccount('test@test1', 'nickname', '123456'));
    }

    public function testGetOAuth2UrlReturnString() {
        $url = $this->sdk->getOAuth2Url("http://www.baidu.com");
        $this->assertTrue(stripos($url, urlencode("http://www.baidu.com")) > 0);
        $this->assertTrue(stripos($url, "https://open.weixin.qq.com/connect/oauth2/authorize?appid=") == 0);
    }

    public function testGetOAuth2AccessTokenReturnArray() {
        $httpClient = $this->getHttpClientMockExecReturnTrue();
        $httpClient->shouldReceive('getResponse')->andReturn('{"access_token":"ACCESS_TOKEN","expires_in":7200,"refresh_token":"REFRESH_TOKEN","openid":"OPENID","scope":"SCOPE"}');
        $this->sdk->setHttpClient($httpClient);
        $data = $this->sdk->getOAuth2AccessToken("test code");
        $this->assertEquals("ACCESS_TOKEN", $data['accessToken']);
        $this->assertEquals("OPENID", $data['openId']);
    }

    /**
     * @expectedException Exception
     */
    public function testGetOAuth2AccessTokenExecReturnFalseThrowException() {
        $httpClient = $this->getHttpClientMockExecReturnFalse();
        $this->sdk->setHttpClient($httpClient);
        $this->sdk->getOAuth2AccessToken("test code");
    }

    /**
     * @expectedException Exception
     */
    public function testGetOAuth2AccessTokenResponseErrorThrowsException()
    {
        $httpClient = $this->getHttpClientMockExecReturnTrue();
        $httpClient->shouldReceive('getResponse')->andReturn('');
        $this->sdk->setHttpClient($httpClient);
        $this->sdk->getOAuth2AccessToken("test code");
    }

    public function testGetOAuth2UserInfo() {
        $httpClient = $this->getHttpClientMockExecReturnTrue();
        $response = '{"openid":"OPENID","nickname":"NICKNAME","sex":1,"province":"PROVINCE","city":"CITY","country":"COUNTRY","headimgurl": "http://wx.qlogo.cn/mmopen/g3MonUZtNHkdmzicIlibx6iaFqAc56vxLSUfpb6n5WKSYVY0ChQKkiaJSgQ1dZuTOgvLLrhJbERQQ4eMsv84eavHiaiceqxibJxCfHe/0","privilege":["PRIVILEGE1","PRIVILEGE2"],"unionid": " o6_bmasdasdsad6_2sgVt7hMZOPfL"}';
        $httpClient->shouldReceive('getResponse')->andReturn($response);
        $this->sdk->setHttpClient($httpClient);
        $result = $this->sdk->getOAuth2UserInfo("accessToken", "openId");
        $this->assertTrue(isset($result['openid']));
        $this->assertTrue(isset($result['nickname']));
        $this->assertTrue(isset($result['sex']));
        $this->assertTrue(isset($result['country']));
    }

    /**
     * @expectedException Exception
     */
    public function testGetOAuth2UserInfoExecReturnFalseThrowException() {
        $httpClient = $this->getHttpClientMockExecReturnFalse();
        $this->sdk->setHttpClient($httpClient);
        $this->sdk->getOAuth2UserInfo("accessToken", "openId");
    }

    public function testCreateNonceStr() {
        $this->assertTrue(strlen($this->sdk->createNonceStr()) == 32);
    }

    public function testCreateSignature() {
        $this->assertTrue(strlen($this->sdk->createSignature($this->sdk->createNonceStr(), time(), "http://www.test.com"))> 0);
    }

    public function testDownloadHeadImage() {
        $httpClient = $this->getHttpClientMockExecReturnTrue();
        $httpClient->shouldReceive('getResponse')->andReturn('test');
        $this->sdk->setHttpClient($httpClient);

        $url = 'http://wx.qlogo.cn/mmopen/fBvGRLgXxDVXpvoyVniavXIELA2WNfNQZg974Lxuic48o44IUEUN3RDabgoGxnsWOGE85CyHZWbjsm6Xy8FoCKKaUFftdyFJQz/0';
        $this->assertTrue($this->sdk->downloadHeadImage($url, __DIR__ . '/RLgXxDVXpvoyVniavXIELA2WNfN.jpg'));
    }

    /**
     * @expectedException Exception
     */
    public function testDownloadHeadImageExecReturnFalseThrowsException()
    {
        $httpClient = $this->getHttpClientMockExecReturnFalse();
        $this->sdk->setHttpClient($httpClient);

        $url = 'http://wx.qlogo.cn/mmopen/fBvGRLgXxDVXpvoyVniavXIELA2WNfNQZg974Lxuic48o44IUEUN3RDabgoGxnsWOGE85CyHZWbjsm6Xy8FoCKKaUFftdyFJQz/0';
        $this->sdk->downloadHeadImage($url, __DIR__ . '/RLgXxDVXpvoyVniavXIELA2WNfN.jpg');
    }
}
