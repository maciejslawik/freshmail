<?php
/**
 * File: AbstractHandlerTest.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\FreshMail\Test\Base;

use MSlwk\FreshMail\Error\ErrorHandler;
use PHPUnit\Framework\TestCase;

/**
 * Class AbstractHandlerTest
 *
 * @package MSlwk\FreshMail\Test\Base
 */
class AbstractHandlerTest extends TestCase
{
    /**
     * @param $apiKey
     * @param $apiSecret
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    protected function getAbstractHandlerMock($apiKey, $apiSecret)
    {
        return $this->getMockForAbstractClass(
            '\MSlwk\FreshMail\Handler\AbstractHandler',
            [
                new ErrorHandler(),
                $apiKey,
                $apiSecret
            ]
        );
    }

    /**
     * @return array
     */
    public function providerTestGenerateGetParametersString()
    {
        return [
            [['user', '123'], '/user/123'],
            [[], '']
        ];
    }

    /**
     * @return array
     */
    public function providerTestGeneratePostParametersString()
    {
        return [
            [['hash' => '124e12', 'email' => 'test@test.com'], '{"hash":"124e12","email":"test@test.com"}'],
            [[], '']
        ];
    }

    public function testAuthorizationHashGeneration()
    {
        $handler = $this->getAbstractHandlerMock('qwfgqwgqwfqw2e412421r', 'fqwf214214r12dfqf21f');

        $reflection = new \ReflectionClass(get_class($handler));
        $method = $reflection->getMethod('getAuthorizationHash');
        $method->setAccessible(true);

        $generatedHash = $method->invokeArgs($handler, ['/rest/ping', '']);
        self::assertEquals('fabe17d9e6096a32b6c57cfcef8af070e007e774', $generatedHash);
    }

    /**
     * @param $parametersArray
     * @param $expectedResultString
     *
     * @dataProvider providerTestGenerateGetParametersString
     */
    public function testGenerateGetParametersString($parametersArray, $expectedResultString)
    {
        $handler = $this->getAbstractHandlerMock('', '');

        $reflection = new \ReflectionClass(get_class($handler));
        $method = $reflection->getMethod('generateGetParamsString');
        $method->setAccessible(true);

        $generatedResultString = $method->invokeArgs($handler, [$parametersArray]);
        self::assertEquals($expectedResultString, $generatedResultString);
    }

    /**
     * @param $parametersArray
     * @param $expectedResultString
     *
     * @dataProvider providerTestGeneratePostParametersString
     */
    public function testGeneratePostParametersString($parametersArray, $expectedResultString)
    {
        $handler = $this->getAbstractHandlerMock('', '');

        $reflection = new \ReflectionClass(get_class($handler));
        $method = $reflection->getMethod('generatePostParamsString');
        $method->setAccessible(true);

        $generatedResultString = $method->invokeArgs($handler, [$parametersArray]);
        self::assertEquals($expectedResultString, $generatedResultString);
    }
}
