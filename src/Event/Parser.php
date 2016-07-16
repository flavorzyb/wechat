<?php
namespace WeChat\Event;

use WeChat\AbstractParser;
use RuntimeException;

class Parser extends AbstractParser
{
    /**
     * load and parser notice string which come from WeChat server
     *
     * @param array $data
     * @return WxReceiveEvent
     * @throws RuntimeException
     */
    public function load(array $data)
    {
        switch($data['Event']) {
            case WxReceiveEvent::EVENT_TYPE_LOCATION:
                return $this->createLocationEvent($data);
                break;
            case WxReceiveEvent::EVENT_TYPE_VIEW:
                return $this->createViewEvent($data);
                break;
            case WxReceiveEvent::EVENT_TYPE_CLICK:
                return $this->createClickEvent($data);
                break;
            case WxReceiveEvent::EVENT_TYPE_SCAN:
                return $this->createScanEvent($data);
                break;
            case WxReceiveEvent::EVENT_TYPE_SUBSCRIBE:
            case WxReceiveEvent::EVENT_TYPE_UN_SUBSCRIBE:
                return $this->createSubscribeEvent($data);
                break;
            default:
                break;
        }

        throw new RuntimeException("unknown Event({$data['Event']})");
    }

    /**
     * create WxReceiveLocationEvent instance
     *
     * @param array $data
     * @return WxReceiveLocationEvent
     */
    protected function createLocationEvent(array $data)
    {
        $result = new WxReceiveLocationEvent();
        $this->initReceive($result, $data);

        $result->setLatitude($data['Latitude']);
        $result->setLongitude($data['Longitude']);
        $result->setPrecision($data['Precision']);

        return $result;
    }

    /**
     * create WxReceiveViewEvent instance
     *
     * @param array $data
     * @return WxReceiveViewEvent
     */
    protected function createViewEvent(array $data)
    {
        $result = new WxReceiveViewEvent();
        $this->initReceive($result, $data);

        $result->setEventKey($data['EventKey']);

        return $result;
    }

    /**
     * create WxReceiveClickEvent instance
     *
     * @param array $data
     * @return WxReceiveClickEvent
     */
    protected function createClickEvent(array $data)
    {
        $result = new WxReceiveClickEvent();
        $this->initReceive($result, $data);

        $result->setEventKey($data['EventKey']);

        return $result;
    }

    /**
     * create WxReceiveScanEvent instance
     * @param array $data
     * @return WxReceiveScanEvent
     */
    protected function createScanEvent(array $data)
    {
        $result = new WxReceiveScanEvent();
        $this->initReceive($result, $data);

        $result->setEvent($data['Event']);
        $result->setEventKey($data['EventKey']);
        $result->setTicket($data['Ticket']);

        return $result;
    }

    /**
     * create WxReceiveEvent instance
     * @param array $data
     * @return WxReceiveEvent
     */
    protected function createSubscribeEvent(array $data)
    {
        if (isset($data['EventKey']) && isset($data['Ticket']) && (WxReceiveEvent::EVENT_TYPE_SUBSCRIBE == $data['Event'])) {
            return $this->createScanEvent($data);
        }

        $result = new WxReceiveSubscribeEvent();
        $this->initReceive($result, $data);
        $result->setEvent($data['Event']);

        return $result;
    }
}
