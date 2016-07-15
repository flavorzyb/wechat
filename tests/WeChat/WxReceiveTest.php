<?php
namespace WeChat;

abstract class WxReceiveTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @return WxReceive
     */
    abstract protected function getReceiveMsg();

    abstract public function testToArrayReturnArray();

    protected function getModel() {
        return $this->getReceiveMsg();
    }

    protected function initMsg(WxReceive $msg)
    {
        $data = [   'toUserName'    => 'toUserName',
            'fromUserName'  => 'fromUserName',
            'createTime'    => date('Y-m-d H:i:s'),
            'id'            => mt_rand(),
        ];

        $msg->setToUserName($data['toUserName']);
        $msg->setFromUserName($data['fromUserName']);
        $msg->setCreateTime($data['createTime']);
        $msg->setId($data['id']);

        return $data;
    }

    public function testIdIsMutable()
    {
        $id = mt_rand();
        $this->getReceiveMsg()->setId($id);
        self::assertEquals($id, $this->getReceiveMsg()->getId());
    }

    public function testUserNameIsMutable()
    {
        $this->getReceiveMsg()->setToUserName("test user name");
        $this->assertEquals("test user name", $this->getReceiveMsg()->getToUserName());

        $this->getReceiveMsg()->setFromUserName("test user name");
        $this->assertEquals("test user name", $this->getReceiveMsg()->getFromUserName());
    }

    public function testCreateTimeIsMutable()
    {
        $time = date('Y-m-d H:i:s');
        $this->getReceiveMsg()->setCreateTime($time);
        $this->assertEquals($time, $this->getReceiveMsg()->getCreateTime());
    }

    public function testMsgType()
    {
        $this->assertNotNull($this->getReceiveMsg()->getMsgType());
    }
}
