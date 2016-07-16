<?php
namespace WeChat\Message;


abstract class WxSendMediaMsg extends WxSendMsg
{
    /**
     * 通过素材管理接口上传多媒体文件，得到的id
     * @var string
     */
    protected $mediaId  = null;

    /**
     * 通过素材管理接口上传多媒体文件，得到的id
     * @return string
     */
    public function getMediaId()
    {
        return $this->mediaId;
    }

    /**
     * 通过素材管理接口上传多媒体文件，得到的id
     * @param string $mediaId
     */
    public function setMediaId($mediaId)
    {
        $this->mediaId = $mediaId;
    }

    /**
     * to array
     *
     * @return array
     */
    public function toArray()
    {
        $result             = parent::toArray();
        $result['mediaId']  = $this->mediaId;

        return $result;
    }
}
