<?php
namespace WeChat\Sdk;

use Simple\Filesystem\Filesystem;
use Simple\Helper\Helper;
use Simple\Http\Client;
use \Exception;

class AccessToken
{
    /**
     * token expire sub time
     */
    const TOKEN_EXPIRE_SUB_TIME     = 30;

    // SDK TOKEN URL
    const TOKEN_URL         = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=%s&secret=%s';

    /**
     * @var \Simple\Filesystem\Filesystem
     */
    protected $fileSystem       = null;

    /**
     * access token file path
     *
     * @var string
     */
    protected $tokenFilePath    = null;

    /**
     * access token lock file
     * @var string
     */
    protected $tokenLockFilePath = null;

    /**
     * app id
     * @var string
     */
    protected $appId            = null;

    /**
     * app secret
     * @var string
     */
    protected $appSecret        = null;

    /**
     * AccessToken constructor.
     *
     * @param string $appId
     * @param string $appSecret
     * @param string $tokenFilePath
     */
    public function __construct($appId, $appSecret, $tokenFilePath)
    {
        $this->tokenFilePath    = $tokenFilePath;
        $this->appId            = $appId;
        $this->appSecret        = $appSecret;
    }


    /**
     * get app id
     * @return string
     */
    public function getAppId()
    {
        return $this->appId;
    }

    /**
     * get app secret
     * @return string
     */
    public function getAppSecret()
    {
        return $this->appSecret;
    }

    /**
     * get http client
     * @return Client
     */
    public function getHttpClient()
    {
        return new Client();
    }

    /**
     * get filesystem instance
     *
     * @return \Simple\Filesystem\Filesystem
     */
    public function getFileSystem()
    {
        if (null == $this->fileSystem) {
            $this->setFileSystem(Helper::getFileSystem());
        }

        return $this->fileSystem;
    }

    /**
     * set filesystem instance
     * @param \Simple\Filesystem\Filesystem $fileSystem
     */
    public function setFileSystem(Filesystem $fileSystem)
    {
        $this->fileSystem = $fileSystem;
    }

    /**
     * get token file path
     * @return string
     */
    public function getTokenFilePath()
    {
        return $this->tokenFilePath;
    }

    /**
     * save access token to file
     *
     * @param string $token
     * @param int $expire
     * @return bool
     */
    protected function saveAccessToken($token, $expire)
    {
        $data   = ['token' => $token, 'expire' => intval($expire), 'time' => time()];
        return ($this->getFileSystem()->put($this->getTokenFilePath(), json_encode($data), true) > 0);
    }

    /**
     * read access token from file
     *
     * @return string
     * @throws \Simple\Filesystem\FileNotFoundException
     */
    protected function readAccessToken()
    {
        if (!$this->getFileSystem()->isFile($this->getTokenFilePath())) {
            return '';
        }

        $content = trim($this->getFileSystem()->get($this->getTokenFilePath()));
        $result = json_decode($content, true);

        if (isset($result['token']) && isset($result['expire']) && isset($result['time'])) {
            $expireTime = $result['time'] + $result['expire'] - self::TOKEN_EXPIRE_SUB_TIME;
            if ($expireTime > time()) {
                return $result['token'];
            }
        }

        return '';
    }

    /**
     * get access token from WeChat
     *
     * @return array
     * @throws Exception
     */
    protected function getAccessTokenFromWeChat()
    {
        $url    = sprintf(self::TOKEN_URL, $this->appId, $this->appSecret);
        $client = $this->getHttpClient();
        $client->setUrl($url);
        $client->setHeaderArray(['Content-Type: application/json']);

        if (!$client->exec()) {
            throw new Exception("error when get access token from WeChat({$url})");
        }

        $result = json_decode($client->getResponse(), true);
        if (!(isset($result['access_token']) && (isset($result['expires_in'])))) {
            throw new Exception("error result when get access token from WeChat({$url})");
        }

        return ['token' => $result['access_token'], 'expire'=> $result['expires_in']];
    }

    /**
     * get access token
     * @return string
     * @throws Exception
     */
    public function getAccessToken()
    {
        // get token from cache file
        $result = $this->readAccessToken();
        if ('' != $result) {
            return $result;
        }

        // get token from we chat api
        $data   = $this->getAccessTokenFromWeChat();
        // save token to cache data
        $this->saveAccessToken($data['token'], $data['expire']);

        return $data['token'];
    }
}
