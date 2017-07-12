<?php
/**
 * File: AccountCreateHandlerTest.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\FreshMail\Test\Account;

use PHPUnit\Framework\TestCase;
use MSlwk\FreshMail\Error\ErrorHandler;
use MSlwk\FreshMail\Exception\Account\FreshMailAccountException;

/**
 * Class AccountCreateHandlerTest
 *
 * @package MSlwk\FreshMail\Test\Account
 */
class AccountCreateHandlerTest extends TestCase
{
    /**
     * @param $sendRequestReturnValue
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    public function getAccountCreateHandlerMock($sendRequestReturnValue)
    {
        $accountCreateHandler = $this->getMockBuilder('\MSlwk\FreshMail\Handler\Account\AccountCreateHandler')
            ->setConstructorArgs([new ErrorHandler(), '', ''])
            ->setMethods(['sendRequest'])
            ->getMock();

        $accountCreateHandler->expects($this->once())
            ->method('sendRequest')
            ->will($this->returnValue($sendRequestReturnValue));

        return $accountCreateHandler;
    }

    public function testAccountCreatedSuccessfully()
    {
        $expectedHash = '412rfefewf';
        $expectedApiKey = '123dfvdnajklqnvad3';
        $expectedApiSecret = 'fgvewqg234t312tgbvfb';
        $accountCreateHandler = $this->getAccountCreateHandlerMock(
            '{"status":"OK", "data": {"hash":"'
            . $expectedHash . '","api_key":"'
            . $expectedApiKey . '","api_secret":"'
            . $expectedApiSecret . '"}}'
        );
        $returnData = $accountCreateHandler->registerNewAccount('Test', 'Test', 'Test', 'Test', '987654321');
        self::assertEquals($expectedHash, $returnData->hash);
        self::assertEquals($expectedApiKey, $returnData->api_key);
        self::assertEquals($expectedApiSecret, $returnData->api_secret);
    }

    public function testEmptyLogin()
    {
        $accountCreateHandler = $this->getAccountCreateHandlerMock(
            '{"errors":[{ "message":"Empty login", "code":"1501" }], "status":"errors"}'
        );
        $this->expectException(FreshMailAccountException::class);
        $accountCreateHandler->registerNewAccount('Test', 'Test', 'Test', 'Test', '987654321');
    }

    public function testIncorrectLogin()
    {
        $accountCreateHandler = $this->getAccountCreateHandlerMock(
            '{"errors":[{ "message":"Incorrect login", "code":"1502" }], "status":"errors"}'
        );
        $this->expectException(FreshMailAccountException::class);
        $accountCreateHandler->registerNewAccount('Test', 'Test', 'Test', 'Test', '987654321');
    }

    public function testLoginAlreadyExists()
    {
        $accountCreateHandler = $this->getAccountCreateHandlerMock(
            '{"errors":[{ "message":"Login already exists", "code":"1503" }], "status":"errors"}'
        );
        $this->expectException(FreshMailAccountException::class);
        $accountCreateHandler->registerNewAccount('Test', 'Test', 'Test', 'Test', '987654321');
    }

    public function testEmptyPassword()
    {
        $accountCreateHandler = $this->getAccountCreateHandlerMock(
            '{"errors":[{ "message":"Empty password", "code":"1504" }], "status":"errors"}'
        );
        $this->expectException(FreshMailAccountException::class);
        $accountCreateHandler->registerNewAccount('Test', 'Test', 'Test', 'Test', '987654321');
    }

    public function testPasswordTooWeak()
    {
        $accountCreateHandler = $this->getAccountCreateHandlerMock(
            '{"errors":[{ "message":"Password too weak", "code":"1505" }], "status":"errors"}'
        );
        $this->expectException(FreshMailAccountException::class);
        $accountCreateHandler->registerNewAccount('Test', 'Test', 'Test', 'Test', '987654321');
    }

    public function testEmptyFirstname()
    {
        $accountCreateHandler = $this->getAccountCreateHandlerMock(
            '{"errors":[{ "message":"Empty firstname", "code":"1506" }], "status":"errors"}'
        );
        $this->expectException(FreshMailAccountException::class);
        $accountCreateHandler->registerNewAccount('Test', 'Test', 'Test', 'Test', '987654321');
    }

    public function testEmptyLastname()
    {
        $accountCreateHandler = $this->getAccountCreateHandlerMock(
            '{"errors":[{ "message":"Empty lastname", "code":"1507" }], "status":"errors"}'
        );
        $this->expectException(FreshMailAccountException::class);
        $accountCreateHandler->registerNewAccount('Test', 'Test', 'Test', 'Test', '987654321');
    }

    public function testEmptyPhone()
    {
        $accountCreateHandler = $this->getAccountCreateHandlerMock(
            '{"errors":[{ "message":"Empty phone number", "code":"1509" }], "status":"errors"}'
        );
        $this->expectException(FreshMailAccountException::class);
        $accountCreateHandler->registerNewAccount('Test', 'Test', 'Test', 'Test', '987654321');
    }

    public function testErrorOccurred()
    {
        $accountCreateHandler = $this->getAccountCreateHandlerMock(
            '{"errors":[{ "message":"An error occurred", "code":"1510" }], "status":"errors"}'
        );
        $this->expectException(FreshMailAccountException::class);
        $accountCreateHandler->registerNewAccount('Test', 'Test', 'Test', 'Test', '987654321');
    }

    public function testAccountNotCreated()
    {
        $accountCreateHandler = $this->getAccountCreateHandlerMock(
            '{"errors":[{ "message":"Account was not created", "code":"1511" }], "status":"errors"}'
        );
        $this->expectException(FreshMailAccountException::class);
        $accountCreateHandler->registerNewAccount('Test', 'Test', 'Test', 'Test', '987654321');
    }

    public function testAccountNotAssignedToApplication()
    {
        $accountCreateHandler = $this->getAccountCreateHandlerMock(
            '{"errors":[{ "message":"Account couldnt be assigned to application", "code":"1512" }], "status":"errors"}'
        );
        $this->expectException(FreshMailAccountException::class);
        $accountCreateHandler->registerNewAccount('Test', 'Test', 'Test', 'Test', '987654321');
    }

    public function testAccountCreationAccessDenied()
    {
        $accountCreateHandler = $this->getAccountCreateHandlerMock(
            '{"errors":[{ "message":"Account creation access denied", "code":"1513" }], "status":"errors"}'
        );
        $this->expectException(FreshMailAccountException::class);
        $accountCreateHandler->registerNewAccount('Test', 'Test', 'Test', 'Test', '987654321');
    }
}
