<?php
/**
 * File: SpamTestHandlerTest.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\FreshMail\Test\SpamTest;

use MSlwk\FreshMail\Handler\SpamTest\SpamTestHandler;
use MSlwk\FreshMail\Tests\BaseTest;
use PHPUnit\Framework\TestCase;
use MSlwk\FreshMail\Error\ErrorHandler;
use MSlwk\FreshMail\Exception\SpamTest\FreshMailSpamTestException;

/**
 * Class SpamTestHandlerTest
 *
 * @package MSlwk\FreshMail\Test\SpamTest
 */
class SpamTestHandlerTest extends TestCase
{
    use BaseTest;

    /**
     * @param $sendRequestReturnValue
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    public function getSpamTestHandlerMock($sendRequestReturnValue)
    {
        $spamTestHandler = $this->getMockBuilder('\MSlwk\FreshMail\Handler\SpamTest\SpamTestHandler')
            ->setConstructorArgs([new ErrorHandler(), '', ''])
            ->setMethods(['sendRequest'])
            ->getMock();

        $spamTestHandler->expects($this->once())
            ->method('sendRequest')
            ->will($this->returnValue($sendRequestReturnValue));

        return $spamTestHandler;
    }

    public function testSpamTestSuccessful()
    {
        $expectedTestsFailed = ['test1'];
        $expectedScore = 3.2;
        $spamTestHandler = $this->getSpamTestHandlerMock('{"status":"OK","tests":'
            . json_encode($expectedTestsFailed) . ',"score":' . $expectedScore . '}');
        $returnData = $spamTestHandler->spamCheck('Test', 'Test');
        self::assertEquals($expectedTestsFailed, $returnData->tests);
        self::assertEquals($expectedScore, $returnData->score);
    }

    public function testApiEndpoint()
    {
        $accountCreateHandler = new SpamTestHandler(new ErrorHandler(), '', '');
        $expectedApiEndpoint = '/rest/spam_test/check';
        $returnedApiEndpoint = $this->getApiEndpoint($accountCreateHandler);
        self::assertEquals($expectedApiEndpoint, $returnedApiEndpoint);
    }

    public function testEmptySubject()
    {
        $spamTestHandler = $this->getSpamTestHandlerMock(
            '{"errors":[{ "message":"Empty subject", "code":"1901" }], "status":"errors"}'
        );
        $this->expectException(FreshMailSpamTestException::class);
        $spamTestHandler->spamCheck('Test', 'Test');
    }

    public function testIncorrectFromAddress()
    {
        $spamTestHandler = $this->getSpamTestHandlerMock(
            '{"errors":[{ "message":"Incorrect from_address", "code":"1902" }], "status":"errors"}'
        );
        $this->expectException(FreshMailSpamTestException::class);
        $spamTestHandler->spamCheck('Test', 'Test');
    }

    public function testEmptyContent()
    {
        $spamTestHandler = $this->getSpamTestHandlerMock(
            '{"errors":[{ "message":"Empty contect", "code":"1904" }], "status":"errors"}'
        );
        $this->expectException(FreshMailSpamTestException::class);
        $spamTestHandler->spamCheck('Test', 'Test');
    }

    public function testSystemError()
    {
        $spamTestHandler = $this->getSpamTestHandlerMock(
            '{"errors":[{ "message":"Spam-test system error", "code":"1906" }], "status":"errors"}'
        );
        $this->expectException(FreshMailSpamTestException::class);
        $spamTestHandler->spamCheck('Test', 'Test');
    }

    public function testDailyLimitExceeded()
    {
        $spamTestHandler = $this->getSpamTestHandlerMock(
            '{"errors":[{ "message":"Daily limit exceeded", "code":"1907" }], "status":"errors"}'
        );
        $this->expectException(FreshMailSpamTestException::class);
        $spamTestHandler->spamCheck('Test', 'Test');
    }


}
