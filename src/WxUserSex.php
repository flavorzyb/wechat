<?php
namespace WeChat;

class WxUserSex
{
    // 男性
    const MALE      = 1;
    // 女性
    const FEMALE    = 2;
    // 未知
    const UNKNOWN   = 0;

    protected $value = self::UNKNOWN;

    public function __construct($value)
    {
        $this->setValue($value);
    }

    /**
     * set sex
     * @param int $value
     */
    protected function setValue($value)
    {
        switch ($value) {
            case self::MALE:
            case self::FEMALE:
                $this->value = $value;
                break;
            default:
                $this->value = self::UNKNOWN;
        }
    }

    /**
     * get value of sex
     * @return int
     */
    public function getValue()
    {
        return $this->value;
    }
}
