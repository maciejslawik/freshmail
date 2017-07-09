<?php
/**
 * File: TransactionalEmailHandler.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\FreshMail\Handler\Message;

use MSlwk\FreshMail\Handler\AbstractHandler;

class TransactionalEmailHandler extends AbstractHandler
{
    const API_ENDPOINT = '/rest/mail';

    /**
     * @param string $email
     * @param string $subject
     * @param string $content
     * @param string $fromEmail
     * @param string $fromName
     * @param string $replyTo
     * @param string $encoding
     * @param string $attachmentUrl
     * @param string $tag
     * @param bool $tracking
     * @param string $domain
     * @return null
     */
    public function sendTransactionalEmail(
        string $email,
        string $subject,
        string $content,
        string $fromEmail = '',
        string $fromName = '',
        string $replyTo = '',
        string $encoding = 'UTF-8',
        string $attachmentUrl = '',
        string $tag = '',
        bool $tracking = false,
        string $domain = ''
    ) {
        $getParameters = [];
        $postParameters = [
            'subscriber' => $email,
            'subject' => $subject,
            'html' => $content,
            'from' => $fromEmail ?: null,
            'from_name' => $fromName ?: null,
            'reply_to' => $replyTo ?: null,
            'encoding' => $encoding ?: null,
            'attachments' => $attachmentUrl ?: null,
            'tracking' => $tracking ?: null,
            'domain' => $domain ?: null,
            'tag' => $tag ?: null
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
