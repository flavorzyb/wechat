<?php
namespace WeChat\Sdk;


class SdkParameter
{
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
     * access token file path
     *
     * @var string
     */
    protected $tokenFilePath    = null;

    /**
     * token string which valid signature
     *
     * @var string
     */
    protected $tokenString      = null;

    /**
     * ticket file path
     *
     * @var string
     */
    protected $ticketFilePath   = null;
    /**
     * @return string
     */
    public function getAppId()
    {
        return $this->appId;
    }

    /**
     * @param string $appId
     */
    public function setAppId($appId)
    {
        $this->appId = $appId;
    }

    /**
     * @return string
     */
    public function getAppSecret()
    {
        return $this->appSecret;
    }

    /**
     * @param string $appSecret
     */
    public function setAppSecret($appSecret)
    {
        $this->appSecret = $appSecret;
    }

    /**
     * @return string
     */
    public function getTokenFilePath()
    {
        return $this->tokenFilePath;
    }

    /**
     * @param string $tokenFilePath
     */
    public function setTokenFilePath($tokenFilePath)
    {
        $this->tokenFilePath = $tokenFilePath;
    }

    /**
     * @return string
     */
    public function getTokenString()
    {
        return $this->tokenString;
    }

    /**
     * @param string $tokenString
     */
    public function setTokenString($tokenString)
    {
        $this->tokenString = $tokenString;
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
     * set ticket file path
     * @param string $ticketFilePath
     */
    public function setTicketFilePath($ticketFilePath)
    {
        $this->ticketFilePath = $ticketFilePath;
    }
}
