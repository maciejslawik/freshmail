<?php
/**
 * File: SubscriberEditHandler.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\FreshMail\Handler\Subscriber;

use MSlwk\FreshMail\Handler\AbstractHandler;

/**
 * Class SubscriberEditHandler
 *
 * @package MSlwk\FreshMail\Handler\Subscriber
 */
class SubscriberEditHandler extends AbstractHandler
{
    const API_ENDPOINT = '/rest/subscriber/edit';

    /**
     * @param string $email
     * @param string $listHash
     * @param int $subscriberStatus
     * @param array $customFieldsWithValues
     * @return null
     */
    public function editSubscriber(
        string $email,
        string $listHash,
        int $subscriberStatus = 0,
        array $customFieldsWithValues = []
    ) {
        $getParameters = [];
        $postParameters = [
            'email' => $email,
            'list' => $listHash,
            'state' => $subscriberStatus,
            'custom_fields' => $customFieldsWithValues ?: null
        ];

        $postParameters = array_filter($postParameters, function ($value) {
            return $value !== null;
        });
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
