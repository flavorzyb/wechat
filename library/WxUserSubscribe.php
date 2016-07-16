<?php
namespace WeChat;

/**
 * 用户是否订阅该公众号标识，值为0时，代表此用户没有关注该公众号，拉取不到其余信息
 * Class WxUserSubScribe
 * @package WeChat
 */
class WxUserSubscribe
{
    /**
     * 已订阅公众号
     */
    const SUBSCRIBE = 1;
    /**
     * 取消订阅公众号
     */
    const UNSUBSCRIBE = 0;

    /**
     * 订阅状态值
     * @var int
     */
    protected $value = self::SUBSCRIBE;

    /**
     * WxUserSubScribe constructor.
     * @param $value
     */
    public function __construct($value)
    {
        $this->setValue($value);
    }

    /**
     * 获得订阅状态值
     * @return int
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * 设置状态值
     * @param int $value
     */
    protected function setValue($value)
    {
        if ($value === self::UNSUBSCRIBE)
        {
            $this->value = self::UNSUBSCRIBE;
        } else {
            $this->value = self::SUBSCRIBE;
        }
    }

    /**
     * 是否订阅该公众号
     * @return bool
     */
    public function isSubscribe()
    {
        return self::SUBSCRIBE == $this->value;
    }
}
