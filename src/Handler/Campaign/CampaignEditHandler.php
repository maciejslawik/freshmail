<?php
/**
 * File: CampaignEditHandler.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\FreshMail\Handler\Campaign;

use MSlwk\FreshMail\Handler\AbstractHandler;

/**
 * Class CampaignEditHandler
 *
 * @package MSlwk\FreshMail\Handler\Campaign
 */
class CampaignEditHandler extends AbstractHandler
{
    const API_ENDPOINT = '/rest/campaigns/edit';

    /**
     * @param string $campaignHash
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
     * @return null
     */
    public function editCampaign(
        string $campaignHash,
        string $name = '',
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
            'id_hash' => $campaignHash,
            'name' => $name ?: null,
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
