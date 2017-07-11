<?php
/**
 * File: CampaignTestHandlerTest.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\FreshMail\Test\Campaign;

use PHPUnit\Framework\TestCase;
use MSlwk\FreshMail\Error\ErrorHandler;
use MSlwk\FreshMail\Exception\Campaign\FreshMailCampaignException;

class CampaignTestHandlerTest extends TestCase
{
    public function getCampaignTestHandlerMock($sendRequestReturnValue)
    {
        $campaignTestHandler = $this->getMockBuilder('\MSlwk\FreshMail\Handler\Campaign\CampaignTestHandler')
            ->setConstructorArgs([new ErrorHandler(), '', ''])
            ->setMethods(['sendRequest'])
            ->getMock();

        $campaignTestHandler->expects($this->once())
            ->method('sendRequest')
            ->will($this->returnValue($sendRequestReturnValue));

        return $campaignTestHandler;
    }

    public function testCampaignTestSuccessfullySent()
    {
        $campaignTestHandler = $this->getCampaignTestHandlerMock('{"status":"OK"}');
        $returnValue = $campaignTestHandler->testCampaign('id_hash', ['test@test.com']);
        self::assertNull($returnValue);
    }

    public function testIncorrectCampaignHash()
    {
        $campaignTestHandler = $this->getCampaignTestHandlerMock(
            '{"errors":[{ "message":"Incorrect campaign hash", "code":"1721" }], "status":"errors"}'
        );
        $this->expectException(FreshMailCampaignException::class);
        $campaignTestHandler->testCampaign('id_hash', ['test@test.com']);
    }

    public function testEmptyEmail()
    {
        $campaignTestHandler = $this->getCampaignTestHandlerMock(
            '{"errors":[{ "message":"Missing email address", "code":"1722" }], "status":"errors"}'
        );
        $this->expectException(FreshMailCampaignException::class);
        $campaignTestHandler->testCampaign('id_hash', ['test@test.com']);
    }

    public function testAtLeastOneEmailInvalid()
    {
        $campaignTestHandler = $this->getCampaignTestHandlerMock(
            '{"errors":[{ "message":"At least one email is invalid", "code":"1723" }], "status":"errors"}'
        );
        $this->expectException(FreshMailCampaignException::class);
        $campaignTestHandler->testCampaign('id_hash', ['test@test.com']);
    }

    public function testCampaignDoesntExist()
    {
        $campaignTestHandler = $this->getCampaignTestHandlerMock(
            '{"errors":[{ "message":"Requested campaign doesnt exist", "code":"1724" }], "status":"errors"}'
        );
        $this->expectException(FreshMailCampaignException::class);
        $campaignTestHandler->testCampaign('id_hash', ['test@test.com']);
    }

    public function testCampaignNotReadyToSend()
    {
        $campaignTestHandler = $this->getCampaignTestHandlerMock(
            '{"errors":[{ "message":"Campaign not ready to send", "code":"1725" }], "status":"errors"}'
        );
        $this->expectException(FreshMailCampaignException::class);
        $campaignTestHandler->testCampaign('id_hash', ['test@test.com']);
    }

    public function testSendingFailed()
    {
        $campaignTestHandler = $this->getCampaignTestHandlerMock(
            '{"errors":[{ "message":"Sending the campaign failed", "code":"1726" }], "status":"errors"}'
        );
        $this->expectException(FreshMailCampaignException::class);
        $campaignTestHandler->testCampaign('id_hash', ['test@test.com']);
    }
}
