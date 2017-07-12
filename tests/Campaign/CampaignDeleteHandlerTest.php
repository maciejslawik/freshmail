<?php
/**
 * File: CampaignDeleteHandlerTest.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\FreshMail\Test\Campaign;

use MSlwk\FreshMail\Handler\Campaign\CampaignDeleteHandler;
use MSlwk\FreshMail\Tests\BaseTest;
use PHPUnit\Framework\TestCase;
use MSlwk\FreshMail\Error\ErrorHandler;
use MSlwk\FreshMail\Exception\Campaign\FreshMailCampaignException;

/**
 * Class CampaignDeleteHandlerTest
 *
 * @package MSlwk\FreshMail\Test\Campaign
 */
class CampaignDeleteHandlerTest extends TestCase
{
    use BaseTest;

    /**
     * @param $sendRequestReturnValue
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    public function getCampaignDeleteHandlerMock($sendRequestReturnValue)
    {
        $campaignDeleteHandler = $this->getMockBuilder('\MSlwk\FreshMail\Handler\Campaign\CampaignDeleteHandler')
            ->setConstructorArgs([new ErrorHandler(), '', ''])
            ->setMethods(['sendRequest'])
            ->getMock();

        $campaignDeleteHandler->expects($this->once())
            ->method('sendRequest')
            ->will($this->returnValue($sendRequestReturnValue));

        return $campaignDeleteHandler;
    }

    public function testCampaignDeleteSuccessful()
    {
        $campaignDeleteHandler = $this->getCampaignDeleteHandlerMock('{"status":"OK"}');
        $returnValue = $campaignDeleteHandler->deleteCampaign('id_hash');
        self::assertNull($returnValue);
    }

    public function testApiEndpoint()
    {
        $accountCreateHandler = new CampaignDeleteHandler(new ErrorHandler(), '', '');
        $expectedApiEndpoint = '/rest/campaigns/delete';
        $returnedApiEndpoint = $this->getApiEndpoint($accountCreateHandler);
        self::assertEquals($expectedApiEndpoint, $returnedApiEndpoint);
    }

    public function testCampaignDoesntExist()
    {
        $campaignDeleteHandler = $this->getCampaignDeleteHandlerMock(
            '{"errors":[{ "message":"Requested campaign doesnt exist", "code":"1724" }], "status":"errors"}'
        );
        $this->expectException(FreshMailCampaignException::class);
        $campaignDeleteHandler->deleteCampaign('id_hash');
    }

    public function testCampaignAlreadyDeleted()
    {
        $campaignDeleteHandler = $this->getCampaignDeleteHandlerMock(
            '{"errors":[{ "message":"Campaign cant be deleted", "code":"1798" }], "status":"errors"}'
        );
        $this->expectException(FreshMailCampaignException::class);
        $campaignDeleteHandler->deleteCampaign('id_hash');
    }
}
