<?php
/**
 * File: CampaignTestHandler.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\FreshMail\Handler\Campaign;

use MSlwk\FreshMail\Handler\AbstractHandler;

class CampaignTestHandler extends AbstractHandler
{
    const API_ENDPOINT = '/rest/campaigns/sendTest';

    /**
     * @param string $campaignHash
     * @param array $emailAddresses
     * @param array $customFieldsWithValues
     * @return null
     */
    public function testCampaign(string $campaignHash, array $emailAddresses, array $customFieldsWithValues = [])
    {
        $getParameters = [];
        $postParameters = [
            'hash' => $campaignHash,
            'emails' => $emailAddresses,
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