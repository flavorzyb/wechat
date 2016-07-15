<?php
/**
 * Created by PhpStorm.
 * User: flavor
 * Date: 15/9/21
 * Time: 下午2:55
 */

namespace WeChat\Sdk;

use Mockery as m;
use Simple\Http\Client;
use \Exception;

class MockJsApiTicket extends JsApiTicket{
    protected $client = null;

    /**
     * @return Client
     */
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

class JsApiTicketTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var MockJsApiTicket
     */
    private $jsApiTicket    = null;
    /**
     * @var AccessToken
     */
    private $accessToken    = null;

    /**
     * @var \Mockery\MockInterface
     */
    private $fileSystem     = null;

    /**
     * @var \Mockery\MockInterface
     */
    private $httpClient     = null;

    public function setUp() {
        $this->accessToken  = m::mock('WeChat\Sdk\AccessToken');
        $token = "wqGrEs9GclJo7xylemOqv0AzbtSQbO1jI4CGPlKu3qgI0uZ9xHPDBn7N0Fkaxhwfa8roJ357E0uHixBrIF890rgtSev6CsBj4dSu50uxidY";
        $this->accessToken->shouldReceive("getAccessToken")->andReturn($token);
        $this->jsApiTicket = new MockJsApiTicket($this->accessToken, "js_api_ticket");

        $this->fileSystem   = $this->createFileSystemMockInstance();
        $this->fileSystem->shouldReceive("isFile")->andReturn(true);
        $this->fileSystem->shouldReceive("put")->andReturn(true);
        $data   = [
            'ticket'     => 'wqGrEs9GclJo7xylemOqv0AzbtSQbO1jI4CGPlKu3qgI0uZ9xHPDBn7N0Fkaxhwfa8roJ357E0uHixBrIF890rgtSev6CsBj4dSu50uxidY',
            'expire'    => 7200,
            'time'      => time(),
        ];
        $this->fileSystem->shouldReceive("get")->andReturn(serialize($data));
        $this->jsApiTicket->setFileSystem($this->fileSystem);

        $this->httpClient   = $this->getHttpClientMockExecReturnTrue();
        $str = '{"errcode":0,"errmsg":"ok","ticket":"bxLdikRXVbTPdHSM05e5u5sUoXNKd8-41ZO3MhKoyN5OfkWITDGgnr2fwJ0m9E8NYzWKVZvdVtaUgWvsdshFKA","expires_in":7200}';
        $this->httpClient->shouldReceive('getResponse')->andReturn($str);
        $this->jsApiTicket->setHttpClient($this->httpClient);
    }

    private function createFileSystemMockInstance() {
        return m::mock('\Simple\Filesystem\Filesystem');
    }

    protected function getHttpClientMockInstance()
    {
        $result = m::mock('\Simple\Http\Client');
        $result->shouldReceive('setUrl');
        $result->shouldReceive('setHeaderArray');
        $result->shouldReceive('setMethod');
        $result->shouldReceive('setPostFields');

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

    public function testOptions() {
        $this->jsApiTicket = new JsApiTicket($this->accessToken, "js_api_ticket");
        $this->assertNotNull($this->jsApiTicket->getAccessToken());
        $this->assertNotNull($this->jsApiTicket->getFileSystem());
        $this->assertNotNull($this->jsApiTicket->getHttpClient());
        $this->assertEquals("js_api_ticket", $this->jsApiTicket->getTicketFilePath());
    }

    public function testReadTicketFromFile() {
        $this->assertTrue(strlen($this->jsApiTicket->getTicket()) > 0);
    }

    public function testTicketStringTimeOut() {
        $this->fileSystem = $this->createFileSystemMockInstance();
        $this->fileSystem->shouldReceive("isFile")->andReturn(true);
        $data   = [
            'ticket'     => 'wqGrEs9GclJo7xylemOqv0AzbtSQbO1jI4CGPlKu3qgI0uZ9xHPDBn7N0Fkaxhwfa8roJ357E0uHixBrIF890rgtSev6CsBj4dSu50uxidY',
            'expire'    => 7200,
            'time'      => time() - 18000,
        ];
        $this->fileSystem->shouldReceive("get")->andReturn(serialize($data));
        $this->fileSystem->shouldReceive("put")->andReturn(true);
        $this->jsApiTicket->setFileSystem($this->fileSystem);
        $this->assertTrue(strlen($this->jsApiTicket->getTicket()) > 0);
    }

    public function testTicketFileIsNotExists() {
        $this->fileSystem = $this->createFileSystemMockInstance();
        $this->fileSystem->shouldReceive("isFile")->andReturn(false);
        $this->fileSystem->shouldReceive("put")->andReturn(true);
        $this->jsApiTicket->setFileSystem($this->fileSystem);
        $this->assertTrue(strlen($this->jsApiTicket->getTicket()) > 0);
    }

    /**
     * @expectedException Exception
     */
    public function testGetTicketExecReturnFalseThrowsException() {
        $this->fileSystem = $this->createFileSystemMockInstance();
        $this->fileSystem->shouldReceive("isFile")->andReturn(false);
        $this->jsApiTicket->setFileSystem($this->fileSystem);

        $this->httpClient = $this->getHttpClientMockExecReturnFalse();
        $this->jsApiTicket->setHttpClient($this->httpClient);

        $this->jsApiTicket->getTicket();
    }

    /**
     * @expectedException Exception
     */
    public function testGetTicketErrorResponseThrowsException() {
        $this->fileSystem = $this->createFileSystemMockInstance();
        $this->fileSystem->shouldReceive("isFile")->andReturn(false);
        $this->jsApiTicket->setFileSystem($this->fileSystem);

        $this->httpClient = $this->getHttpClientMockExecReturnTrue();
        $str = '{"errcode":0,"errmsg":"ok","expires_in":7200}';
        $this->httpClient->shouldReceive('getResponse')->andReturn($str);
        $this->jsApiTicket->setHttpClient($this->httpClient);

        $this->jsApiTicket->getTicket();
    }
}
