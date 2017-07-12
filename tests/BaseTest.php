<?php
/**
 * File: BaseTest.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\FreshMail\Tests;

/**
 * Class BaseTest
 *
 * @package MSlwk\FreshMail\Tests
 */
trait BaseTest
{
    /**
     * @param $handlerObject
     * @return string
     */
    public function getApiEndpoint($handlerObject): string
    {
        $class = new \ReflectionClass($handlerObject);
        $method = $class->getMethod('getApiEndpoint');
        $method->setAccessible(true);
        return $method->invoke($handlerObject);
    }
}
