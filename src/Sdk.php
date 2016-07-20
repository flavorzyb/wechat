<?php
namespace WeChat;

use Simple\Filesystem\Filesystem;
use Simple\Helper\Helper;
use Simple\Http\Client;
use WeChat\Message\WxSendMsg;
use WeChat\Message\Formatter;
use WeChat\Sdk\AccessToken;
use WeChat\Sdk\JsApiTicket;
use \Exception;
use WeChat\Sdk\SdkParameter;

class Sdk
{
    // 二维码 临时二维码，是有过期时间的，最长可以设置为在二维码生成后的30天（即2592000秒）后过期
    const QR_CODE_EXPIRE_TIME       = 2592000;
    // 临时二维码
    const QR_CODE_TEMPLATE_SCENE    = 'QR_SCENE';
    // 永久二维码
    const QR_CODE_LIMIT_SCENE       = 'QR_LIMIT_SCENE';

    // the max count of customer service account
    const CS_ACCOUNT_MAX_COUNT  = 10;

    const NONCE_STRING_LENGTH   = 32;

    // 图片类型
    const UPLOAD_TYPE_IMAGE     = 'image';
    // 语音类型
    const UPLOAD_TYPE_VOICE     = 'voice';
    // 视频类型
    const UPLOAD_TYPE_VIDEO     = 'video';
    // 缩略图类型
    const UPLOAD_TYPE_THUMB     = 'thumb';

    // create menu URL
    const MENU_CREATE_URL   = 'https://api.weixin.qq.com/cgi-bin/menu/create?access_token=%s';

    // menu select url
    const MENU_SELECT_URL   = 'https://api.weixin.qq.com/cgi-bin/menu/get?access_token=%s';

    // menu delete url
    const MENU_DELETE_URL   = 'https://api.weixin.qq.com/cgi-bin/menu/delete?access_token=%s';

    // customer service account add url
    const CS_ACCOUNT_ADD_URL    = 'https://api.weixin.qq.com/customservice/kfaccount/add?access_token=%s';
    // customer service account update url
    const CS_ACCOUNT_UPDATE_URL = 'https://api.weixin.qq.com/customservice/kfaccount/update?access_token=%s';
    // customer service account delete url
    const CS_ACCOUNT_DELETE_URL = 'https://api.weixin.qq.com/customservice/kfaccount/del?access_token=%s';
    // customer service account list url
    const CS_ACCOUNT_LISTS_URL  = 'https://api.weixin.qq.com/cgi-bin/customservice/getkflist?access_token=%s';
    // the url of customer service send message to user
    const CS_SEND_MESSAGE_URL   = 'https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token=%s';
    // get user info url
    const USER_INFO_URL         = 'https://api.weixin.qq.com/cgi-bin/user/info?access_token=%s&openid=%s&lang=zh_CN';
    // 生成二维码
    const QR_CODE_URL           = 'https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=%s';
    // 获取二维码图片的URL
    const QR_IMAGE_URL          = 'https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=%s';
    // 临时素材上传接口
    const MEDIA_TEMP_UPLOAD_URL = 'https://api.weixin.qq.com/cgi-bin/media/upload?access_token=%s&type=%s';
    // 获取临时素材接口
    const MEDIA_TEMP_GET_URL    = 'https://api.weixin.qq.com/cgi-bin/media/get?access_token=%s&media_id=%s';

    // 通过OAuth2获取code
    const OAUTH2_LOGIN_CODE_URL   = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid=%s&redirect_uri=%s&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect';
    // 网页授权access token
    const OAUTH2_ACCESS_TOKEN_URL = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid=%s&secret=%s&code=%s&grant_type=authorization_code';
    // 网页授权获取用户信息
    const OAUTH2_GET_USER_INFO_URL= 'https://api.weixin.qq.com/sns/userinfo?access_token=%s&openid=%s';

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
     * @var Formatter
     */
    protected $formatter        = null;

