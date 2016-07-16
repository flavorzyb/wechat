<?php
namespace WeChat\Message;

/**
 * Class WxSendMusicMsg
 * @package Webiz\Modules
<xml>
<ToUserName><![CDATA[toUser]]></ToUserName>
<FromUserName><![CDATA[fromUser]]></FromUserName>
<CreateTime>12345678</CreateTime>
<MsgType><![CDATA[music]]></MsgType>
<Music>
<Title><![CDATA[TITLE]]></Title>
<Description><![CDATA[DESCRIPTION]]></Description>
<MusicUrl><![CDATA[MUSIC_Url]]></MusicUrl>
<HQMusicUrl><![CDATA[HQ_MUSIC_Url]]></HQMusicUrl>
<ThumbMediaId><![CDATA[media_id]]></ThumbMediaId>
</Music>
</xml>
 */
class WxSendMusicMsg extends WxSendMsg
{
    /**
     * 音乐标题
     * @var string
     */
    protected $title        = null;
    /**
     * 音乐描述
     * @var string
     */
    protected $description  = null;

    /**
     * 音乐链接
     * @var string
     */
    protected $musicUrl     = null;

    /**
     * 高质量音乐链接，WIFI环境优先使用该链接播放音乐
     * @var string
     */
    protected $hQMusicUrl   = null;

    /**
     * 缩略图的媒体id，通过素材管理接口上传多媒体文件，得到的id
     * @var string
     */
    protected $thumbMediaId = null;

    /**
     * WxSendMusicMsg constructor.
     */
    public function __construct()
    {
        $this->msgType  = self::MSG_TYPE_MUSIC;
    }

    /**
     * 音乐标题
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * 音乐标题
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * 音乐描述
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * 音乐描述
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * 音乐链接
     * @return string
     */
    public function getMusicUrl()
    {
        return $this->musicUrl;
    }

    /**
     * 音乐链接
     * @param string $musicUrl
     */
    public function setMusicUrl($musicUrl)
    {
        $this->musicUrl = $musicUrl;
    }

    /**
     * 高质量音乐链接，WIFI环境优先使用该链接播放音乐
     * @return string
     */
    public function getHQMusicUrl()
    {
        return $this->hQMusicUrl;
    }

    /**
     * 高质量音乐链接，WIFI环境优先使用该链接播放音乐
     * @param string $hQMusicUrl
     */
    public function setHQMusicUrl($hQMusicUrl)
    {
        $this->hQMusicUrl = $hQMusicUrl;
    }

    /**
     * 缩略图的媒体id，通过素材管理接口上传多媒体文件，得到的id
     * @return string
     */
    public function getThumbMediaId()
    {
        return $this->thumbMediaId;
    }

    /**
     * 缩略图的媒体id，通过素材管理接口上传多媒体文件，得到的id
     * @param string $thumbMediaId
     */
    public function setThumbMediaId($thumbMediaId)
    {
        $this->thumbMediaId = $thumbMediaId;
    }

    /**
     * to array
     * @return array
     */
    public function toArray()
    {
        $result                 = parent::toArray();
        $result['title']        = $this->title;
        $result['description']  = $this->description;
        $result['musicUrl']     = $this->musicUrl;
        $result['hQMusicUrl']   = $this->hQMusicUrl;
        $result['thumbMediaId'] = $this->thumbMediaId;

        return $result;
    }
}
