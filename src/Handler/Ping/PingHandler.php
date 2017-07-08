<?php
/**
 * File: PingHandler.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\FreshMail\Handler\Ping;

use MSlwk\FreshMail\Handler\AbstractHandler;

/**
 * Class PingHandler
 *
 * @package MSlwk\FreshMail\Handler\Ping
 */
class PingHandler extends AbstractHandler
{
    const API_ENDPOINT = '/rest/ping';

    /**
     * @return string
     */
    public function ping(): string
    {
        $response = $this->processRequest();
        return $response->data;
    }

    /**
     * @return string
     */
    protected function getApiEndpoint(): string
    {
        return self::API_ENDPOINT;
    }
}
