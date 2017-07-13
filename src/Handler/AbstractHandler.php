<?php
/**
 * File: AbstractHandler.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\FreshMail\Handler;

use MSlwk\FreshMail\Error\ErrorHandlerInterface;
use MSlwk\FreshMail\Exception\Connection\FreshMailConnectionException;

/**
 * Class AbstractHandler
 *
 * @package MSlwk\FreshMail\Handler
 */
abstract class AbstractHandler
{
    const API_URL = 'https://api.freshmail.com';

    /**
     * @var ErrorHandlerInterface
     */
    protected $errorHandler;

    /**
     * @var string
     */
    protected $apiKey;

    /**
     * @var string
     */
    protected $apiSecret;

    /**
     * AbstractHandler constructor.
     *
     * @param ErrorHandlerInterface $errorHandler
     * @param string $apiKey
     * @param string $apiSecret ]
     */
    public function __construct(ErrorHandlerInterface $errorHandler, string $apiKey, string $apiSecret)
    {
        $this->errorHandler = $errorHandler;
        $this->apiKey = $apiKey;
        $this->apiSecret = $apiSecret;
    }

    /**
     * @param string $getData
     * @param string $jsonData
     * @return string
     */
    protected function getAuthorizationHash(string $getData, string $jsonData): string
    {
        return sha1($this->apiKey . $getData . $jsonData . $this->apiSecret);
    }

    /**
     * @param array $getRequestParams
     * @param array $postRequestParams
     * @return \stdClass
     */
    protected function processRequest(array $getRequestParams = [], array $postRequestParams = []): \stdClass
    {
        $apiResponse = $this->sendRequest(
            $this->generateGetParamsString($getRequestParams),
            $this->generatePostParamsString($postRequestParams)
        );

        $responseObject = json_decode($apiResponse);
        $this->validate($responseObject);
        return $responseObject;
    }

    /**
     * @param string $getRequestParamsString
     * @param string $postRequestParamsString
     * @return string
     * @throws FreshMailConnectionException
     */
    protected function sendRequest(string $getRequestParamsString, string $postRequestParamsString): string
    {
        $headers = [
            'Content-Type: application/json',
            'X-Rest-ApiKey: ' . $this->apiKey,
            'X-Rest-ApiSign: ' . $this->getAuthorizationHash(
                $this->getApiEndpoint() . $getRequestParamsString,
                $postRequestParamsString
            )
        ];
        $curl = curl_init(self::API_URL . $this->getApiEndpoint() . $getRequestParamsString);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_HEADER, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        if ($postRequestParamsString) {
            curl_setopt($curl, CURLOPT_POSTFIELDS, $postRequestParamsString);
            curl_setopt($curl, CURLOPT_POST, true);
        }
        $rawResponse = curl_exec($curl);

        $headerSize = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
        $response = substr($rawResponse, $headerSize);
        curl_close($curl);

        return $response;
    }

    /**
     * @param $response
     * @throws FreshMailConnectionException
     */
    protected function validate($response)
    {
        if (!$response instanceof \stdClass) {
            throw new FreshMailConnectionException();
        }
        if ($response->status !== 'OK') {
            $this->errorHandler->raiseException($response->errors[0]);
        }
    }

    /**
     * @param array $getParams
     * @return string
     */
    private function generateGetParamsString(array $getParams): string
    {
        $requstParamsString = '';
        foreach ($getParams as $param) {
            $requstParamsString .= '/' . $param;
        }
        return $requstParamsString;
    }

    /**
     * @param array $postParams
     * @return string
     */
    private function generatePostParamsString(array $postParams): string
    {
        if (empty($postParams)) {
            $requestParamsString = '';
        } else {
            $requestParamsString = json_encode($postParams);
        }
        return $requestParamsString;
    }

    /**
     * @return string
     */
    abstract protected function getApiEndpoint(): string;
}
