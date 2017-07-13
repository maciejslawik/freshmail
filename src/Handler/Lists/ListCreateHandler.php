<?php
/**
 * File: ListCreateHandler.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\FreshMail\Handler\Lists;

use MSlwk\FreshMail\Handler\AbstractHandler;

/**
 * Class ListCreateHandler
 *
 * @package MSlwk\FreshMail\Handler\Lists
 */
class ListCreateHandler extends AbstractHandler
{
    const API_ENDPOINT = '/rest/subscribers_list/create';

    /**
     * @param string $listName
     * @param string $description
     * @param array $customFieldsWithValues
     * @return \stdClass
     */
    public function createSubscriberList(
        string $listName,
        string $description = '',
        array $customFieldsWithValues = []
    ): \stdClass {
        $getParameters = [];
        $postParameters = [
            'name' => $listName,
            'description' => $description ?: null,
            'custom_fields' => $customFieldsWithValues
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
