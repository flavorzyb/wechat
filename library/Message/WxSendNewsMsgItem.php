<?php
namespace WeChat\Message;


/**
 * Class WxSendNewsMsgItem
 * @package Webiz\Modules

<item>
<Title><![CDATA[title1]]></Title>
<Description><![CDATA[description1]]></Description>
<PicUrl><![CDATA[picurl]]></PicUrl>
<Url><![CDATA[url]]></Url>
</item>
 */
class WxSendNewsMsgItem
{
    /**
     * 图文消息标题
     * @var string
     */
    protected $title        = null;
    /**
     * 图文消息描述
     * @var string
     */
    protected $description  = null;
    /**
     * 图片链接，支持JPG、PNG格式，较好的效果为大图360*200，小图200*200
     * @var string
     */
    protected $picUrl       = null;
    /**
     * 点击图文消息跳转链接
     * @var string
     */
    protected $url          = null;

    /**
     * 图文消息标题
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * 图文消息标题
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * 图文消息描述
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * 图文消息描述
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * 图片链接，支持JPG、PNG格式，较好的效果为大图360*200，小图200*200
     * @return string
     */
    public function getPicUrl()
    {
        return $this->picUrl;
    }

    /**
     * 图片链接，支持JPG、PNG格式，较好的效果为大图360*200，小图200*200
     * @param string $picUrl
     */
    public function setPicUrl($picUrl)
    {
        $this->picUrl = $picUrl;
    }

    /**
     * 点击图文消息跳转链接
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * 点击图文消息跳转链接
     * @param string $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * to array
     * @return array
     */
    public function toArray()
    {
        return [
                'title'         => $this->title,
                'description'   => $this->description,
                'picUrl'        => $this->picUrl,
                'url'           => $this->url,
                ];
    }
}
