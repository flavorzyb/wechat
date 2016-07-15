<?php
namespace WeChat\Message;


class Formatter
{
    /**
     * formatter WxSendMsg
     * @param WxSendMsg $msg
     * @return string
     */
    public function toXmlString(WxSendMsg $msg)
    {
        if ($msg instanceof WxSendTextMsg) {
            return $this->sendTextMsgToXmlString($msg);
        } elseif ($msg instanceof WxSendImageMsg) {
            return $this->sendImageMsgToXmlString($msg);
        } elseif ($msg instanceof WxSendVoiceMsg) {
            return $this->sendVoiceMsgToXmlString($msg);
        } elseif ($msg instanceof WxSendVideoMsg) {
            return $this->sendVideoMsgToXmlString($msg);
        } elseif ($msg instanceof WxSendMusicMsg) {
            return $this->sendMusicMsgToXmlString($msg);
        } elseif ($msg instanceof WxSendNewsMsg) {
            return $this->sendNewsMsgToXmlString($msg);
        }

        throw new \InvalidArgumentException("unknown wx send msg");
    }

    /**
     * formatter WxSendTextMsg to xml string
     * @param WxSendTextMsg $msg
     * @return string
     */
    protected function sendTextMsgToXmlString(WxSendTextMsg $msg)
    {
        $formatStr = <<<XML
<xml>
<ToUserName><![CDATA[%s]]></ToUserName>
<FromUserName><![CDATA[%s]]></FromUserName>
<CreateTime>%d</CreateTime>
<MsgType><![CDATA[%s]]></MsgType>
<Content><![CDATA[%s]]></Content>
</xml>
XML;
        $result = sprintf($formatStr,   $msg->getToUserName(),
                                        $msg->getFromUserName(),
                                        strtotime($msg->getCreateTime()),
                                        $msg->getMsgType(),
                                        $msg->getContent()
                        );


        return $result;
    }

    /**
     * formatter WxSendImageMsg to xml string
     * @param WxSendImageMsg $msg
     * @return string
     */
    protected function sendImageMsgToXmlString(WxSendImageMsg $msg)
    {
        $formatStr = <<<XML
<xml>
<ToUserName><![CDATA[%s]]></ToUserName>
<FromUserName><![CDATA[%s]]></FromUserName>
<CreateTime>%d</CreateTime>
<MsgType><![CDATA[%s]]></MsgType>
<Image>
<MediaId><![CDATA[%s]]></MediaId>
</Image>
</xml>
XML;
        $result = sprintf($formatStr,   $msg->getToUserName(),
                                        $msg->getFromUserName(),
                                        strtotime($msg->getCreateTime()),
                                        $msg->getMsgType(),
                                        $msg->getMediaId()
                        );


        return $result;
    }

    /**
     * formatter WxSendVoiceMsg to xml string
     * @param WxSendVoiceMsg $msg
     * @return string
     */
    protected function sendVoiceMsgToXmlString(WxSendVoiceMsg $msg)
    {
        $formatStr = <<<XML
<xml>
<ToUserName><![CDATA[%s]]></ToUserName>
<FromUserName><![CDATA[%s]]></FromUserName>
<CreateTime>%d</CreateTime>
<MsgType><![CDATA[%s]]></MsgType>
<Voice>
<MediaId><![CDATA[%s]]></MediaId>
</Voice>
</xml>
XML;
        $result = sprintf($formatStr,   $msg->getToUserName(),
                                        $msg->getFromUserName(),
                                        strtotime($msg->getCreateTime()),
                                        $msg->getMsgType(),
                                        $msg->getMediaId()
                        );


        return $result;
    }

    /**
     * formatter WxSendVideoMsg to xml string
     * @param WxSendVideoMsg $msg
     * @return string
     */
    protected function sendVideoMsgToXmlString(WxSendVideoMsg $msg)
    {
        $formatStr = <<<XML
<xml>
<ToUserName><![CDATA[%s]]></ToUserName>
<FromUserName><![CDATA[%s]]></FromUserName>
<CreateTime>%d</CreateTime>
<MsgType><![CDATA[%s]]></MsgType>
<Video>
<MediaId><![CDATA[%s]]></MediaId>
<Title><![CDATA[%s]]></Title>
<Description><![CDATA[%s]]></Description>
</Video>
</xml>
XML;
        $result = sprintf($formatStr,   $msg->getToUserName(),
                                        $msg->getFromUserName(),
                                        strtotime($msg->getCreateTime()),
                                        $msg->getMsgType(),
                                        $msg->getMediaId(),
                                        $msg->getTitle(),
                                        $msg->getDescription()
                        );

        return $result;
    }

