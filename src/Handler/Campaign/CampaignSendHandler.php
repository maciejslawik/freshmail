<?php
/**
 * File: CampaignSendHandler.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\FreshMail\Handler\Campaign;

use MSlwk\FreshMail\Handler\AbstractHandler;

/**
 * Class CampaignSendHandler
 *
 * @package MSlwk\FreshMail\Handler\Campaign
 */
class CampaignSendHandler extends AbstractHandler
{
    const API_ENDPOINT = '/rest/campaigns/send';

    /**
     * @param string $campaignHash
     * @param string $timeToSend
     * @return null
     */
    public function sendCampaign(string $campaignHash, string $timeToSend = '')
    {
        $getParameters = [];
        $postParameters = [
            'hash' => $campaignHash,
            'time' => $timeToSend ?: null
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
