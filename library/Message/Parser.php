<?php
namespace WeChat\Message;

use Simple\Helper\Helper;
use WeChat\AbstractParser;

class Parser extends AbstractParser
{
    /**
     * load and parser notice string which come from WeChat server
     *
     * @param array $data
     * @return WxReceiveMsg
     * @throws \RuntimeException
     */
    public function load(array $data)
    {
        switch($data['MsgType']) {
            case WxReceiveMsg::MSG_TYPE_TEXT:
                return $this->createReceiveTextMsg($data);
                break;
            case WxReceiveMsg::MSG_TYPE_IMAGE:
                return $this->createReceiveImageMsg($data);
                break;
            case WxReceiveMsg::MSG_TYPE_LINK:
                return $this->createReceiveLinkMsg($data);
                break;
            case WxReceiveMsg::MSG_TYPE_SHORT_VIDEO:
                return $this->createReceiveShortVideoMsg($data);
                break;
            case WxReceiveMsg::MSG_TYPE_VIDEO:
                return $this->createReceiveVideoMsg($data);
                break;
            case WxReceiveMsg::MSG_TYPE_VOICE:
                return $this->createReceiveVoiceMsg($data);
                break;
            case WxReceiveMsg::MSG_TYPE_LOCATION:
                return $this->createReceiveLocationMsg($data);
                break;
            default:
                break;
        }

        throw new \RuntimeException("unknown MsgType({$data['MsgType']})");
    }

    /**
     * @param WxReceiveMsg $msg
     * @param array $data
     * @return WxReceiveMsg
     */
    protected function initReceiveMsg(WxReceiveMsg $msg, array $data)
    {
        $this->initReceive($msg, $data);
        $msg->setMsgId(isset($data['MsgId']) ? trim($data['MsgId']) : 0);

        return $msg;
    }

    /**
     * create image msg
     *
     * @param array $data
     * @return WxReceiveImageMsg
     */
    protected function createReceiveImageMsg(array $data)
    {
        $result = new WxReceiveImageMsg();
        $this->initReceiveMsg($result, $data);
        $result->setMediaId(isset($data['MediaId']) ? trim($data['MediaId']) : '');
        $result->setPicUrl(isset($data['PicUrl']) ? trim($data['PicUrl']) : '');
        return $result;
    }

    /**
     * create link msg
     *
     * @param array $data
     * @return WxReceiveLinkMsg
     */
    protected function createReceiveLinkMsg(array $data)
    {
        $result = new WxReceiveLinkMsg();
        $this->initReceiveMsg($result, $data);
        $result->setTitle(isset($data['Title']) ? trim($data['Title']) : '');
        $result->setDescription(isset($data['Description']) ? trim($data['Description']) : '');
        $result->setUrl(isset($data['Url']) ? trim($data['Url']) : '');
        return $result;
    }

    /**
     * create location msg
     *
     * @param array $data
     * @return WxReceiveLocationMsg
     */
    protected function createReceiveLocationMsg(array $data)
    {
        $result = new WxReceiveLocationMsg();
        $this->initReceiveMsg($result, $data);
        $result->setLocationX(isset($data['Location_X']) ? $data['Location_X']: '');
        $result->setLocationY(isset($data['Location_Y']) ? $data['Location_Y'] : '');
        $result->setScale(isset($data['Scale']) ? $data['Scale'] : '');
        $result->setLabel(isset($data['Label']) ? trim($data['Label']) : '');
        return $result;
    }

    /**
     * create short video msg
     *
     * @param array $data
     * @return WxReceiveShortVideoMsg
     */
    protected function createReceiveShortVideoMsg(array $data)
    {
        $result = new WxReceiveShortVideoMsg();
        $this->initReceiveMsg($result, $data);
        $result->setMediaId(isset($data['MediaId']) ? trim($data['MediaId']) : '');
        $result->setThumbMediaId(isset($data['ThumbMediaId']) ? trim($data['ThumbMediaId']) : '');
        return $result;
    }

    /**
     * create text msg
     *
     * @param array $data
     * @return WxReceiveTextMsg
     */
    protected function createReceiveTextMsg(array $data)
    {
        $result = new WxReceiveTextMsg();
        $this->initReceiveMsg($result, $data);
        if (isset($data['Content'])) {
            if (!is_string($data['Content'])) {
                Helper::getLogWriter()->debug("[createReceiveTextMsg]" . serialize($data));
                $data['Content'] = '';
            }
        }

        $result->setContent(isset($data['Content']) ? trim($data['Content']) : '');
        return $result;
    }

    /**
     * create video msg
     *
     * @param array $data
     * @return WxReceiveVideoMsg
     */
    protected function createReceiveVideoMsg(array $data)
    {
        $result = new WxReceiveVideoMsg();
        $this->initReceiveMsg($result, $data);
        $result->setMediaId(isset($data['MediaId']) ? trim($data['MediaId']) : '');
        $result->setThumbMediaId(isset($data['ThumbMediaId']) ? trim($data['ThumbMediaId']) : '');
        return $result;
    }

    /**
     * create Voice msg
     *
     * @param array $data
     * @return WxReceiveVoiceMsg
     */
    protected function createReceiveVoiceMsg(array $data)
    {
        $result = new WxReceiveVoiceMsg();
        $this->initReceiveMsg($result, $data);
        $result->setMediaId(isset($data['MediaId']) ? trim($data['MediaId']) : '');
        $result->setFormat(isset($data['Format']) ? trim($data['Format']) : '');
        return $result;
    }
}
