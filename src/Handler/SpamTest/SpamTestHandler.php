<?php
/**
 * File: SpamTestHandler.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\FreshMail\Handler\SpamTest;

use MSlwk\FreshMail\Handler\AbstractHandler;

/**
 * Class SpamTestHandler
 *
 * @package MSlwk\FreshMail\Handler\SpamTest
 */
class SpamTestHandler extends AbstractHandler
{
    const API_ENDPOINT = '/rest/spam_test/check';

    /**
     * @param string $subject
     * @param string $content
     * @param string $fromEmail
     * @param string $fromName
     * @return \stdClass
     */
    public function spamCheck(
        string $subject,
        string $content,
        string $fromEmail = '',
        string $fromName = ''
    ): \stdClass {
        $getParameters = [];
        $postParameters = [
            'subject' => $subject,
            'html' => $content,
            'from' => $fromEmail ?: null,
            'from_name' => $fromName ?: null
        ];

        $postParameters = array_filter($postParameters, function ($value) {
            return $value !== null;
        });
        $response = $this->processRequest($getParameters, $postParameters);
        return $response;
    }

    /**
     * @return string
     */
    protected function getApiEndpoint(): string
    {
        return self::API_ENDPOINT;
    }
}
