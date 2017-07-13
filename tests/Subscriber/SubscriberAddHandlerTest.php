<?php
/**
 * File: SubscriberAddHandlerTest.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\FreshMail\Test\Subscriber;

use MSlwk\FreshMail\Handler\Subscriber\SubscriberAddHandler;
use MSlwk\FreshMail\Tests\BaseTest;
use PHPUnit\Framework\TestCase;
use MSlwk\FreshMail\Error\ErrorHandler;
use MSlwk\FreshMail\Exception\Subscriber\FreshMailSubscriberException;

/**
 * Class SubscriberAddHandlerTest
 *
 * @package MSlwk\FreshMail\Test\Subscriber
 */
class SubscriberAddHandlerTest extends TestCase
{
    use BaseTest;

    /**
     * @param $sendRequestReturnValue
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    public function getSubscriberAddHandlerMock($sendRequestReturnValue)
    {
        $subscriberAddHandler = $this->getMockBuilder('\MSlwk\FreshMail\Handler\Subscriber\SubscriberAddHandler')
            ->setConstructorArgs([new ErrorHandler(), '', ''])
            ->setMethods(['sendRequest'])
            ->getMock();

        $subscriberAddHandler->expects($this->once())
            ->method('sendRequest')
            ->will($this->returnValue($sendRequestReturnValue));

        return $subscriberAddHandler;
    }

    public function testSubscriberAddedSuccessfully()
    {
        $subscriberAddHandler = $this->getSubscriberAddHandlerMock('{"status":"OK"}');
        self::assertNull($subscriberAddHandler->addSubscriber('Test', 'Test'));
    }

    public function testApiEndpoint()
    {
        $subscriberAddHandler = new SubscriberAddHandler(new ErrorHandler(), '', '');
        $expectedApiEndpoint = '/rest/subscriber/add';
        $returnedApiEndpoint = $this->getApiEndpoint($subscriberAddHandler);
        self::assertEquals($expectedApiEndpoint, $returnedApiEndpoint);
    }

    public function testIncorrectEmail()
    {
        $subscriberAddHandler = $this->getSubscriberAddHandlerMock(
            '{"errors":[{ "message":"Incorrect email", "code":"1301" }], "status":"errors"}'
        );
        $this->expectException(FreshMailSubscriberException::class);
        $subscriberAddHandler->addSubscriber('Test', 'Test');
    }

    public function testListDoesntExist()
    {
        $subscriberAddHandler = $this->getSubscriberAddHandlerMock(
            '{"errors":[{ "message":"The subscription list doesnt exist", "code":"1302" }], "status":"errors"}'
        );
        $this->expectException(FreshMailSubscriberException::class);
        $subscriberAddHandler->addSubscriber('Test', 'Test');
    }

    public function testCustomFieldsIncorrect()
    {
        $subscriberAddHandler = $this->getSubscriberAddHandlerMock(
            '{"errors":[{ "message":"At least one custom field is incorrect", "code":"1303" }], "status":"errors"}'
        );
        $this->expectException(FreshMailSubscriberException::class);
        $subscriberAddHandler->addSubscriber('Test', 'Test');
    }

    public function testSubscriberAlreadyExists()
    {
        $subscriberAddHandler = $this->getSubscriberAddHandlerMock(
            '{"errors":[{ "message":"Subscriber already exists", "code":"1304" }], "status":"errors"}'
        );
        $this->expectException(FreshMailSubscriberException::class);
        $subscriberAddHandler->addSubscriber('Test', 'Test');
    }

    public function testIncorrectStatus()
    {
        $subscriberAddHandler = $this->getSubscriberAddHandlerMock(
            '{"errors":[{ "message":"You tried to assign an incorrect status", "code":"1305" }], "status":"errors"}'
        );
        $this->expectException(FreshMailSubscriberException::class);
        $subscriberAddHandler->addSubscriber('Test', 'Test');
    }
}
