<?php
/**
 * File: CampaignEditHandlerTest.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\FreshMail\Test\Campaign;

use MSlwk\FreshMail\Handler\Campaign\CampaignEditHandler;
use MSlwk\FreshMail\Tests\BaseTest;
use PHPUnit\Framework\TestCase;
use MSlwk\FreshMail\Error\ErrorHandler;
use MSlwk\FreshMail\Exception\Campaign\FreshMailCampaignException;

/**
 * Class EditCampaignHandlerTest
 *
 * @package MSlwk\FreshMail\Test\Campaign
 */
class CampaignEditHandlerTest extends TestCase
{
    use BaseTest;

    /**
     * @param $sendRequestReturnValue
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    public function getCampaignDeleteHandlerMock($sendRequestReturnValue)
    {
        $campaignEditHandler = $this->getMockBuilder('\MSlwk\FreshMail\Handler\Campaign\CampaignEditHandler')
            ->setConstructorArgs([new ErrorHandler(), '', ''])
            ->setMethods(['sendRequest'])
            ->getMock();

        $campaignEditHandler->expects($this->once())
            ->method('sendRequest')
            ->will($this->returnValue($sendRequestReturnValue));

        return $campaignEditHandler;
    }

    public function testCampaignEditSuccessful()
    {
        $campaignEditHandler = $this->getCampaignDeleteHandlerMock('{"status":"OK"}');
        $returnValue = $campaignEditHandler->editCampaign(
            'id_hash',
            'campaign_name'
        );
        self::assertNull($returnValue);
    }

    public function testApiEndpoint()
    {
        $accountCreateHandler = new CampaignEditHandler(new ErrorHandler(), '', '');
        $expectedApiEndpoint = '/rest/campaigns/edit';
        $returnedApiEndpoint = $this->getApiEndpoint($accountCreateHandler);
        self::assertEquals($expectedApiEndpoint, $returnedApiEndpoint);
    }

    public function testCampaignDoesntExist()
    {
        $campaignEditHandler = $this->getCampaignDeleteHandlerMock(
            '{"errors":[{ "message":"Requested campaign doesnt exist", "code":"1750" }], "status":"errors"}'
        );
        $this->expectException(FreshMailCampaignException::class);
        $campaignEditHandler->editCampaign('id_hash', 'Test');
    }

    public function testModificationNotAvailable()
    {
        $campaignEditHandler = $this->getCampaignDeleteHandlerMock(
            '{"errors":[{ "message":"Campaign ready to send, modification not available", "code":"1751" }]'
            . ', "status":"errors"}'
        );
        $this->expectException(FreshMailCampaignException::class);
        $campaignEditHandler->editCampaign('id_hash', 'Test');
    }
}
