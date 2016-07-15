<?php
namespace WeChat\Message;


abstract class WxSendMsgTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @return WxSendMsg
     */
    abstract protected function getSendMsg();

    abstract public function testToArrayReturnArray();

    /**
     * init msg
     * @param WxSendMsg $msg
     * @return array
     */
    protected function initMsg(WxSendMsg $msg)
    {
        $data = [   'toUserName'    => 'toUserName',
                    'fromUserName'  => 'fromUserName',
                    'createTime'    => time(),
        ];

        $msg->setToUserName($data['toUserName']);
        $msg->setFromUserName($data['fromUserName']);
        $msg->setCreateTime($data['createTime']);

        return $data;
    }

    public function testUserNameIsMutable()
    {
        $this->getSendMsg()->setToUserName("test user name");
        $this->assertEquals("test user name", $this->getSendMsg()->getToUserName());

        $this->getSendMsg()->setFromUserName("test user name");
        $this->assertEquals("test user name", $this->getSendMsg()->getFromUserName());
    }

    public function testCreateTimeIsMutable()
    {
        $time = time();
        $this->getSendMsg()->setCreateTime($time);
        $this->assertEquals($time, $this->getSendMsg()->getCreateTime());
    }

    public function testMsgType()
    {
        $this->assertNotNull($this->getSendMsg()->getMsgType());
    }
}
