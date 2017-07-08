<?php
/**
 * File: AuthorizationTest.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\FreshMail\Test\Base;

use MSlwk\FreshMail\Exception\Authorization\FreshMailAuthorizationException;
use MSlwk\FreshMail\Exception\Connection\FreshMailConnectionException;
use PHPUnit\Framework\TestCase;
use MSlwk\FreshMail\Error\ErrorHandler;

/**
 * Class AuthorizationTest
 *
 * @package MSlwk\FreshMail\Test\Base
 */
class AuthorizationTest extends TestCase
{
    /**
     * @param $sendRequestReturnValue
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    private function getPingHandlerMock($sendRequestReturnValue)
    {
        $pingHandler = $this->getMockBuilder('\MSlwk\FreshMail\Handler\Ping\PingHandler')
            ->setConstructorArgs([new ErrorHandler(), '', ''])
            ->setMethods(['sendRequest'])
            ->getMock();

        $pingHandler->expects($this->once())
            ->method('sendRequest')
            ->with('', '')
            ->will($this->returnValue($sendRequestReturnValue));

        return $pingHandler;
    }

    public function testNoAuthorization()
    {
        $pingHandler = $this->getPingHandlerMock(
            '{"errors":[{ "message":"No authorization", "code":"1000" }], "status":"errors"}'
        );
        $this->expectException(FreshMailAuthorizationException::class);
        $pingHandler->ping();
    }

    public function testActionNotFound()
    {
        $pingHandler = $this->getPingHandlerMock(
            '{"errors":[{ "message":"Method not found", "code":"1001" }], "status":"errors"}'
        );
        $this->expectException(FreshMailAuthorizationException::class);
        $pingHandler->ping();
    }

    public function testUnsupportedProtocol()
    {
        $pingHandler = $this->getPingHandlerMock(
            '{"errors":[{ "message":"Protocol not supported", "code":"1002" }], "status":"errors"}'
        );
        $this->expectException(FreshMailAuthorizationException::class);
        $pingHandler->ping();
    }

    public function testUnsupportedHttpMethod()
    {
        $pingHandler = $this->getPingHandlerMock(
            '{"errors":[{ "message":"Unsupported request type", "code":"1003" }], "status":"errors"}'
        );
        $this->expectException(FreshMailAuthorizationException::class);
        $pingHandler->ping();
    }

    public function testAccessDenied()
    {
        $pingHandler = $this->getPingHandlerMock(
            '{"errors":[{ "message":"Access denied", "code":"1004" }], "status":"errors"}'
        );
        $this->expectException(FreshMailAuthorizationException::class);
        $pingHandler->ping();
    }

    public function testApiFailedToRespond()
    {
        $pingHandler = $this->getPingHandlerMock('');
        $this->expectException(FreshMailConnectionException::class);
        $pingHandler->ping();
    }
}
