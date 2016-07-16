<?php
namespace WeChat;

class WxUserTest extends \PHPUnit_Framework_TestCase
{
    public function testWxUserOptionIsMutable()
    {
        /**
         * {
        "subscribe": 1,
        "openid": "o6_bmjrPTlm6_2sgVt7hMZOPfL2M",
        "nickname": "Band",
        "sex": 1,
        "language": "zh_CN",
        "city": "广州",
        "province": "广东",
        "country": "中国",
        "headimgurl":    "http://wx.qlogo.cn/mmopen/g3MonUZtNHkdmzicIlibx6iaFqAc56vxLSUfpb6n5WKSYVY0ChQKkiaJSgQ1dZuTOgvLLrhJbERQQ4eMsv84eavHiaiceqxibJxCfHe/0",
        "subscribe_time": 1382694957,
        "unionid": " o6_bmasdasdsad6_2sgVt7hMZOPfL"
        "remark": "",
        "groupid": 0
        }
         */
        $user = new WxUser();
        $user->setSubscribe(new WxUserSubscribe(1));
        $user->setOpenId("o6_bmjrPTlm6_2sgVt7hMZOPfL2M");
        $user->setNickName("Band");

        $user->setSex(new WxUserSex(1));
        $user->setCity("广州");
        $user->setProvince("广东");
        $user->setCountry("中国");

        $headUrl = "http://wx.qlogo.cn/mmopen/g3MonUZtNHkdmzicIlibx6iaFqAc56vxLSUfpb6n5WKSYVY0ChQKkiaJSgQ1dZuTOgvLLrhJbERQQ4eMsv84eavHiaiceqxibJxCfHe/0";
        $user->setHeadImgUrl($headUrl);
        $user->setSubscribeTime(date("Y-m-d H:i:s", 1382694957));
        $user->setUnionId("o6_bmasdasdsad6_2sgVt7hMZOPfL");
        $user->setGroupId(0);

        self::assertEquals(WxUserSubscribe::SUBSCRIBE, $user->getSubscribe()->getValue());
        self::assertEquals("o6_bmjrPTlm6_2sgVt7hMZOPfL2M", $user->getOpenId());
        self::assertEquals("Band", $user->getNickName());

        self::assertEquals(WxUserSex::MALE, $user->getSex()->getValue());
        self::assertEquals("广州", $user->getCity());
        self::assertEquals("广东", $user->getProvince());
        self::assertEquals("中国", $user->getCountry());

        self::assertEquals($headUrl, $user->getHeadImgUrl());
        self::assertEquals(date("Y-m-d H:i:s", 1382694957), $user->getSubscribeTime());
        self::assertEquals("o6_bmasdasdsad6_2sgVt7hMZOPfL", $user->getUnionId());
        self::assertEquals(0, $user->getGroupId());

        $data = [
            'openId'        => "o6_bmjrPTlm6_2sgVt7hMZOPfL2M",
            'unionId'       => "o6_bmasdasdsad6_2sgVt7hMZOPfL",
            'nickName'      => "Band",

            'sex'           => WxUserSex::MALE,
            'city'          => "广州",
            'province'      => "广东",
            'country'       => "中国",
            'headImgUrl'    => $headUrl,

            'subscribe'     => WxUserSubscribe::SUBSCRIBE,
            'subscribeTime' => date("Y-m-d H:i:s", 1382694957),
            'groupId'       => 0,
        ];

        self::assertEquals($data, $user->toArray());
    }
}
