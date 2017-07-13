<?php
/**
 * File: ListsGetHandlerTest.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\FreshMail\Test\Lists;

use MSlwk\FreshMail\Handler\Lists\ListsGetHandler;
use MSlwk\FreshMail\Tests\BaseTest;
use PHPUnit\Framework\TestCase;
use MSlwk\FreshMail\Error\ErrorHandler;

/**
 * Class ListsGetHandlerTest
 *
 * @package MSlwk\FreshMail\Test\Lists
 */
class ListsGetHandlerTest extends TestCase
{
    use BaseTest;

    /**
     * @param $sendRequestReturnValue
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    public function getListsGetHandlerMock($sendRequestReturnValue)
    {
        $listsGetHandler = $this->getMockBuilder('\MSlwk\FreshMail\Handler\Lists\ListsGetHandler')
            ->setConstructorArgs([new ErrorHandler(), '', ''])
            ->setMethods(['sendRequest'])
            ->getMock();

        $listsGetHandler->expects($this->once())
            ->method('sendRequest')
            ->will($this->returnValue($sendRequestReturnValue));

        return $listsGetHandler;
    }

    public function testListsPulledSuccessfully()
    {
        $expectedListsPulled = [
            (object) [
                'hash' => '4124521421',
                'name' => 'h4htrbg',
                'description' => '145r3fgrvfe',
                'creation_date' => '41253525teegf',
                'subscribers_number' => 2
            ],
            (object) [
                'hash' => 'vsdv',
                'name' => 'cbcsxb',
                'description' => 'czvczv',
                'creation_date' => 'byr6j5',
                'subscribers_number' => 5
            ],
        ];
        $listsGetHandler = $this->getListsGetHandlerMock(
            '{"status":"OK","lists":' . json_encode($expectedListsPulled) . '}'
        );
        $returnedData = $listsGetHandler->getSubscriberLists();
        self::assertEquals($expectedListsPulled, $returnedData);
    }

    public function testApiEndpoint()
    {
        $listCreateHandler = new ListsGetHandler(new ErrorHandler(), '', '');
        $expectedApiEndpoint = '/rest/subscribers_list/lists';
        $returnedApiEndpoint = $this->getApiEndpoint($listCreateHandler);
        self::assertEquals($expectedApiEndpoint, $returnedApiEndpoint);
    }
}
