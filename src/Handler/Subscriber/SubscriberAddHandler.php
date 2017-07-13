<?php
/**
 * File: SubscriberAddHandler.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\FreshMail\Handler\Subscriber;

use MSlwk\FreshMail\Handler\AbstractHandler;

/**
 * Class SubscriberAddHandler
 *
 * @package MSlwk\FreshMail\Handler\Subscriber
 */
class SubscriberAddHandler extends AbstractHandler
{
    const API_ENDPOINT = '/rest/subscriber/add';

    /**
     * @param string $email
     * @param string $listHash
     * @param int $subscriberStatus
     * @param bool $sendConfirmationToSubscriber
     * @param array $customFieldsWithValues
     * @return null
     */
    public function addSubscriber(
        string $email,
        string $listHash,
        int $subscriberStatus = 0,
        bool $sendConfirmationToSubscriber = false,
        array $customFieldsWithValues = []
    ) {
        $getParameters = [];
        $postParameters = [
            'email' => $email,
            'list' => $listHash,
            'state' => $subscriberStatus,
            'confirm' => $sendConfirmationToSubscriber,
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
