<?php
namespace WeChat\Message;

/**
 * Class WxSendNewsMsg
 * @package Webiz\Modules
 *
<xml>
<ToUserName><![CDATA[toUser]]></ToUserName>
<FromUserName><![CDATA[fromUser]]></FromUserName>
<CreateTime>12345678</CreateTime>
<MsgType><![CDATA[news]]></MsgType>
<ArticleCount>2</ArticleCount>
<Articles>
<item>
<Title><![CDATA[title1]]></Title>
<Description><![CDATA[description1]]></Description>
<PicUrl><![CDATA[picurl]]></PicUrl>
<Url><![CDATA[url]]></Url>
</item>
<item>
<Title><![CDATA[title]]></Title>
<Description><![CDATA[description]]></Description>
<PicUrl><![CDATA[picurl]]></PicUrl>
<Url><![CDATA[url]]></Url>
</item>
</Articles>
</xml>
 */
class WxSendNewsMsg extends WxSendMsg
{
    /**
     * 图文消息个数，限制为10条以内
     */
    const MAX_ITEMS_COUNT = 10;
    /**
     * article items
     *
     * @var array
     */
    protected $articles = [];

    public function __construct()
    {
        $this->msgType  = self::MSG_TYPE_NEWS;
    }

    /**
     * article items count
     *
     * @return int
     */
    public function getArticleCount()
    {
        return sizeof($this->articles);
    }

    /**
     * add a article item
     * @param WxSendNewsMsgItem $item
     */
    public function addArticleItem(WxSendNewsMsgItem $item)
    {
        if (sizeof($this->articles) >= self::MAX_ITEMS_COUNT) {
            array_shift($this->articles);
        }

        $this->articles[] = $item;
    }

    /**
     * get all article items
     * @return array
     */
    public function getAllArticleItems()
    {
        return $this->articles;
    }

    /**
     * to array
     *
     * @return array
     */
    public function toArray()
    {
        $articles   = [];
        foreach ($this->articles as $item)
        {
            $articles[] = $item->toArray();
        }

        $result = parent::toArray();
        $result['articles'] = $articles;

        return $result;
    }
}
