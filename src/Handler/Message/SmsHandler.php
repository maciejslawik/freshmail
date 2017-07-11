<?php
/**
 * File: SmsHandler.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\FreshMail\Handler\Message;

use MSlwk\FreshMail\Handler\AbstractHandler;

/**
 * Class SmsHandler
 *
 * @package MSlwk\FreshMail\Handler\Message
 */
class SmsHandler extends AbstractHandler
{
    const API_ENDPOINT = '/rest/sms/send';

    /**
     * @param string $phoneNumber
     * @param string $content
     * @param string $from
     * @param string $messageId
     * @param bool $single
     * @return null
     */
    public function sendSingleSms(
        string $phoneNumber,
        string $content,
        string $from = '',
        string $messageId = '',
        bool $single = false
    ) {
        $getParameters = [];
        $postParameters = [
            'gsm' => $phoneNumber,
            'text' => $content,
            'from' => $from ?: null,
            'single' => $single,
            'messageId' => $messageId ?: null
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
