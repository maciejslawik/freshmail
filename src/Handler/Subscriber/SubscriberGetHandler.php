<?php
/**
 * File: SubscriberGetHandler.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\FreshMail\Handler\Subscriber;

use MSlwk\FreshMail\Handler\AbstractHandler;

/**
 * Class SubscriberGetHandler
 *
 * @package MSlwk\FreshMail\Handler\Subscriber
 */
class SubscriberGetHandler extends AbstractHandler
{
    const API_ENDPOINT = '/rest/subscriber/get';

    /**
     * @param string $email
     * @param string $listHash
     * @return \stdClass
     */
    public function getSubscriber(string $email, string $listHash): \stdClass
    {
        $getParameters = [
            $listHash,
            $email
        ];
        $postParameters = [];

        $response = $this->processRequest($getParameters, $postParameters);
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
