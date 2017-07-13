<?php
/**
 * File: ListEditHandlerTest.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\FreshMail\Test\Lists;

use MSlwk\FreshMail\Handler\Lists\ListEditHandler;
use MSlwk\FreshMail\Tests\BaseTest;
use PHPUnit\Framework\TestCase;
use MSlwk\FreshMail\Error\ErrorHandler;
use MSlwk\FreshMail\Exception\Lists\FreshMailListException;

class ListEditHandlerTest extends TestCase
{
    use BaseTest;

    /**
     * @param $sendRequestReturnValue
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    public function getListEditHandlerMock($sendRequestReturnValue)
    {
        $listEditHandler = $this->getMockBuilder('\MSlwk\FreshMail\Handler\Lists\ListEditHandler')
            ->setConstructorArgs([new ErrorHandler(), '', ''])
            ->setMethods(['sendRequest'])
            ->getMock();

        $listEditHandler->expects($this->once())
            ->method('sendRequest')
            ->will($this->returnValue($sendRequestReturnValue));

        return $listEditHandler;
    }

    public function testListEditSuccessfully()
    {
        $listEditHandler = $this->getListEditHandlerMock(
            '{"status":"OK"}'
        );
        self::assertNull($listEditHandler->updateSubscriberList('Test', 'Test'));
    }

    public function testApiEndpoint()
    {
        $listCreateHandler = new ListEditHandler(new ErrorHandler(), '', '');
        $expectedApiEndpoint = '/rest/subscribers_list/update';
        $returnedApiEndpoint = $this->getApiEndpoint($listCreateHandler);
        self::assertEquals($expectedApiEndpoint, $returnedApiEndpoint);
    }

    public function testEmptyName()
    {
        $listEditHandler = $this->getListEditHandlerMock(
            '{"errors":[{"message":"Empty list name","code":"1611"}],"status":"errors"}'
        );
        $this->expectException(FreshMailListException::class);
        $listEditHandler->updateSubscriberList('Test', 'Test');
    }

    public function testAccessDenied()
    {
        $listEditHandler = $this->getListEditHandlerMock(
            '{"errors":[{"message":"Access to the list denied","code":"1604"}],"status":"errors"}'
        );
        $this->expectException(FreshMailListException::class);
        $listEditHandler->updateSubscriberList('Test', 'Test');
    }
}
