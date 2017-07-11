<?php
/**
 * File: CampaignCreateHandlerTest.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\FreshMail\Test\Campaign;

use PHPUnit\Framework\TestCase;
use MSlwk\FreshMail\Error\ErrorHandler;
use MSlwk\FreshMail\Exception\Campaign\FreshMailCampaignException;

/**
 * Class CampaignCreateHandlerTest
 *
 * @package MSlwk\FreshMail\Test\Campaign
 */
class CampaignCreateHandlerTest extends TestCase
{
    /**
     * @param $sendRequestReturnValue
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    public function getCampaignCreateHandlerMock($sendRequestReturnValue)
    {
        $campaignCreateHandler = $this->getMockBuilder('\MSlwk\FreshMail\Handler\Campaign\CampaignCreateHandler')
            ->setConstructorArgs([new ErrorHandler(), '', ''])
            ->setMethods(['sendRequest'])
            ->getMock();

        $campaignCreateHandler->expects($this->once())
            ->method('sendRequest')
            ->will($this->returnValue($sendRequestReturnValue));

        return $campaignCreateHandler;
    }

    public function testCampaignCreatedSuccessfully()
    {
        $expectedHash = '412rfefewf';
        $campaignCreateHandler = $this->getCampaignCreateHandlerMock(
            '{"status":"OK", "data": {"hash":"' . $expectedHash . '"}}'
        );
        $returnedHash = $campaignCreateHandler->createCampaign('Test', '', 'Test');
        self::assertEquals($expectedHash, $returnedHash);
    }

    public function testEmptyCampaignName()
    {
        $campaignCreateHandler = $this->getCampaignCreateHandlerMock(
            '{"errors":[{ "message":"Campaign name empty", "code":"1701" }], "status":"errors"}'
        );
        $this->expectException(FreshMailCampaignException::class);
        $campaignCreateHandler->createCampaign('Test');
    }

    public function testEmptyCampaignContent()
    {
        $campaignCreateHandler = $this->getCampaignCreateHandlerMock(
            '{"errors":[{ "message":"Campaign content empty", "code":"1702" }], "status":"errors"}'
        );
        $this->expectException(FreshMailCampaignException::class);
        $campaignCreateHandler->createCampaign('Test');
    }

    public function testIncorrectUrl()
    {
        $campaignCreateHandler = $this->getCampaignCreateHandlerMock(
            '{"errors":[{ "message":"Incorrect URL", "code":"1703" }], "status":"errors"}'
        );
        $this->expectException(FreshMailCampaignException::class);
        $campaignCreateHandler->createCampaign('Test');
    }

    public function testNoClient()
    {
        $campaignCreateHandler = $this->getCampaignCreateHandlerMock(
            '{"errors":[{ "message":"No client (internal error)", "code":"1704" }], "status":"errors"}'
        );
        $this->expectException(FreshMailCampaignException::class);
        $campaignCreateHandler->createCampaign('Test');
    }

    public function testNoParameters()
    {
        $campaignCreateHandler = $this->getCampaignCreateHandlerMock(
            '{"errors":[{ "message":"No parameters (internal error)", "code":"1705" }], "status":"errors"}'
        );
        $this->expectException(FreshMailCampaignException::class);
        $campaignCreateHandler->createCampaign('Test');
    }

    public function testIncorrectFromAddress()
    {
        $campaignCreateHandler = $this->getCampaignCreateHandlerMock(
            '{"errors":[{ "message":"Incorrect from_address email", "code":"1706" }], "status":"errors"}'
        );
        $this->expectException(FreshMailCampaignException::class);
        $campaignCreateHandler->createCampaign('Test');
    }

    public function testIncorrectReplyTo()
    {
        $campaignCreateHandler = $this->getCampaignCreateHandlerMock(
            '{"errors":[{ "message":"Incorrect reply_to email", "code":"1707" }], "status":"errors"}'
        );
        $this->expectException(FreshMailCampaignException::class);
        $campaignCreateHandler->createCampaign('Test');
    }

    public function testMissingSubscribtionList()
    {
        $campaignCreateHandler = $this->getCampaignCreateHandlerMock(
            '{"errors":[{ "message":"Missing subscribtion list and group", "code":"1708" }], "status":"errors"}'
        );
        $this->expectException(FreshMailCampaignException::class);
        $campaignCreateHandler->createCampaign('Test');
    }

    public function testIncorrectListHash()
    {
        $campaignCreateHandler = $this->getCampaignCreateHandlerMock(
            '{"errors":[{ "message":"At least one list hash is incorrect", "code":"1709" }], "status":"errors"}'
        );
        $this->expectException(FreshMailCampaignException::class);
        $campaignCreateHandler->createCampaign('Test');
    }

    public function testIncorrectGroupHash()
    {
        $campaignCreateHandler = $this->getCampaignCreateHandlerMock(
            '{"errors":[{ "message":"At least one group hash is incorrect", "code":"1710" }], "status":"errors"}'
        );
        $this->expectException(FreshMailCampaignException::class);
        $campaignCreateHandler->createCampaign('Test');
    }

    public function testListNotFound()
    {
        $campaignCreateHandler = $this->getCampaignCreateHandlerMock(
            '{"errors":[{ "message":"Subscribion list not found", "code":"1711" }], "status":"errors"}'
        );
        $this->expectException(FreshMailCampaignException::class);
        $campaignCreateHandler->createCampaign('Test');
    }

    public function testGroupNotFound()
    {
        $campaignCreateHandler = $this->getCampaignCreateHandlerMock(
            '{"errors":[{ "message":"Subscription group not found", "code":"1712" }], "status":"errors"}'
        );
        $this->expectException(FreshMailCampaignException::class);
        $campaignCreateHandler->createCampaign('Test');
    }

    public function testIncorrectResignationUrl()
    {
        $campaignCreateHandler = $this->getCampaignCreateHandlerMock(
            '{"errors":[{ "message":"Resignation link must be a valid URL", "code":"1713" }], "status":"errors"}'
        );
        $this->expectException(FreshMailCampaignException::class);
        $campaignCreateHandler->createCampaign('Test');
    }


}
