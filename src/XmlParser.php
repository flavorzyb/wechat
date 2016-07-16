<?php
namespace WeChat;

class XmlParser
{
    /**
     * parse xml string which come from WeChat server
     * to WxReceiveMsg or WxReceiveEvent
     * @param $xmlString
     * @return WxReceive
     */
    public function load($xmlString)
    {
        $data   =  $this->parserXml($xmlString);

        if (!isset($data['MsgType'])) {
            throw new \RuntimeException("can not found MsgType");
        }

        // event message
        if (WxReceive::MSG_TYPE_EVENT == $data['MsgType']) {
            $parser = new Event\Parser();
            return $parser->load($data);
        }

        // other message
        $parser = new Message\Parser();
        return $parser->load($data);
    }

    /**
     * parse xml to array
     *
     * @param $xmlString
     * @return array
     */
    protected function parserXml($xmlString)
    {
        libxml_disable_entity_loader(true);
        return json_decode(json_encode(simplexml_load_string($xmlString,'SimpleXMLElement', LIBXML_NOCDATA), true), true);
    }
}
