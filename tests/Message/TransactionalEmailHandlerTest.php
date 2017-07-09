<?php
/**
 * File: TransactionalEmailHandlerTest.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\FreshMail\Test\Message;

use PHPUnit\Framework\TestCase;
use MSlwk\FreshMail\Error\ErrorHandler;
use MSlwk\FreshMail\Exception\Message\FreshMailTransactionalEmailException;

/**
 * Class TransactionalEmailHandlerTest
 *
 * @package MSlwk\FreshMail\Test\Message
 */
class TransactionalEmailHandlerTest extends TestCase
{
    /**
     * @param $sendRequestReturnValue
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    public function getTransactionalEmailHandlerMock($sendRequestReturnValue)
    {
        $transactionalEmailHandler = $this->getMockBuilder('\MSlwk\FreshMail\Handler\Message\TransactionalEmailHandler')
            ->setConstructorArgs([new ErrorHandler(), '', ''])
            ->setMethods(['sendRequest'])
            ->getMock();

        $transactionalEmailHandler->expects($this->once())
            ->method('sendRequest')
            ->will($this->returnValue($sendRequestReturnValue));

        return $transactionalEmailHandler;
    }

    public function testEmailSuccessfullySent()
    {
        $transactionalEmailHandler = $this->getTransactionalEmailHandlerMock('{"status":"OK"}');
        $returnValue = $transactionalEmailHandler->sendTransactionalEmail(
            'recipient@email.com',
            'Email subject',
            'Email content',
            'sender@email.com',
            'Sender',
            'replyTo@email.com',
            'UTF-8',
            'http://attachment.com',
            'tag',
            false,
            'http://domain.com'
        );
        self::assertNull($returnValue);
    }

    public function testWrongSubscriberEmail()
    {
        $transactionalEmailHandler = $this->getTransactionalEmailHandlerMock(
            '{"errors":[{ "message":"Wrong email address", "code":"1201" }], "status":"errors"}'
        );
        $this->expectException(FreshMailTransactionalEmailException::class);
        $transactionalEmailHandler->sendTransactionalEmail('recipient@email.com', 'Email subject', 'Email content');
    }

    public function testNoEmailSubject()
    {
        $transactionalEmailHandler = $this->getTransactionalEmailHandlerMock(
            '{"errors":[{ "message":"Email subject missing", "code":"1202" }], "status":"errors"}'
        );
        $this->expectException(FreshMailTransactionalEmailException::class);
        $transactionalEmailHandler->sendTransactionalEmail('recipient@email.com', 'Email subject', 'Email content');
    }

    public function testNoEmailContent()
    {
        $transactionalEmailHandler = $this->getTransactionalEmailHandlerMock(
            '{"errors":[{ "message":"Email content missing", "code":"1203" }], "status":"errors"}'
        );
        $this->expectException(FreshMailTransactionalEmailException::class);
        $transactionalEmailHandler->sendTransactionalEmail('recipient@email.com', 'Email subject', 'Email content');
    }

    public function testWrongReplyToAddress()
    {
        $transactionalEmailHandler = $this->getTransactionalEmailHandlerMock(
            '{"errors":[{ "message":"Wrong replyTo email address", "code":"1204" }], "status":"errors"}'
        );
        $this->expectException(FreshMailTransactionalEmailException::class);
        $transactionalEmailHandler->sendTransactionalEmail('recipient@email.com', 'Email subject', 'Email content');
    }

    public function testWrongFromEmail()
    {
        $transactionalEmailHandler = $this->getTransactionalEmailHandlerMock(
            '{"errors":[{ "message":"Wrong from email", "code":"1205" }], "status":"errors"}'
        );
        $this->expectException(FreshMailTransactionalEmailException::class);
        $transactionalEmailHandler->sendTransactionalEmail('recipient@email.com', 'Email subject', 'Email content');
    }

    public function testEmptyFromName()
    {
        $transactionalEmailHandler = $this->getTransactionalEmailHandlerMock(
            '{"errors":[{ "message":"From name cannot be empty", "code":"1206" }], "status":"errors"}'
        );
        $this->expectException(FreshMailTransactionalEmailException::class);
        $transactionalEmailHandler->sendTransactionalEmail('recipient@email.com', 'Email subject', 'Email content');
    }

    public function testDailyLimitExceeded()
    {
        $transactionalEmailHandler = $this->getTransactionalEmailHandlerMock(
            '{"errors":[{ "message":"Daily limit exceeded", "code":"1207" }], "status":"errors"}'
        );
        $this->expectException(FreshMailTransactionalEmailException::class);
        $transactionalEmailHandler->sendTransactionalEmail('recipient@email.com', 'Email subject', 'Email content');
    }

    public function testUnsupportedEncoding()
    {
        $transactionalEmailHandler = $this->getTransactionalEmailHandlerMock(
            '{"errors":[{ "message":"Unsupported encoding", "code":"1208" }], "status":"errors"}'
        );
        $this->expectException(FreshMailTransactionalEmailException::class);
        $transactionalEmailHandler->sendTransactionalEmail('recipient@email.com', 'Email subject', 'Email content');
    }

    public function testIncorrectAttachmentUrl()
    {
        $transactionalEmailHandler = $this->getTransactionalEmailHandlerMock(
            '{"errors":[{ "message":"Wrong attachment URL", "code":"1209" }], "status":"errors"}'
        );
        $this->expectException(FreshMailTransactionalEmailException::class);
        $transactionalEmailHandler->sendTransactionalEmail('recipient@email.com', 'Email subject', 'Email content');
    }

    public function testAttachmentDoesntExist()
    {
        $transactionalEmailHandler = $this->getTransactionalEmailHandlerMock(
            '{"errors":[{ "message":"Attachment does not exist", "code":"1210" }], "status":"errors"}'
        );
        $this->expectException(FreshMailTransactionalEmailException::class);
        $transactionalEmailHandler->sendTransactionalEmail('recipient@email.com', 'Email subject', 'Email content');
    }

    public function testMaxAttachmentSizeExceeded()
    {
        $transactionalEmailHandler = $this->getTransactionalEmailHandlerMock(
            '{"errors":[{ "message":"Maximum attachment size exceeded", "code":"1211" }], "status":"errors"}'
        );
        $this->expectException(FreshMailTransactionalEmailException::class);
        $transactionalEmailHandler->sendTransactionalEmail('recipient@email.com', 'Email subject', 'Email content');
    }

    public function testIncorrectRebrandingDomain()
    {
        $transactionalEmailHandler = $this->getTransactionalEmailHandlerMock(
            '{"errors":[{ "message":"Incorrect rebranding domain", "code":"1212" }], "status":"errors"}'
        );
        $this->expectException(FreshMailTransactionalEmailException::class);
        $transactionalEmailHandler->sendTransactionalEmail('recipient@email.com', 'Email subject', 'Email content');
    }

    public function testIncorrectCampaignTag()
    {
        $transactionalEmailHandler = $this->getTransactionalEmailHandlerMock(
            '{"errors":[{ "message":"Incorrect campaign tag", "code":"1213" }], "status":"errors"}'
        );
        $this->expectException(FreshMailTransactionalEmailException::class);
        $transactionalEmailHandler->sendTransactionalEmail('recipient@email.com', 'Email subject', 'Email content');
    }

    public function testSystemError()
    {
        $transactionalEmailHandler = $this->getTransactionalEmailHandlerMock(
            '{"errors":[{ "message":"System error occurred", "code":"1250" }], "status":"errors"}'
        );
        $this->expectException(FreshMailTransactionalEmailException::class);
        $transactionalEmailHandler->sendTransactionalEmail('recipient@email.com', 'Email subject', 'Email content');
    }

    public function testSubscriberEmailBlocked()
    {
        $transactionalEmailHandler = $this->getTransactionalEmailHandlerMock(
            '{"errors":[{ "message":"The email address is blocked", "code":"1251" }], "status":"errors"}'
        );
        $this->expectException(FreshMailTransactionalEmailException::class);
        $transactionalEmailHandler->sendTransactionalEmail('recipient@email.com', 'Email subject', 'Email content');
    }
}