    /**
     * token string which valid signature
     *
     * @var string
     */
    protected $tokenString      = null;

    /**
     * @var AccessToken
     */
    protected $accessToken      = null;

    /**
     * @var JsApiTicket
     */
    protected $jsApiTicket      = null;

    /**
     * Sdk constructor.
     * @param SdkParameter $parameter
     */
    public function __construct(SdkParameter $parameter)
    {
        $this->appId            = $parameter->getAppId();
        $this->appSecret        = $parameter->getAppSecret();
        $this->tokenFilePath    = $parameter->getTokenFilePath();
        $this->tokenString      = $parameter->getTokenString();

        $accessToken            = new AccessToken($this->appId, $this->appSecret, $this->tokenFilePath);
        $this->setAccessToken($accessToken);
        $this->setJsApiTicket(new JsApiTicket($accessToken, $parameter->getTicketFilePath()));
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
     * get token file path
     * @return string
     */
    public function getTokenFilePath()
    {
        return $this->tokenFilePath;
    }

    /**
     * get AccessToken instance
     *
     * @return AccessToken
     */
    public function getAccessToken()
    {
        return $this->accessToken;
    }

    /**
     * set AccessToken instance
     *
     * @param AccessToken $accessToken
     */
    public function setAccessToken(AccessToken $accessToken)
    {
        $this->accessToken = $accessToken;
    }

    /**
     * get access token
     * @return string
     * @throws Exception
     */
    public function getAccessTokenString()
    {
        return $this->getAccessToken()->getAccessToken();
    }

    /**
     * @return JsApiTicket
     */
    public function getJsApiTicket()
    {
        return $this->jsApiTicket;
    }

    /**
     * @param JsApiTicket $jsApiTicket
     */
    public function setJsApiTicket($jsApiTicket)
    {
        $this->jsApiTicket = $jsApiTicket;
    }

    /**
     * create menu
     * @param string $str
     * @return boolean
     * @throws Exception
     */
    public function createMenu($str)
    {
        $url    = sprintf(self::MENU_CREATE_URL, $this->getAccessTokenString());
        $client = $this->getHttpClient();
        $client->setUrl($url);
        $client->setHeaderArray(['Content-Type: application/json']);
        $client->setMethod(Client::METHOD_POST);
        $client->setPostFields($str);
        if (!$client->exec()) {
            throw new Exception("call createMenu fail");
        }

        $result = json_decode($client->getResponse(), true);
        if (isset($result['errcode']) && isset($result['errmsg'])) {
            return (0 == $result['errcode']);
        }

        throw new Exception("error response for create menu");
    }

    /**
     * get menu
     * @return array
     * @throws Exception
     */
    public function selectMenu()
    {
        $url    = sprintf(self::MENU_SELECT_URL, $this->getAccessTokenString());
        $client = $this->getHttpClient();
        $client->setUrl($url);
        $client->setHeaderArray(['Content-Type: application/json']);

        if (!$client->exec()) {
            throw new Exception("call select menu fail");
        }

        $result = json_decode($client->getResponse(), true);

        if (isset($result['errcode'])) {
            throw new Exception("error response for select menu");
        }

        return $result;
    }

    /**
     * delete menu
     * @return bool
     * @throws Exception
     */
    public function deleteMenu()
    {
        $url    = sprintf(self::MENU_DELETE_URL, $this->getAccessTokenString());
        $client = $this->getHttpClient();
        $client->setUrl($url);
        $client->setHeaderArray(['Content-Type: application/json']);

        if (!$client->exec()) {
            throw new Exception("call delete menu fail");
        }

        $result = json_decode($client->getResponse(), true);
        if (isset($result['errcode']) && isset($result['errmsg'])) {
            return (0 == $result['errcode']);
        }

        throw new Exception("error response for delete menu");
    }

    /**
     * create custom service param string
     *
     * @param string $account
     * @param string $nickName
     * @param string $password
     * @return string
     */
    protected function createCustomServiceParamString($account, $nickName, $password)
    {
        $result = "{ \"kf_account\" : \"{$account}\", " .
                    "\"nickname\" : \"{$nickName}\", " .
                    "\"password\" : \"{$password}\",}";

        return $result;
    }
    /**
     * add custom service account
     *
     * @param string $account
     * @param string $nickName
     * @param string $password
     * @return bool
     * @throws Exception
     */
    public function addCustomServiceAccount($account, $nickName, $password)
    {
        $url    = sprintf(self::CS_ACCOUNT_ADD_URL, $this->getAccessTokenString());
        $client = $this->getHttpClient();
        $client->setUrl($url);
        $client->setHeaderArray(['Content-Type: application/json']);
        $client->setMethod(Client::METHOD_POST);
        $client->setPostFields($this->createCustomServiceParamString($account, $nickName, $password));
        if (!$client->exec()) {
            throw new Exception("call addCustomServiceAccount fail");
        }

        $result = json_decode($client->getResponse(), true);
        if (isset($result['errcode']) && isset($result['errmsg'])) {
            return (0 == $result['errcode']);
        }

        throw new Exception("error response for add custom service account");
    }

    /**
     * update custom service account
     *
     * @param string $account
     * @param string $nickName
     * @param string $password
     * @return bool
     * @throws Exception
     */
    public function updateCustomServiceAccount($account, $nickName, $password)
    {
        $url    = sprintf(self::CS_ACCOUNT_UPDATE_URL, $this->getAccessTokenString());
        $client = $this->getHttpClient();
        $client->setUrl($url);
        $client->setHeaderArray(['Content-Type: application/json']);
        $client->setMethod(Client::METHOD_POST);
        $client->setPostFields($this->createCustomServiceParamString($account, $nickName, $password));
        if (!$client->exec()) {
            throw new Exception("call update custom service account fail");
        }

        $result = json_decode($client->getResponse(), true);
        if (isset($result['errcode']) && isset($result['errmsg'])) {
            return (0 == $result['errcode']);
        }

        throw new Exception("error response for update custom service account");
    }

    /**
     * delete custom service account
     *
     * @param string $account
     * @param string $nickName
     * @param string $password
     * @return bool
     * @throws Exception
     */
    public function deleteCustomServiceAccount($account, $nickName, $password)
    {
        $url    = sprintf(self::CS_ACCOUNT_UPDATE_URL, $this->getAccessTokenString());
        $client = $this->getHttpClient();
        $client->setUrl($url);
        $client->setHeaderArray(['Content-Type: application/json']);
        $client->setMethod(Client::METHOD_POST);
        $client->setPostFields($this->createCustomServiceParamString($account, $nickName, $password));
        if (!$client->exec()) {
            throw new Exception("call delete custom service account fail");
        }

        $result = json_decode($client->getResponse(), true);
        if (isset($result['errcode']) && isset($result['errmsg'])) {
            return (0 == $result['errcode']);
        }

        throw new Exception("error response for delete custom service account");
    }

    /**
     * get custom service account list
     * @return array
     * @throws Exception
     */
    public function getCustomServiceAccountList()
    {
        $url    = sprintf(self::CS_ACCOUNT_LISTS_URL, $this->getAccessTokenString());
        $client = $this->getHttpClient();
        $client->setUrl($url);
        $client->setHeaderArray(['Content-Type: application/json']);

        if (!$client->exec()) {
            throw new Exception("call get custom service account list fail");
        }

        $result = json_decode($client->getResponse(), true);
        if (isset($result['errcode'])) {
            throw new Exception("error response for get custom service account list");
        }

        return $result;
    }

    /**
     * get formatter
     * @return Message\Formatter
     */
    public function getFormatter()
    {
        if (null == $this->formatter) {
            $this->setFormatter(new Formatter());
        }

        return $this->formatter;
    }

    /**
     * set formatter
     *
     * @param Message\Formatter $formatter
     */
    public function setFormatter(Formatter $formatter)
    {
        $this->formatter = $formatter;
    }

    /**
     * send custom service message
     *
     * @param WxSendMsg $msg
     * @return bool
     * @throws Exception
     */
    public function sendCustomServiceMessage(WxSendMsg $msg)
    {
        $url    = sprintf(self::CS_SEND_MESSAGE_URL, $this->getAccessTokenString());
        $client = $this->getHttpClient();
        $client->setUrl($url);
        $client->setHeaderArray(['Content-Type: application/json']);
        $client->setMethod(Client::METHOD_POST);
        $client->setPostFields($this->getFormatter()->toJsonString($msg));
        if (!$client->exec()) {
            throw new Exception("call send custom service message fail");
        }

        $result = json_decode($client->getResponse(), true);
        if (isset($result['errcode']) && isset($result['errmsg'])) {
            return (0 == $result['errcode']);
        }

        throw new Exception("error response for sending custom service message");
    }

    /**
     * get token string
     *
     * @return string
     */
    public function getTokenString()
    {
        return $this->tokenString;
    }

    /**
     * valid Signature
     *
     * @param string $signature
     * @param string $timestamp
     * @param string $nonce
     * @return bool
     * @throws Exception
     */
    public function validSignature($signature, $timestamp, $nonce)
    {
        if ((null == $this->tokenString) || (empty($this->tokenString))) {
            throw new Exception("error token string");
        }

        $data = array($this->tokenString, $timestamp, $nonce);
        // use SORT_STRING rule
        sort($data, SORT_STRING);
        $validStr   = '';

        foreach ($data as $v) {
            $validStr .= $v;
        }

        $validStr = sha1($validStr);
        return ($validStr === $signature);
    }

    /**
     * get user info
     * @param string $openId
     * @return array
     * @throws Exception
     */
    public function getUserInfo($openId)
    {
        $url    = sprintf(self::USER_INFO_URL, $this->getAccessTokenString(), $openId);
        $client = $this->getHttpClient();
        $client->setUrl($url);
        $client->setHeaderArray(['Content-Type: application/json']);

        if (!$client->exec()) {
            throw new Exception("call get user info fail");
        }

        $result = json_decode($client->getResponse(), true);
        if (isset($result['errcode'])) {
            throw new Exception("error response for get user info");
        }

        return $result;
    }

    /**
     * create qr code ticket
     *
     * @param string $value
     * @param string $type
     * @return array
     * @throws Exception
     */
    protected function createQRCodeTicket($value, $type)
    {
        $url    = sprintf(self::QR_CODE_URL, $this->getAccessTokenString());
        $client = $this->getHttpClient();
        $client->setUrl($url);
        $client->setHeaderArray(['Content-Type: application/json']);
        $client->setMethod(Client::METHOD_POST);
        $str    = '{"expire_seconds": ' . self::QR_CODE_EXPIRE_TIME . ', "action_name": "%s", "action_info": {"scene": {"scene_id": %d}}}';
        $msg    = sprintf($str, $type, $value);
        $client->setPostFields($msg);
        if (!$client->exec()) {
            throw new Exception("call send custom service message fail");
        }

        $result = json_decode($client->getResponse(), true);

        if (isset($result['errcode'])) {
            throw new Exception("error response for createQRCodeTicket " . $result['errmsg']);
        }

        return $result;
    }

    /**
     * 临时二维码
     * @param string $value
     * @return array
     * @throws Exception
     */
    public function createTemplateQRCodeTicket($value)
    {
        return $this->createQRCodeTicket($value, self::QR_CODE_TEMPLATE_SCENE);
    }

    /**
     * 永久二维码
     * @param string $value
     * @return array
     * @throws Exception
     */
    public function createLimitQRCodeTicket($value)
    {
        return $this->createQRCodeTicket($value, self::QR_CODE_LIMIT_SCENE);
    }

    /**
     * 获取二维码的url
     *
     * @param string $ticket
     * @return string
     */
    public function getQRImageUrl($ticket)
    {
        return sprintf(self::QR_IMAGE_URL, urlencode(trim($ticket)));
    }

    /**
     * @param string $ticket
     * @param string $filePath
     * @return boolean
     * @throws Exception
     */
    public function downloadQRImage($ticket, $filePath)
    {
        $url    = $this->getQRImageUrl($ticket);
        $client = $this->getHttpClient();
        $client->setUrl($url);
        if (!$client->exec()) {
            throw new Exception("call download QRImage fail");
        }

        return $this->getFileSystem()->put($filePath, $client->getResponse()) > 0;
    }

    /**
     * 获取上传文件类型
     * @param string $type
     * @return string
     * @throws Exception
     */
    protected function getUpLoadContentType($type)
    {
        switch ($type) {
            case self::UPLOAD_TYPE_IMAGE:
                return 'image/jpg';
                break;
            case self::UPLOAD_TYPE_VIDEO:
                return 'video/mp4';
                break;
            case self::UPLOAD_TYPE_VOICE:
                return 'audio/amr';
                break;
            case self::UPLOAD_TYPE_THUMB:
                return 'image/jpg';
                break;
            //@codeCoverageIgnoreStart
            default:
                break;
        }

        throw new Exception("unknown upload file type({$type})");
        //@codeCoverageIgnoreEnd
    }
    /**
     * 上传临时素材
     * @param string $filePath
     * @param string $type
     * @return array
     * @throws Exception
     */
    protected function uploadTemp($filePath, $type)
    {
        $url = sprintf(self::MEDIA_TEMP_UPLOAD_URL, $this->getAccessTokenString(), $type);
        $client = $this->getHttpClient();
        $client->setUrl($url);
        $client->setMethod(Client::METHOD_UPLOAD);

        $basename = basename($filePath);

        $client->setPostDataArray([ 'media'          => curl_file_create($filePath),
                                    'filename'      => $basename,
                                    'filelength'    => filesize($filePath),
                                    'content-type'  => $this->getUpLoadContentType($type),
                                    'hack'          => '',
                                    ]);
        if (!$client->exec()) {
            throw new Exception("call send custom service message fail");
        }

        $result = json_decode($client->getResponse(), true);

        if (isset($result['errcode'])) {
            throw new Exception("error response for upload Temp info " . $result['errcode'] . ' ' . $result['errmsg']);
        }

        return $result;
    }

    /**
     * 上传图片
     * @param string $filePath
     * @return array
     */
    public function uploadTempImage($filePath)
    {
        return $this->uploadTemp($filePath, self::UPLOAD_TYPE_IMAGE);
    }

    /**
     * 上传语音
     * @param string $filePath
     * @return array
     */
    public function uploadTempVoice($filePath)
    {
        return $this->uploadTemp($filePath, self::UPLOAD_TYPE_VOICE);
    }

    /**
     * 上传视频
     * @param string $filePath
     * @return array
     */
    public function uploadTempVideo($filePath)
    {
        return $this->uploadTemp($filePath, self::UPLOAD_TYPE_VIDEO);
    }

    /**
     * 上传缩略图
     * @param string $filePath
     * @return array
     */
    public function uploadTempThumb($filePath)
    {
        return $this->uploadTemp($filePath, self::UPLOAD_TYPE_THUMB);
    }

    /**
     * 获取素材接口
     *
     * @param string $mediaId
     * @return string
     */
    public function getMediaUrl($mediaId)
    {
        return sprintf(self::MEDIA_TEMP_GET_URL, $this->getAccessTokenString(), trim($mediaId));
    }
    /**
     * 下载临时素材
     * @param string $mediaId
     * @param string $filePath
     * @return boolean
     * @throws Exception
     */
    public function downloadMedia($mediaId, $filePath)
    {
        $url    = $this->getMediaUrl($mediaId);
        $client = $this->getHttpClient();
        $client->setUrl($url);
        if (!$client->exec()) {
            throw new Exception("call download Media fail");
        }

        return $this->getFileSystem()->put($filePath, $client->getResponse()) > 0;
    }

    /**
     * 拼接OAUTH2的CODE url
     * @param string $redirectUrl
     * @return string
     */
    public function getOAuth2Url($redirectUrl) {
        return sprintf(self::OAUTH2_LOGIN_CODE_URL, $this->appId, urlencode($redirectUrl));
    }

    /**
     * 获取网页授权access_token
     *
     * @param string $code
     * @return array
     * @throws Exception
     */
    public function getOAuth2AccessToken($code) {
        $url = sprintf(self::OAUTH2_ACCESS_TOKEN_URL, $this->appId, $this->appSecret, $code);
        $client = $this->getHttpClient();
        $client->setUrl($url);
        $client->setHeaderArray(['Content-Type: application/json']);

        if (!$client->exec()) {
            throw new Exception("call get oauth2 access token fail");
        }

        $result = json_decode($client->getResponse(), true);
        if (!(isset($result['access_token']) && isset($result['openid']))) {
            throw new Exception("call get oauth2 access token fail url({$url}) access_token or openid is not exists, response:" . $client->getResponse());
        }

        return ['accessToken' => trim($result['access_token']), 'openId' => trim($result['openid'])];
    }

    /**
     * 获取用户个人信息（UnionID机制）
     * 接口说明
     * 此接口用于获取用户个人信息。开发者可通过OpenID来获取用户基本信息。特别需要注意的是，如果开发者拥有多个移动应用、
     * 网站应用和公众帐号，可通过获取用户基本信息中的unionid来区分用户的唯一性，因为只要是同一个微信开放平台帐号下的移动应用、
     * 网站应用和公众帐号，用户的unionid是唯一的。换句话说，同一用户，对同一个微信开放平台下的不同应用，unionid是相同的。
     *
     * @param string $accessToken
     * @param string $openId
     * @return array
     * @throws Exception
     */
    public function getOAuth2UserInfo($accessToken, $openId) {
        $url = sprintf(self::OAUTH2_GET_USER_INFO_URL, $accessToken, $openId);
        $client = $this->getHttpClient();
        $client->setUrl($url);
        $client->setHeaderArray(['Content-Type: application/json']);

        if (!$client->exec()) {
            throw new Exception("call get oauth2 access token fail");
        }

        $result = json_decode($client->getResponse(), true);
        return $result;
    }

    /**
     * 生成NonceStr随机串
     *
     * @return string
     */
    public function createNonceStr() {
        $chars  = "abcdefghijklmnopqrstuvwxyz0123456789";
        $str    = "";
        for ( $i = 0; $i < self::NONCE_STRING_LENGTH; $i++ ) {
            $str .= substr($chars, mt_rand(0, strlen($chars)-1), 1);
        }

        return $str;
    }

    /**
     * 生成JS API的签名
     * @param string $nonceStr
     * @param int $time
     * @param string $url
     * @return string
     */
    public function createSignature($nonceStr, $time, $url) {
        $str = "jsapi_ticket=%s&noncestr=%s&timestamp=%d&url=%s";
        $result = sprintf($str, $this->getJsApiTicket()->getTicket(), $nonceStr, $time, $url);
        return sha1($result);
    }

    /**
     * 下载头像图片,并保存为
     * @param $url
     * @param $savePath
     * @return bool
     * @throws Exception
     */
    public function downloadHeadImage($url, $savePath) {
        $client = $this->getHttpClient();
        $client->setUrl($url);
        if (!$client->exec()) {
            throw new Exception("call download QRImage fail");
        }

        return $this->getFileSystem()->put($savePath, $client->getResponse()) > 0;
    }
}
