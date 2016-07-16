<?php
namespace WeChat\Sdk;

use Simple\Filesystem\Filesystem;
use Simple\Helper\Helper;
use Simple\Http\Client;
use \Exception;

class JsApiTicket
{
    /**
     * token expire sub time
     */
    const EXPIRE_SUB_TIME     = 30;

    // JS API ticket
    const TICKET_URL       = 'https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token=%s&type=jsapi';

    /**
     * @var AccessToken
     */
    private $accessToken      = null;
    /**
     * @var \Simple\Filesystem\Filesystem
     */
    private $fileSystem       = null;

    /**
     * js api ticket file path
     *
     * @var string
     */
    private $ticketFilePath    = null;

    /**
     * Js Api Ticket constructor.
     *
     * @param AccessToken $accessToken
     * @param string $ticketFilePath
     */
    public function __construct(AccessToken $accessToken, $ticketFilePath)
    {
        $this->ticketFilePath   = $ticketFilePath;
        $this->accessToken      = $accessToken;
    }

    /**
     * @return AccessToken
     */
    public function getAccessToken()
    {
        return $this->accessToken;
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
     * get ticket file path
     * @return string
     */
    public function getTicketFilePath()
    {
        return $this->ticketFilePath;
    }

    /**
     * save js api ticket to file
     *
     * @param string $ticket
     * @param int $expire
     * @return bool
     */
    private function saveTicket($ticket, $expire)
    {
        $data   = ['ticket' => $ticket, 'expire' => intval($expire), 'time' => time()];
        return ($this->getFileSystem()->put($this->getTicketFilePath(), serialize($data), true) > 0);
    }

    /**
     * read js api ticket from file
     *
     * @return string
     * @throws \Simple\Filesystem\FileNotFoundException
     */
    private function readTicket()
    {
        if (!$this->getFileSystem()->isFile($this->getTicketFilePath())) {
            return '';
        }

        $content = trim($this->getFileSystem()->get($this->getTicketFilePath()));
        $result = unserialize($content);

        if (isset($result['ticket']) && isset($result['expire']) && isset($result['time'])) {
            $expireTime = $result['time'] + $result['expire'] - self::EXPIRE_SUB_TIME;
            if ($expireTime > time()) {
                return $result['ticket'];
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
    protected function getTicketFromWeChat()
    {
        $url    = sprintf(self::TICKET_URL, $this->getAccessToken()->getAccessToken());
        $client = $this->getHttpClient();
        $client->setUrl($url);
        $client->setHeaderArray(['Content-Type: application/json']);

        if (!$client->exec()) {
            throw new Exception("error when get js api ticket from WeChat({$url})");
        }

        $result = json_decode($client->getResponse(), true);
        if (!(isset($result['ticket']) && (isset($result['expires_in'])))) {
            throw new Exception("error result when get js api ticket from WeChat({$url})");
        }

        return ['ticket' => $result['ticket'], 'expire'=> $result['expires_in']];
    }

    /**
     * 获取js api 的ticket
     *
     * @return string
     * @throws Exception
     */
    public function getTicket() {
        // get js api ticket from cache file
        $result = $this->readTicket();
        if ('' != $result) {
            return $result;
        }

        // get js api ticket from we chat api
        $data   = $this->getTicketFromWeChat();

        // save js api ticket to cache data
        $this->saveTicket($data['ticket'], $data['expire']);

        return $data['ticket'];
    }
}
