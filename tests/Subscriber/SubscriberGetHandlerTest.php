<?php
/**
 * File: SubscriberGetHandlerTest.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\FreshMail\Test\Subscriber;

use MSlwk\FreshMail\Handler\Subscriber\SubscriberGetHandler;
use MSlwk\FreshMail\Tests\BaseTest;
use PHPUnit\Framework\TestCase;
use MSlwk\FreshMail\Error\ErrorHandler;
use MSlwk\FreshMail\Exception\Subscriber\FreshMailSubscriberException;

/**
 * Class SubscriberGetHandlerTest
 *
 * @package MSlwk\FreshMail\Test\Subscriber
 */
class SubscriberGetHandlerTest extends TestCase
{
    use BaseTest;

    /**
     * @param $sendRequestReturnValue
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    public function getSubscriberGetHandlerMock($sendRequestReturnValue)
    {
        $subscriberGetHandler = $this->getMockBuilder('\MSlwk\FreshMail\Handler\Subscriber\SubscriberGetHandler')
            ->setConstructorArgs([new ErrorHandler(), '', ''])
            ->setMethods(['sendRequest'])
            ->getMock();

        $subscriberGetHandler->expects($this->once())
            ->method('sendRequest')
            ->will($this->returnValue($sendRequestReturnValue));

        return $subscriberGetHandler;
    }

    public function testSubscriberPulledSuccessfully()
    {
        $expectedEmail = '15fewdg13f';
        $expectedState = 2;
        $expectedCustomFields = (object)['ssfas' => '4124rfd'];
        $expectedHash = 'gvrheg';
        $subscriberGetHandler = $this->getSubscriberGetHandlerMock(
            '{"status":"OK","data":{"email":"'
            . $expectedEmail . '","state":'
            . $expectedState . ',"custom_fields":'
            . json_encode($expectedCustomFields) . ',"id_hash":"'
            . $expectedHash . '"}}'
        );
        $returnedData = $subscriberGetHandler->getSubscriber('Test', 'Test');
        self::assertEquals($expectedEmail, $returnedData->email);
        self::assertEquals($expectedState, $returnedData->state);
        self::assertEquals($expectedCustomFields, $returnedData->custom_fields);
        self::assertEquals($expectedHash, $returnedData->id_hash);
    }

    public function testApiEndpoint()
    {
        $subscriberGetHandler = new SubscriberGetHandler(new ErrorHandler(), '', '');
        $expectedApiEndpoint = '/rest/subscriber/get';
        $returnedApiEndpoint = $this->getApiEndpoint($subscriberGetHandler);
        self::assertEquals($expectedApiEndpoint, $returnedApiEndpoint);
    }

    public function testIncorrectEmail()
    {
        $subscriberGetHandler = $this->getSubscriberGetHandlerMock(
            '{"errors":[{ "message":"Incorrect email", "code":"1311" }], "status":"errors"}'
        );
        $this->expectException(FreshMailSubscriberException::class);
        $subscriberGetHandler->getSubscriber('Test', 'Test');
    }

    public function testListDoesntExist()
    {
        $subscriberGetHandler = $this->getSubscriberGetHandlerMock(
            '{"errors":[{ "message":"The subscribtion list doesnt exist", "code":"1312" }], "status":"errors"}'
        );
        $this->expectException(FreshMailSubscriberException::class);
        $subscriberGetHandler->getSubscriber('Test', 'Test');
    }
}
