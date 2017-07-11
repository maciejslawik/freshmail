<?php
/**
 * File: CampaignDeleteHandler.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\FreshMail\Handler\Campaign;

use MSlwk\FreshMail\Handler\AbstractHandler;

class CampaignDeleteHandler extends AbstractHandler
{
    const API_ENDPOINT = '/rest/campaigns/delete';

    /**
     * @param string $campaignHash
     * @return null
     */
    public function deleteCampaign(
        string $campaignHash
    ) {
        $getParameters = [];
        $postParameters = [
            'hash' => $campaignHash
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