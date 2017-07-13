<?php
/**
 * File: ListDeleteHandlerTest.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\FreshMail\Test\Lists;

use MSlwk\FreshMail\Handler\Lists\ListDeleteHandler;
use MSlwk\FreshMail\Tests\BaseTest;
use PHPUnit\Framework\TestCase;
use MSlwk\FreshMail\Error\ErrorHandler;
use MSlwk\FreshMail\Exception\Lists\FreshMailListException;

/**
 * Class ListDeleteHandlerTest
 *
 * @package MSlwk\FreshMail\Test\Lists
 */
class ListDeleteHandlerTest extends TestCase
{
    use BaseTest;

    /**
     * @param $sendRequestReturnValue
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    public function getListDeleteHandlerMock($sendRequestReturnValue)
    {
        $listDeleteHandler = $this->getMockBuilder('\MSlwk\FreshMail\Handler\Lists\ListDeleteHandler')
            ->setConstructorArgs([new ErrorHandler(), '', ''])
            ->setMethods(['sendRequest'])
            ->getMock();

        $listDeleteHandler->expects($this->once())
            ->method('sendRequest')
            ->will($this->returnValue($sendRequestReturnValue));

        return $listDeleteHandler;
    }

    public function testListDeletedSuccessfully()
    {
        $listDeleteHandler = $this->getListDeleteHandlerMock(
            '{"status":"OK"}'
        );
        self::assertNull($listDeleteHandler->deleteSubscriberList('Test'));
    }

    public function testApiEndpoint()
    {
        $listDeleteHandler = new ListDeleteHandler(new ErrorHandler(), '', '');
        $expectedApiEndpoint = '/rest/subscribers_list/delete';
        $returnedApiEndpoint = $this->getApiEndpoint($listDeleteHandler);
        self::assertEquals($expectedApiEndpoint, $returnedApiEndpoint);
    }

    public function testListDeleteFailed()
    {
        $listDeleteHandler = $this->getListDeleteHandlerMock(
            '{"errors":[{"message":"The lists couldnt be deleted","code":"1605"}],"status":"errors"}'
        );
        $this->expectException(FreshMailListException::class);
        $listDeleteHandler->deleteSubscriberList('Test');
    }

    public function testAccessDenied()
    {
        $listDeleteHandler = $this->getListDeleteHandlerMock(
            '{"errors":[{"message":"Access to the list denied","code":"1604"}],"status":"errors"}'
        );
        $this->expectException(FreshMailListException::class);
        $listDeleteHandler->deleteSubscriberList('Test');
    }
}
