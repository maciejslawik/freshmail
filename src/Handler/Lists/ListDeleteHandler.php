<?php
/**
 * File: ListDeleteHandler.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\FreshMail\Handler\Lists;

use MSlwk\FreshMail\Handler\AbstractHandler;

/**
 * Class ListDeleteHandler
 *
 * @package MSlwk\FreshMail\Handler\Lists
 */
class ListDeleteHandler extends AbstractHandler
{
    const API_ENDPOINT = '/rest/subscribers_list/delete';

    /**
     * @param string $listHash
     * @return null
     */
    public function deleteSubscriberList(string $listHash)
    {
        $getParameters = [];
        $postParameters = [
            'hash' => $listHash
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
