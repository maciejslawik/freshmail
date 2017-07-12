<?php
/**
 * File: AccountCreateHandler.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\FreshMail\Handler\Account;

use MSlwk\FreshMail\Handler\AbstractHandler;

/**
 * Class AccountCreateHandler
 *
 * @package MSlwk\FreshMail\Handler\Account
 */
class AccountCreateHandler extends AbstractHandler
{
    const API_ENDPOINT = '/rest/account/create';

    /**
     * @param string $login
     * @param string $password
     * @param string $firstname
     * @param string $lastname
     * @param string $phoneNumber
     * @param string $company
     * @param bool $sendActivationEmail
     * @param bool $requireActivation
     * @param bool $isChildAccount
     * @return \stdClass
     */
    public function registerNewAccount(
        string $login,
        string $password,
        string $firstname,
        string $lastname,
        string $phoneNumber,
        string $company = '',
        bool $sendActivationEmail = true,
        bool $requireActivation = true,
        bool $isChildAccount = false
    ): \stdClass {
        $getParameters = [];
        $postParameters = [
            'login' => $login,
            'password' => $password,
            'firstname' => $firstname,
            'lastname' => $lastname,
            'phone' => $phoneNumber,
            'company' => $company ?: null,
            'activation_mail' => $sendActivationEmail,
            'activation' => $requireActivation,
            'child_account' => $isChildAccount
        ];

        $postParameters = array_filter($postParameters, function ($value) {
            return $value !== null;
        });
        $response = $this->processRequest($getParameters, $postParameters);
        return $response->data;
    }

    /**
     * @return string
     */
    protected function getApiEndpoint(): string
    {
        return self::API_ENDPOINT;
    }
}
