<?php
/**
 * File: SubscriberDeleteHandler.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\FreshMail\Handler\Subscriber;

use MSlwk\FreshMail\Handler\AbstractHandler;

/**
 * Class SubscriberDeleteHandler
 *
 * @package MSlwk\FreshMail\Handler\Subscriber
 */
class SubscriberDeleteHandler extends AbstractHandler
{
    const API_ENDPOINT = '/rest/subscriber/delete';

    /**
     * @param string $email
     * @param string $listHash
     * @return null
     */
    public function deleteSubscriber(
        string $email,
        string $listHash
    ) {
        $getParameters = [];
        $postParameters = [
            'email' => $email,
            'list' => $listHash
        ];

        $this->processRequest($getParameters, $postParameters);
        return null;
    }

    /**
     * @return string
     */
    protected function getApiEndpoint(): string
    {
        return self::API_ENDPOINT;
    }
}
