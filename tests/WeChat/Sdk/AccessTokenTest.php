<?php
namespace WeChat\Sdk;

use Mockery as m;

use Simple\Http\Client;
use \Exception;

class MockAccessToken extends AccessToken
{
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

class AccessTokenTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var MockAccessToken
     */
    protected $accessToken  = null;
    protected $tokenFilePath = null;
    protected $appId = "wxd0e9c95e";
    protected $appSecret = "44e8ae2cb1fd864d6d6";

    protected function setUp()
    {
        $this->tokenFilePath = __DIR__ . '/access_token.log';
        $this->accessToken  = new MockAccessToken($this->appId, $this->appSecret, $this->tokenFilePath);
    }

    protected function tearDown()
    {
        if (is_file($this->tokenFilePath)) {
            unlink($this->tokenFilePath);
        }
        parent::tearDown();
    }

    public function testHttpClientAndFileSystemHandler()
    {
        $this->assertInstanceOf('\Simple\Http\Client', $this->accessToken->getHttpClient());
        $this->assertInstanceOf('\Simple\Filesystem\Filesystem', $this->accessToken->getFileSystem());
    }

    public function testOptionsIsMutable()
    {
        $this->assertEquals($this->appId, $this->accessToken->getAppId());
        $this->assertEquals($this->appSecret, $this->accessToken->getAppSecret());
        $this->assertEquals($this->tokenFilePath, $this->accessToken->getTokenFilePath());
    }

    protected function createFileSystemMockObject()
    {
        $result = m::mock('\Simple\Filesystem\Filesystem');
        return $result;
    }

    protected function getHttpClientMockInstance()
    {
        $result = m::mock('Simple\Http\Client');
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

    public function testGetAccessTokenFromFile()
    {
        $data   = [
            'token'     => 'wqGrEs9GclJo7xylemOqv0AzbtSQbO1jI4CGPlKu3qgI0uZ9xHPDBn7N0Fkaxhwfa8roJ357E0uHixBrIF890rgtSev6CsBj4dSu50uxidY',
            'expire'    => 7200,
            'time'      => time(),
        ];

        $fileSystem = $this->createFileSystemMockObject();
        $fileSystem->shouldReceive('isFile')->andReturn(true);
        $fileSystem->shouldReceive('get')->andReturn(json_encode($data));
        $this->accessToken->setFileSystem($fileSystem);
        $this->assertEquals($data['token'], $this->accessToken->getAccessToken());
    }

    public function testGetAccessTokenWhenDataIsExpireOut()
    {
        $data   = [
            'token'     => 'wqGrEs9GclJo7xylemOqv0AzbtSQbO1jI4CGPlKu3qgI0uZ9xHPDBn7N0Fkaxhwfa8roJ357E0uHixBrIF890rgtSev6CsBj4dSu50uxidY',
            'expire'    => 7200,
            'time'      => time() - 7500,
        ];

        $fileSystem = $this->createFileSystemMockObject();
        $fileSystem->shouldReceive('isFile')->andReturn(true);
        $fileSystem->shouldReceive('get')->andReturn(json_encode($data));
        $this->accessToken->setFileSystem($fileSystem);

        $httpClient = $this->getHttpClientMockExecReturnTrue();
        $httpClient->shouldReceive('getResponse')->andReturn(json_encode(['access_token'=>$data['token'], 'expires_in' => $data['expire']]));
        $this->accessToken->setHttpClient($httpClient);

        // mock save file
        $fileSystem->shouldReceive('put')->andReturn(178);

        $this->assertEquals($data['token'], $this->accessToken->getAccessToken());
    }

    public function testGetAccessTokenWhenFileIsNotExists()
    {
        $data   = [
            'token'     => 'wqGrEs9GclJo7xylemOqv0AzbtSQbO1jI4CGPlKu3qgI0uZ9xHPDBn7N0Fkaxhwfa8roJ357E0uHixBrIF890rgtSev6CsBj4dSu50uxidY',
            'expire'    => 7200,
            'time'      => time() - 7500,
        ];

        $fileSystem = $this->createFileSystemMockObject();
        $fileSystem->shouldReceive('isFile')->andReturn(false);
        $this->accessToken->setFileSystem($fileSystem);

        $httpClient = $this->getHttpClientMockExecReturnTrue();
        $httpClient->shouldReceive('getResponse')->andReturn(json_encode(['access_token'=>$data['token'], 'expires_in' => $data['expire']]));
        $this->accessToken->setHttpClient($httpClient);

        // mock save file
        $fileSystem->shouldReceive('put')->andReturn(178);

        $this->assertEquals($data['token'], $this->accessToken->getAccessToken());
    }

    /**
     * @expectedException Exception
     */
    public function testGetAccessTokenExecReturnFalseThrowsException()
    {
        $fileSystem = $this->createFileSystemMockObject();
        $fileSystem->shouldReceive('isFile')->andReturn(false);
        $this->accessToken->setFileSystem($fileSystem);

        $httpClient = $this->getHttpClientMockExecReturnFalse();
        $this->accessToken->setHttpClient($httpClient);

        $this->accessToken->getAccessToken();
    }

    /**
     * @expectedException Exception
     */
    public function testGetAccessTokenResponseErrorThrowsException()
    {
        $fileSystem = $this->createFileSystemMockObject();
        $fileSystem->shouldReceive('isFile')->andReturn(false);
        $this->accessToken->setFileSystem($fileSystem);

        $httpClient = $this->getHttpClientMockExecReturnTrue();
        $httpClient->shouldReceive('getResponse')->andReturn('{"errcode":40013,"errmsg":"invalid appid"}');
        $this->accessToken->setHttpClient($httpClient);

        $this->accessToken->getAccessToken();
    }
}