    /**
     * formatter WxSendMusicMsg to xml string
     * @param WxSendMusicMsg $msg
     * @return string
     */
    protected function sendMusicMsgToXmlString(WxSendMusicMsg $msg)
    {
        $formatStr = <<<XML
<xml>
<ToUserName><![CDATA[%s]]></ToUserName>
<FromUserName><![CDATA[%s]]></FromUserName>
<CreateTime>%d</CreateTime>
<MsgType><![CDATA[%s]]></MsgType>
<Music>
<Title><![CDATA[%s]]></Title>
<Description><![CDATA[%s]]></Description>
<MusicUrl><![CDATA[%s]]></MusicUrl>
<HQMusicUrl><![CDATA[%s]]></HQMusicUrl>
<ThumbMediaId><![CDATA[%s]]></ThumbMediaId>
</Music>
</xml>
XML;
        $result = sprintf($formatStr,   $msg->getToUserName(),
                                        $msg->getFromUserName(),
                                        strtotime($msg->getCreateTime()),
                                        $msg->getMsgType(),
                                        $msg->getTitle(),
                                        $msg->getDescription(),
                                        $msg->getMusicUrl(),
                                        $msg->getHQMusicUrl(),
                                        $msg->getThumbMediaId()
                                    );

        return $result;
    }

    /**
     * formatter WxSendNewsMsg to xml string
     * @param WxSendNewsMsg $msg
     * @return string
     */
    protected function sendNewsMsgToXmlString(WxSendNewsMsg $msg)
    {
        $itemArray  = $msg->getAllArticleItems();
        $itemStr    = '';
        foreach ($itemArray as $item) {
            $itemStr .= $this->sendNewsItemToXmlString($item);
        }

        $formatStr = <<<XML
<xml>
<ToUserName><![CDATA[%s]]></ToUserName>
<FromUserName><![CDATA[%s]]></FromUserName>
<CreateTime>%d</CreateTime>
<MsgType><![CDATA[%s]]></MsgType>
<ArticleCount>%d</ArticleCount>
<Articles>
%s
</Articles>
</xml>
XML;

        $result = sprintf($formatStr,   $msg->getToUserName(),
                                        $msg->getFromUserName(),
                                        strtotime($msg->getCreateTime()),
                                        $msg->getMsgType(),
                                        $msg->getArticleCount(),
                                        $itemStr
                        );

        return $result;
    }

    /**
     * formatter WxSendNewsMsgItem to xml string
     *
     * @param WxSendNewsMsgItem $item
     * @return string
     */
    protected function sendNewsItemToXmlString(WxSendNewsMsgItem $item)
    {
        $formatStr = <<<XML
<item>
<Title><![CDATA[%s]]></Title>
<Description><![CDATA[%s]]></Description>
<PicUrl><![CDATA[%s]]></PicUrl>
<Url><![CDATA[%s]]></Url>
</item>
XML;
        $result = sprintf($formatStr,   $item->getTitle(),
                                        $item->getDescription(),
                                        $item->getPicUrl(),
                                        $item->getUrl()
                        );

        return $result;
    }

    /**
     * formatter to json string
     *
     * @param WxSendMsg $msg
     * @return string
     */
    public function toJsonString(WxSendMsg $msg)
    {
        if ($msg instanceof WxSendTextMsg) {
            return $this->sendTextMsgToJsonString($msg);
        } elseif ($msg instanceof WxSendImageMsg) {
            return $this->sendImageMsgToJsonString($msg);
        } elseif ($msg instanceof WxSendVoiceMsg) {
            return $this->sendVoiceMsgToJsonString($msg);
        } elseif ($msg instanceof WxSendVideoMsg) {
            return $this->sendVideoMsgToJsonString($msg);
        } elseif ($msg instanceof WxSendMusicMsg) {
            return $this->sendMusicMsgToJsonString($msg);
        } elseif ($msg instanceof WxSendNewsMsg) {
            return $this->sendNewsMsgToJsonString($msg);
        }

        throw new \InvalidArgumentException("unknown wx send msg");
    }

