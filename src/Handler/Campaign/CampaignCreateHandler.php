<?php
/**
 * File: CampaignCreateHandler.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\FreshMail\Handler\Campaign;

use MSlwk\FreshMail\Handler\AbstractHandler;

/**
 * Class CampaignCreateHandler
 *
 * @package MSlwk\FreshMail\Handler\Campaign
 */
class CampaignCreateHandler extends AbstractHandler
{
    const API_ENDPOINT = '/rest/campaigns/create';

    /**
     * @param string $name
     * @param string $urlToDownloadContent
     * @param string $content
     * @param string $subject
     * @param string $fromAddress
     * @param string $fromName
     * @param string $replyTo
     * @param string $listHash
     * @param string $groupHash
     * @param string $resignLink
     * @return string
     */
    public function createCampaign(
        string $name,
        string $urlToDownloadContent = '',
        string $content = '',
        string $subject = '',
        string $fromAddress = '',
        string $fromName = '',
        string $replyTo = '',
        string $listHash = '',
        string $groupHash = '',
        string $resignLink = ''
    ) {
        $getParameters = [];
        $postParameters = [
            'name' => $name,
            'url' => $urlToDownloadContent ?: null,
            'html' => $content ?: null,
            'subject' => $subject ?: null,
            'from_address' => $fromAddress ?: null,
            'from_name' => $fromName ?: null,
            'reply_to' => $replyTo ?: null,
            'list' => $listHash ?: null,
            'group' => $groupHash ?: null,
            'resignlink' => $resignLink ?: null
        ];

        $postParameters = array_filter($postParameters, function ($value) {
            return $value !== null;
        });
        $response = $this->processRequest($getParameters, $postParameters);
        return $response->data->hash;
    }

    /**
     * @return string
     */
    protected function getApiEndpoint(): string
    {
        return self::API_ENDPOINT;
    }
}
