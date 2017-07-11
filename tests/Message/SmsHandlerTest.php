<?php
/**
 * File: SmsHandlerTest.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\FreshMail\Test\Message;

use PHPUnit\Framework\TestCase;
use MSlwk\FreshMail\Error\ErrorHandler;
use MSlwk\FreshMail\Exception\Message\FreshMailSmsException;

/**
 * Class SmsHandlerTest
 *
 * @package MSlwk\FreshMail\Test\Message
 */
class SmsHandlerTest extends TestCase
{
    /**
     * @param $sendRequestReturnValue
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    public function getSmsHandlerMock($sendRequestReturnValue)
    {
        $smsHandler = $this->getMockBuilder('\MSlwk\FreshMail\Handler\Message\SmsHandler')
            ->setConstructorArgs([new ErrorHandler(), '', ''])
            ->setMethods(['sendRequest'])
            ->getMock();

        $smsHandler->expects($this->once())
            ->method('sendRequest')
            ->will($this->returnValue($sendRequestReturnValue));

        return $smsHandler;
    }

    public function testSmsSuccessfullySent()
    {
        $smsHandler = $this->getSmsHandlerMock('{"status":"OK"}');
        $returnValue = $smsHandler->sendSingleSms(
            '+48987654321',
            'Test',
            'Test',
            'Test',
            false
        );
        self::assertNull($returnValue);
    }

    public function testIncorrectNumber()
    {
        $smsHandler = $this->getSmsHandlerMock(
            '{"errors":[{ "message":"Incorrect GSM number", "code":"1101" }], "status":"errors"}'
        );
        $this->expectException(FreshMailSmsException::class);
        $smsHandler->sendSingleSms('+48987654321', 'Test');
    }

    public function testEmptyContent()
    {
        $smsHandler = $this->getSmsHandlerMock(
            '{"errors":[{ "message":"Empty SMS content", "code":"1102" }], "status":"errors"}'
        );
        $this->expectException(FreshMailSmsException::class);
        $smsHandler->sendSingleSms('+48987654321', 'Test');
    }

    public function testContentTooLong()
    {
        $smsHandler = $this->getSmsHandlerMock(
            '{"errors":[{ "message":"SMS content too long", "code":"1103" }], "status":"errors"}'
        );
        $this->expectException(FreshMailSmsException::class);
        $smsHandler->sendSingleSms('+48987654321', 'Test');
    }

    public function testContentTooLongWithSpecialChars()
    {
        $smsHandler = $this->getSmsHandlerMock(
            '{"errors":[{ "message":"SMS content too long", "code":"1104" }], "status":"errors"}'
        );
        $this->expectException(FreshMailSmsException::class);
        $smsHandler->sendSingleSms('+48987654321', 'Test');
    }

    public function testIncorrectSender()
    {
        $smsHandler = $this->getSmsHandlerMock(
            '{"errors":[{ "message":"Incorrect sender", "code":"1105" }], "status":"errors"}'
        );
        $this->expectException(FreshMailSmsException::class);
        $smsHandler->sendSingleSms('+48987654321', 'Test');
    }

    public function testSenderNotVerified()
    {
        $smsHandler = $this->getSmsHandlerMock(
            '{"errors":[{ "message":"SMS sender not verified", "code":"1106" }], "status":"errors"}'
        );
        $this->expectException(FreshMailSmsException::class);
        $smsHandler->sendSingleSms('+48987654321', 'Test');
    }

    public function testIncorrectEncoding()
    {
        $smsHandler = $this->getSmsHandlerMock(
            '{"errors":[{ "message":"Incorrect encoding", "code":"1107" }], "status":"errors"}'
        );
        $this->expectException(FreshMailSmsException::class);
        $smsHandler->sendSingleSms('+48987654321', 'Test');
    }

    public function testSingleSmsTooLong()
    {
        $smsHandler = $this->getSmsHandlerMock(
            '{"errors":[{ "message":"Content too long for forced single message", "code":"1108" }], "status":"errors"}'
        );
        $this->expectException(FreshMailSmsException::class);
        $smsHandler->sendSingleSms('+48987654321', 'Test');
    }

    public function testSingleSmsToLongWithSpecialChars()
    {
        $smsHandler = $this->getSmsHandlerMock(
            '{"errors":[{ "message":"Content too long for forced single message", "code":"1109" }], "status":"errors"}'
        );
        $this->expectException(FreshMailSmsException::class);
        $smsHandler->sendSingleSms('+48987654321', 'Test');
    }

    public function testContractNotSigned()
    {
        $smsHandler = $this->getSmsHandlerMock(
            '{"errors":[{ "message":"You must sign a contract to send SMS", "code":"1150" }], "status":"errors"}'
        );
        $this->expectException(FreshMailSmsException::class);
        $smsHandler->sendSingleSms('+48987654321', 'Test');
    }

}
