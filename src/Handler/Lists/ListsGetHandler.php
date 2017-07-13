<?php
/**
 * File: ListsGetHandler.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\FreshMail\Handler\Lists;

use MSlwk\FreshMail\Handler\AbstractHandler;

/**
 * Class ListsGetHandler
 *
 * @package MSlwk\FreshMail\Handler\Lists
 */
class ListsGetHandler extends AbstractHandler
{
    const API_ENDPOINT = '/rest/subscribers_list/lists';

    /**
     * @return array
     */
    public function getSubscriberLists(): array
    {
        $getParameters = [];
        $postParameters = [];

        $response = $this->processRequest($getParameters, $postParameters);
        return $response->lists;
    }

    /**
     * @return string
     */
    protected function getApiEndpoint(): string
    {
        return self::API_ENDPOINT;
    }
}
