<?php
/**
 * File: CampaignSendHandlerTest.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\FreshMail\Test\Campaign;

use PHPUnit\Framework\TestCase;
use MSlwk\FreshMail\Error\ErrorHandler;
use MSlwk\FreshMail\Exception\Campaign\FreshMailCampaignException;

/**
 * Class CampaignSendHandlerTest
 *
 * @package MSlwk\FreshMail\Test\Campaign
 */
class CampaignSendHandlerTest extends TestCase
{
    /**
     * @param $sendRequestReturnValue
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    public function getCampaignSendHandlerMock($sendRequestReturnValue)
    {
        $campaignSendHandler = $this->getMockBuilder('\MSlwk\FreshMail\Handler\Campaign\CampaignSendHandler')
            ->setConstructorArgs([new ErrorHandler(), '', ''])
            ->setMethods(['sendRequest'])
            ->getMock();

        $campaignSendHandler->expects($this->once())
            ->method('sendRequest')
            ->will($this->returnValue($sendRequestReturnValue));

        return $campaignSendHandler;
    }

    public function testCampaignSuccessfullySent()
    {
        $campaignSendHandler = $this->getCampaignSendHandlerMock('{"status":"OK"}');
        $returnValue = $campaignSendHandler->sendCampaign('id_hash');
        self::assertNull($returnValue);
    }

    public function testIncorrectCampaignHash()
    {
        $campaignSendHandler = $this->getCampaignSendHandlerMock(
            '{"errors":[{ "message":"Incorrect campaign hash", "code":"1731" }], "status":"errors"}'
        );
        $this->expectException(FreshMailCampaignException::class);
        $campaignSendHandler->sendCampaign('id_hash');
    }

    public function testIncorrectSendDate()
    {
        $campaignSendHandler = $this->getCampaignSendHandlerMock(
            '{"errors":[{ "message":"Incorrect sending time", "code":"1732" }], "status":"errors"}'
        );
        $this->expectException(FreshMailCampaignException::class);
        $campaignSendHandler->sendCampaign('id_hash');
    }

    public function testSendDateIsPast()
    {
        $campaignSendHandler = $this->getCampaignSendHandlerMock(
            '{"errors":[{ "message":"Sending time is in the past", "code":"1733" }], "status":"errors"}'
        );
        $this->expectException(FreshMailCampaignException::class);
        $campaignSendHandler->sendCampaign('id_hash');
    }

    public function testCampaignDoesntExist()
    {
        $campaignSendHandler = $this->getCampaignSendHandlerMock(
            '{"errors":[{ "message":"Requested campaign doesnt exist", "code":"1734" }], "status":"errors"}'
        );
        $this->expectException(FreshMailCampaignException::class);
        $campaignSendHandler->sendCampaign('id_hash');
    }

    public function testCampaignNotReadyToSend()
    {
        $campaignSendHandler = $this->getCampaignSendHandlerMock(
            '{"errors":[{ "message":"Campaign not ready to send", "code":"1735" }], "status":"errors"}'
        );
        $this->expectException(FreshMailCampaignException::class);
        $campaignSendHandler->sendCampaign('id_hash');
    }

    public function testCampaignAleadySending()
    {
        $campaignSendHandler = $this->getCampaignSendHandlerMock(
            '{"errors":[{ "message":"The campaign is already set to send", "code":"1736" }], "status":"errors"}'
        );
        $this->expectException(FreshMailCampaignException::class);
        $campaignSendHandler->sendCampaign('id_hash');
    }
}
