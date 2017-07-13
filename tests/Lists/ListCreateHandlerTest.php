<?php
/**
 * File: ListCreateHandlerTest.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\FreshMail\Test\Lists;

use MSlwk\FreshMail\Handler\Lists\ListCreateHandler;
use MSlwk\FreshMail\Tests\BaseTest;
use PHPUnit\Framework\TestCase;
use MSlwk\FreshMail\Error\ErrorHandler;
use MSlwk\FreshMail\Exception\Lists\FreshMailListException;

/**
 * Class ListCreateHandlerTest
 *
 * @package MSlwk\FreshMail\Test\Lists
 */
class ListCreateHandlerTest extends TestCase
{
    use BaseTest;

    /**
     * @param $sendRequestReturnValue
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    public function getListCreateHandlerMock($sendRequestReturnValue)
    {
        $listCreateHandler = $this->getMockBuilder('\MSlwk\FreshMail\Handler\Lists\ListCreateHandler')
            ->setConstructorArgs([new ErrorHandler(), '', ''])
            ->setMethods(['sendRequest'])
            ->getMock();

        $listCreateHandler->expects($this->once())
            ->method('sendRequest')
            ->will($this->returnValue($sendRequestReturnValue));

        return $listCreateHandler;
    }

    public function testListCreatedSuccessfully()
    {
        $expectedCustomFields = (object)['ssfas' => '4124rfd'];
        $expectedHash = 'gvrheg';
        $listCreateHandler = $this->getListCreateHandlerMock(
            '{"status":"OK","hash":"'
            . $expectedHash . '","custom_fields":'
            . json_encode($expectedCustomFields) . '}'
        );
        $returnedData = $listCreateHandler->createSubscriberList('Test', 'Test');
        self::assertEquals($expectedCustomFields, $returnedData->custom_fields);
        self::assertEquals($expectedHash, $returnedData->hash);
    }

    public function testApiEndpoint()
    {
        $listCreateHandler = new ListCreateHandler(new ErrorHandler(), '', '');
        $expectedApiEndpoint = '/rest/subscribers_list/create';
        $returnedApiEndpoint = $this->getApiEndpoint($listCreateHandler);
        self::assertEquals($expectedApiEndpoint, $returnedApiEndpoint);
    }

    public function testEmptyName()
    {
        $listCreateHandler = $this->getListCreateHandlerMock(
            '{"errors":[{ "message":"Empty list name", "code":"1601" }], "status":"errors"}'
        );
        $this->expectException(FreshMailListException::class);
        $listCreateHandler->createSubscriberList('Test', 'Test');
    }

    public function testListCreationFailer()
    {
        $listCreateHandler = $this->getListCreateHandlerMock(
            '{"errors":[{ "message":"List couldnt be created", "code":"1602" }], "status":"errors"}'
        );
        $this->expectException(FreshMailListException::class);
        $listCreateHandler->createSubscriberList('Test', 'Test');
    }

    public function testIncorrectCustomFields()
    {
        $listCreateHandler = $this->getListCreateHandlerMock(
            '{"errors":[{ "message":"Custom fields incorrect", "code":"1603" }], "status":"errors"}'
        );
        $this->expectException(FreshMailListException::class);
        $listCreateHandler->createSubscriberList('Test', 'Test');
    }

    public function testIncorrectTag()
    {
        $listCreateHandler = $this->getListCreateHandlerMock(
            '{"errors":[{ "message":"Incorrect tag", "code":"1604" }], "status":"errors"}'
        );
        $this->expectException(FreshMailListException::class);
        $listCreateHandler->createSubscriberList('Test', 'Test');
    }

    public function testIncorrectFieldType()
    {
        $listCreateHandler = $this->getListCreateHandlerMock(
            '{"errors":[{ "message":"Incorrect field type", "code":"1605" }], "status":"errors"}'
        );
        $this->expectException(FreshMailListException::class);
        $listCreateHandler->createSubscriberList('Test', 'Test');
    }
}
