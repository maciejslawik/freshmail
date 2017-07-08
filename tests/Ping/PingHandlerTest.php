<?php
/**
 * File: PingHandlerTest.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\FreshMail\Test\Ping;

use PHPUnit\Framework\TestCase;
use MSlwk\FreshMail\Error\ErrorHandler;

/**
 * Class PingTest
 *
 * @package MSlwk\FreshMail\Test\Ping
 */
class PingHandlerTest extends TestCase
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

    public function testReturnPong()
    {
        $pingHandler = $this->getPingHandlerMock('{"status":"OK", "data": "pong"}');
        self::assertEquals('pong', $pingHandler->ping());
    }
}
