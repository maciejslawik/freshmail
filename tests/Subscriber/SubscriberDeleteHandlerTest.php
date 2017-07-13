<?php
/**
 * File: SubscriberDeleteHandlerTest.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\FreshMail\Test\Subscriber;

use MSlwk\FreshMail\Handler\Subscriber\SubscriberDeleteHandler;
use MSlwk\FreshMail\Tests\BaseTest;
use PHPUnit\Framework\TestCase;
use MSlwk\FreshMail\Error\ErrorHandler;
use MSlwk\FreshMail\Exception\Subscriber\FreshMailSubscriberException;

/**
 * Class SubscriberDeleteHandlerTest
 *
 * @package MSlwk\FreshMail\Test\Subscriber
 */
class SubscriberDeleteHandlerTest extends TestCase
{
    use BaseTest;

    /**
     * @param $sendRequestReturnValue
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    public function getSubscriberDeleteHandlerMock($sendRequestReturnValue)
    {
        $subscriberDeleteHandler = $this->getMockBuilder('\MSlwk\FreshMail\Handler\Subscriber\SubscriberDeleteHandler')
            ->setConstructorArgs([new ErrorHandler(), '', ''])
            ->setMethods(['sendRequest'])
            ->getMock();

        $subscriberDeleteHandler->expects($this->once())
            ->method('sendRequest')
            ->will($this->returnValue($sendRequestReturnValue));

        return $subscriberDeleteHandler;
    }

    public function testSubscriberPulledSuccessfully()
    {
        $subscriberDeleteHandler = $this->getSubscriberDeleteHandlerMock('{"status":"OK"}');
        self::assertNull($subscriberDeleteHandler->deleteSubscriber('Test', 'Test'));
    }

    public function testApiEndpoint()
    {
        $subscriberDeleteHandler = new SubscriberDeleteHandler(new ErrorHandler(), '', '');
        $expectedApiEndpoint = '/rest/subscriber/delete';
        $returnedApiEndpoint = $this->getApiEndpoint($subscriberDeleteHandler);
        self::assertEquals($expectedApiEndpoint, $returnedApiEndpoint);
    }

    public function testIncorrectEmail()
    {
        $subscriberDeleteHandler = $this->getSubscriberDeleteHandlerMock(
            '{"errors":[{ "message":"Incorrect email", "code":"1321" }], "status":"errors"}'
        );
        $this->expectException(FreshMailSubscriberException::class);
        $subscriberDeleteHandler->deleteSubscriber('Test', 'Test');
    }

    public function testListDoesntExist()
    {
        $subscriberDeleteHandler = $this->getSubscriberDeleteHandlerMock(
            '{"errors":[{ "message":"The subscription list doesnt exist", "code":"1322" }], "status":"errors"}'
        );
        $this->expectException(FreshMailSubscriberException::class);
        $subscriberDeleteHandler->deleteSubscriber('Test', 'Test');
    }
}