    /**
     * formatter WxSendTextMsg to Json string
     * @param WxSendTextMsg $msg
     * @return string
     */
    protected function sendTextMsgToJsonString(WxSendTextMsg $msg)
    {
        $formatStr = '{
                        "touser":"%s",
                        "msgtype":"%s",
                        "text":
                        {
                             "content":"%s"
                        }
                    }';
        $result = sprintf($formatStr,   $msg->getToUserName(),
                                        $msg->getMsgType(),
                                        $msg->getContent()
                        );


        return $result;
    }

    /**
     * formatter WxSendImageMsg to Json string
     * @param WxSendImageMsg $msg
     * @return string
     */
    protected function sendImageMsgToJsonString(WxSendImageMsg $msg)
    {
        $formatStr = '{
                        "touser":"%s",
                        "msgtype":"%s",
                        "image":
                        {
                          "media_id":"%s"
                        }
                    }';
        $result = sprintf($formatStr,   $msg->getToUserName(),
                                        $msg->getMsgType(),
                                        $msg->getMediaId()
                        );


        return $result;
    }

    /**
     * formatter WxSendVoiceMsg to Json string
     * @param WxSendVoiceMsg $msg
     * @return string
     */
    protected function sendVoiceMsgToJsonString(WxSendVoiceMsg $msg)
    {
        $formatStr = '{
                        "touser":"%s",
                        "msgtype":"%s",
                        "voice":
                        {
                          "media_id":"%s"
                        }
                    }';
        $result = sprintf($formatStr,   $msg->getToUserName(),
                                        $msg->getMsgType(),
                                        $msg->getMediaId()
                        );


        return $result;
    }

    /**
     * formatter WxSendVideoMsg to Json string
     * @param WxSendVideoMsg $msg
     * @return string
     */
    protected function sendVideoMsgToJsonString(WxSendVideoMsg $msg)
    {
        $formatStr = '{
                        "touser":"%s",
                        "msgtype":"%s",
                        "video":
                        {
                          "media_id":"%s",
                          "thumb_media_id":"%s",
                          "title":"%s",
                          "description":"%s"
                        }
                    }';
        $result = sprintf($formatStr,   $msg->getToUserName(),
                                        $msg->getMsgType(),
                                        $msg->getMediaId(),
                                        $msg->getThumbMediaId(),
                                        $msg->getTitle(),
                                        $msg->getDescription()
                        );

        return $result;
    }

    /**
     * formatter WxSendMusicMsg to Json string
     * @param WxSendMusicMsg $msg
     * @return string
     */
    protected function sendMusicMsgToJsonString(WxSendMusicMsg $msg)
    {
        $formatStr = '{
                        "touser":"%s",
                        "msgtype":"%s",
                        "music":
                        {
                          "title":"%s",
                          "description":"%s",
                          "musicurl":"%s",
                          "hqmusicurl":"%s",
                          "thumb_media_id":"%s"
                        }
                    }';
        $result = sprintf($formatStr,   $msg->getToUserName(),
                                        $msg->getMsgType(),
                                        $msg->getTitle(),
                                        $msg->getDescription(),
                                        $msg->getMusicUrl(),
                                        $msg->getHQMusicUrl(),
                                        $msg->getThumbMediaId()
                            );

        return $result;
    }

    /**
     * formatter WxSendNewsMsg to Json string
     * @param WxSendNewsMsg $msg
     * @return string
     */
    protected function sendNewsMsgToJsonString(WxSendNewsMsg $msg)
    {
        $itemArray  = $msg->getAllArticleItems();
        $itemStr    = '';
        foreach ($itemArray as $item) {
            $itemStr .= $this->sendNewsItemToJsonString($item) . ',';
        }

        $itemStr    = substr($itemStr, 0, -1);

        $formatStr = '{
                        "touser":"%s",
                        "msgtype":"%s",
                        "news":{
                            "articles": [
                             %s
                             ]
                        }
                    }';

        $result = sprintf($formatStr,   $msg->getToUserName(),
                                        $msg->getMsgType(),
                                        $itemStr
                            );

        return $result;
    }

    /**
     * formatter WxSendNewsMsgItem to Json string
     *
     * @param WxSendNewsMsgItem $item
     * @return string
     */
    protected function sendNewsItemToJsonString(WxSendNewsMsgItem $item)
    {
        $formatStr = '{
                         "title":"%s",
                         "description":"%s",
                         "url":"%s",
                         "picurl":"%s"
                     }';
        $result = sprintf($formatStr,   $item->getTitle(),
            $item->getDescription(),
            $item->getPicUrl(),
            $item->getUrl()
        );

        return $result;
    }
}
