<?php
namespace WeChat;

/**
 *
参数             说明
subscribe       用户是否订阅该公众号标识，值为0时，代表此用户没有关注该公众号，拉取不到其余信息。
openid          用户的标识，对当前公众号唯一
nickname        用户的昵称
sex             用户的性别，值为1时是男性，值为2时是女性，值为0时是未知
city            用户所在城市
country         用户所在国家
province        用户所在省份
language        用户的语言，简体中文为zh_CN
headimgurl      用户头像，最后一个数值代表正方形头像大小（有0、46、64、96、132数值可选，0代表640*640正方形头像），
                用户没有头像时该项为空。若用户更换头像，原有头像URL将失效。
subscribe_time  用户关注时间，为时间戳。如果用户曾多次关注，则取最后关注时间
unionid         只有在用户将公众号绑定到微信开放平台帐号后，才会出现该字段。详见：获取用户个人信息（UnionID机制）
remark          公众号运营者对粉丝的备注，公众号运营者可在微信公众平台用户管理界面对粉丝添加备注
groupid         用户所在的分组ID
 *
 * Class WxUser
 * @package WeChat
 */
class WxUser
{
    /**
     * 用户的标识，对当前公众号唯一
     * @var string
     */
    protected $openId       = '';
    /**
     * 只有在用户将公众号绑定到微信开放平台帐号后，才会出现该字段。详见：获取用户个人信息（UnionID机制）
     *
     * @var string
     */
    protected $unionId      = '';

    /**
     * 用户的昵称
     * @var string
     */
    protected $nickName     = '';
    /**
     * 用户的性别，值为1时是男性，值为2时是女性，值为0时是未知
     * @var WxUserSex
     */
    protected $sex          = null;
    /**
     * 用户所在城市
     * @var string
     */
    protected $city         = '';
    /**
     * 用户所在国家
     * @var string
     */
    protected $province     = '';
    /**
     * 用户所在省份
     * @var string
     */
    protected $country      = '';
    /**
     * 用户头像，最后一个数值代表正方形头像大小（有0、46、64、96、132数值可选，0代表640*640正方形头像），
     * 用户没有头像时该项为空。若用户更换头像，原有头像URL将失效。
     * @var string
     */
    protected $headImgUrl   = '';

    /**
     * 用户是否订阅该公众号标识，值为0时，代表此用户没有关注该公众号，拉取不到其余信息。
     * @var WxUserSubScribe
     */
    protected $subscribe = null;

    /**
     * 用户关注时间，为时间戳。如果用户曾多次关注，则取最后关注时间
     * @var string
     */
    protected $subscribeTime = '0000-00-00 00:00:00';

    /**
     * 用户所在的分组ID
     * @var int
     */
    protected $groupId = 0;

    public function __construct()
    {
        $this->sex = new WxUserSex(WxUserSex::UNKNOWN);
        $this->subscribe = new WxUserSubscribe(WxUserSubscribe::UNSUBSCRIBE);
    }

    /**
     * 用户的标识，对当前公众号唯一
     * @return string
     */
    public function getOpenId()
    {
        return $this->openId;
    }

    /**
     * 用户的标识，对当前公众号唯一
     * @param string $openId
     */
    public function setOpenId($openId)
    {
        $this->openId = $openId;
    }

    /**
     * 微信唯一ID
     * @return string
     */
    public function getUnionId()
    {
        return $this->unionId;
    }

    /**
     * 微信唯一ID
     * @param string $unionId
     */
    public function setUnionId($unionId)
    {
        $this->unionId = $unionId;
    }

    /**
     * 用户的昵称
     * @return string
     */
    public function getNickName()
    {
        return $this->nickName;
    }

    /**
     * 用户的昵称
     * @param string $nickName
     */
    public function setNickName($nickName)
    {
        $this->nickName = $nickName;
    }

    /**
     * 用户的性别，值为1时是男性，值为2时是女性，值为0时是未知
     * @return WxUserSex
     */
    public function getSex()
    {
        return $this->sex;
    }

    /**
     * 用户的性别，值为1时是男性，值为2时是女性，值为0时是未知
     * @param WxUserSex $sex
     */
    public function setSex(WxUserSex $sex)
    {
        $this->sex = $sex;
    }

    /**
     * 用户所在城市
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * 用户所在城市
     * @param string $city
     */
    public function setCity($city)
    {
        $this->city = $city;
    }

    /**
     * 用户所在省份
     * @return string
     */
    public function getProvince()
    {
        return $this->province;
    }

    /**
     * 用户所在省份
     * @param string $province
     */
    public function setProvince($province)
    {
        $this->province = $province;
    }

    /**
     * 用户所在国家
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * 用户所在国家
     * @param string $country
     */
    public function setCountry($country)
    {
        $this->country = $country;
    }

    /**
     * 用户头像，最后一个数值代表正方形头像大小（有0、46、64、96、132数值可选，0代表640*640正方形头像），
     * 用户没有头像时该项为空。若用户更换头像，原有头像URL将失效。
     * @return string
     */
    public function getHeadImgUrl()
    {
        return $this->headImgUrl;
    }

    /**
     * 用户头像，最后一个数值代表正方形头像大小（有0、46、64、96、132数值可选，0代表640*640正方形头像），
     * 用户没有头像时该项为空。若用户更换头像，原有头像URL将失效。
     * @param string $headImgUrl
     */
    public function setHeadImgUrl($headImgUrl)
    {
        $this->headImgUrl = $headImgUrl;
    }

    /**
     * @return WxUserSubscribe
     */
    public function getSubscribe()
    {
        return $this->subscribe;
    }

    /**
     * @param WxUserSubscribe $subscribe
     */
    public function setSubscribe(WxUserSubscribe $subscribe)
    {
        $this->subscribe = $subscribe;
    }

    /**
     * @return string
     */
    public function getSubscribeTime()
    {
        return $this->subscribeTime;
    }

    /**
     * @param string $subscribeTime
     */
    public function setSubscribeTime($subscribeTime)
    {
        $this->subscribeTime = $subscribeTime;
    }

    /**
     * @return int
     */
    public function getGroupId()
    {
        return $this->groupId;
    }

    /**
     * @param int $groupId
     */
    public function setGroupId($groupId)
    {
        $this->groupId = $groupId;
    }

    /**
     * to array
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'openId'        => $this->openId,
            'unionId'       => $this->unionId,
            'nickName'      => $this->nickName,

            'sex'           => $this->sex->getValue(),
            'city'          => $this->city,
            'province'      => $this->province,
            'country'       => $this->country,
            'headImgUrl'    => $this->headImgUrl,

            'subscribe'     => $this->subscribe->getValue(),
            'subscribeTime' => $this->subscribeTime,
            'groupId'       => $this->groupId,
        ];
    }
}
