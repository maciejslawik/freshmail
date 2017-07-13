<?php
/**
 * File: SubscriberEditHandlerTest.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\FreshMail\Test\Subscriber;

use MSlwk\FreshMail\Handler\Subscriber\SubscriberEditHandler;
use MSlwk\FreshMail\Tests\BaseTest;
use PHPUnit\Framework\TestCase;
use MSlwk\FreshMail\Error\ErrorHandler;
use MSlwk\FreshMail\Exception\Subscriber\FreshMailSubscriberException;

/**
 * Class SubscriberEditHandlerTest
 *
 * @package MSlwk\FreshMail\Test\Subscriber
 */
class SubscriberEditHandlerTest extends TestCase
{
    use BaseTest;

    /**
     * @param $sendRequestReturnValue
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    public function getSubscriberEditHandlerMock($sendRequestReturnValue)
    {
        $subscriberEditHandler = $this->getMockBuilder('\MSlwk\FreshMail\Handler\Subscriber\SubscriberEditHandler')
            ->setConstructorArgs([new ErrorHandler(), '', ''])
            ->setMethods(['sendRequest'])
            ->getMock();

        $subscriberEditHandler->expects($this->once())
            ->method('sendRequest')
            ->will($this->returnValue($sendRequestReturnValue));

        return $subscriberEditHandler;
    }

    public function testSubscriberEditedSuccessfully()
    {
        $subscriberEditHandler = $this->getSubscriberEditHandlerMock('{"status":"OK"}');
        self::assertNull($subscriberEditHandler->editSubscriber('Test', 'Test'));
    }

    public function testApiEndpoint()
    {
        $subscriberEditHandler = new SubscriberEditHandler(new ErrorHandler(), '', '');
        $expectedApiEndpoint = '/rest/subscriber/edit';
        $returnedApiEndpoint = $this->getApiEndpoint($subscriberEditHandler);
        self::assertEquals($expectedApiEndpoint, $returnedApiEndpoint);
    }

    public function testSubscriberDoesntExist()
    {
        $subscriberEditHandler = $this->getSubscriberEditHandlerMock(
            '{"errors":[{ "message":"The subscriber doesnt exist", "code":"1331" }], "status":"errors"}'
        );
        $this->expectException(FreshMailSubscriberException::class);
        $subscriberEditHandler->editSubscriber('Test', 'Test');
    }

    public function testIncorrectList()
    {
        $subscriberEditHandler = $this->getSubscriberEditHandlerMock(
            '{"errors":[{ "message":"The subscriber list doesnt exist", "code":"1302" }], "status":"errors"}'
        );
        $this->expectException(FreshMailSubscriberException::class);
        $subscriberEditHandler->editSubscriber('Test', 'Test');
    }

    public function testIncorrectStatus()
    {
        $subscriberEditHandler = $this->getSubscriberEditHandlerMock(
            '{"errors":[{ "message":"Incorrect subscriber status", "code":"1305" }], "status":"errors"}'
        );
        $this->expectException(FreshMailSubscriberException::class);
        $subscriberEditHandler->editSubscriber('Test', 'Test');
    }
}
