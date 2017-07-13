<?php
/**
 * File: ListEditHandler.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\FreshMail\Handler\Lists;

use MSlwk\FreshMail\Handler\AbstractHandler;

/**
 * Class ListEditHandler
 *
 * @package MSlwk\FreshMail\Handler\Lists
 */
class ListEditHandler extends AbstractHandler
{
    const API_ENDPOINT = '/rest/subscribers_list/update';

    /**
     * @param string $listHash
     * @param string $listName
     * @param string $description
     * @return null
     */
    public function updateSubscriberList(string $listHash, string $listName, string $description = '')
    {
        $getParameters = [];
        $postParameters = [
            'hash' => $listHash,
            'name' => $listName,
            'description' => $description ?: null
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
