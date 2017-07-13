<?php
/**
 * File: FreshMailClient.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\FreshMail\Api;

use MSlwk\FreshMail\Error\ErrorHandler;
use MSlwk\FreshMail\Handler\Account\AccountCreateHandler;
use MSlwk\FreshMail\Handler\Campaign\CampaignCreateHandler;
use MSlwk\FreshMail\Handler\Campaign\CampaignDeleteHandler;
use MSlwk\FreshMail\Handler\Campaign\CampaignEditHandler;
use MSlwk\FreshMail\Handler\Campaign\CampaignSendHandler;
use MSlwk\FreshMail\Handler\Campaign\CampaignTestHandler;
use MSlwk\FreshMail\Handler\Lists\ListCreateHandler;
use MSlwk\FreshMail\Handler\Message\SmsHandler;
use MSlwk\FreshMail\Handler\Message\TransactionalEmailHandler;
use MSlwk\FreshMail\Handler\Ping\PingHandler;
use MSlwk\FreshMail\Handler\SpamTest\SpamTestHandler;
use MSlwk\FreshMail\Handler\Subscriber\SubscriberAddHandler;
use MSlwk\FreshMail\Handler\Subscriber\SubscriberDeleteHandler;
use MSlwk\FreshMail\Handler\Subscriber\SubscriberEditHandler;
use MSlwk\FreshMail\Handler\Subscriber\SubscriberGetHandler;

/**
 * Class FreshMailClient
 *
 * @package MSlwk\FreshMail\Api
 */
class FreshMailClient implements FreshMailClientInterface
{
    /**
     * @var string
     */
    protected $apiKey;

    /**
     * @var string
     */
    protected $apiSecret;

    /**
     * FreshMailClient constructor.
     *
     * @param string $apiKey
     * @param string $apiSecret
     */
    public function __construct(string $apiKey, string $apiSecret)
    {
        $this->apiKey = $apiKey;
        $this->apiSecret = $apiSecret;
    }

    /**
     * @return string
     */
    public function ping(): string
    {
        $handler = new PingHandler(new ErrorHandler(), $this->apiKey, $this->apiSecret);
        return $handler->ping();
    }

    /**
     * Sends a single transactional email.
     *
     * @param string $email
     * @param string $subject
     * @param string $content
     * @param string $fromEmail
     * @param string $fromName
     * @param string $replyTo
     * @param string $encoding
     * @param string $attachmentUrl
     * @param string $tag
     * @param bool $tracking
     * @param string $domain
     * @return null
     */
    public function sendTransactionalEmail(
        string $email,
        string $subject,
        string $content,
        string $fromEmail = '',
        string $fromName = '',
        string $replyTo = '',
        string $encoding = 'UTF-8',
        string $attachmentUrl = '',
        string $tag = '',
        bool $tracking = false,
        string $domain = ''
    ) {
        $handler = new TransactionalEmailHandler(new ErrorHandler(), $this->apiKey, $this->apiSecret);
        return $handler->sendTransactionalEmail(
            $email,
            $subject,
            $content,
            $fromEmail,
            $fromName,
            $replyTo,
            $encoding,
            $attachmentUrl,
            $tag,
            $tracking,
            $domain
        );
    }

    /**
     * Sends a single SMS message.
     *
     * @param string $phoneNumber
     * @param string $content
     * @param string $from
     * @param string $messageId
     * @param bool $single
     * @return null
     */
    public function sendSingleSms(
        string $phoneNumber,
        string $content,
        string $from = '',
        string $messageId = '',
        bool $single = false
    ) {
        $handler = new SmsHandler(new ErrorHandler(), $this->apiKey, $this->apiSecret);
        return $handler->sendSingleSms(
            $phoneNumber,
            $content,
            $from,
            $messageId,
            $single
        );
    }

    /**
     * Updates campaign information.
     *
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
        $handler = new CampaignEditHandler(new ErrorHandler(), $this->apiKey, $this->apiSecret);
        return $handler->editCampaign(
            $campaignHash,
            $name,
            $urlToDownloadContent,
            $content,
            $subject,
            $fromAddress,
            $fromName,
            $replyTo,
            $listHash,
            $groupHash,
            $resignLink
        );
    }

    /**
     * Deletes campaign.
     *
     * @param string $campaignHash
     * @return null
     */
    public function deleteCampaign(string $campaignHash)
    {
        $handler = new CampaignDeleteHandler(new ErrorHandler(), $this->apiKey, $this->apiSecret);
        return $handler->deleteCampaign(
            $campaignHash
        );
    }

    /**
     * Sends the campaign as a test to given list of email addresses.
     *
     * @param string $campaignHash
     * @param array $emailAddresses
     * @param array $customFieldsWithValues
     * @return null
     */
    public function testCampaign(string $campaignHash, array $emailAddresses, array $customFieldsWithValues = [])
    {
        $handler = new CampaignTestHandler(new ErrorHandler(), $this->apiKey, $this->apiSecret);
        return $handler->testCampaign(
            $campaignHash,
            $emailAddresses,
            $customFieldsWithValues
        );
    }

    /**
     * Sends the campaign at given time.
     *
     * @param string $campaignHash
     * @param string $timeToSend
     * @return null
     */
    public function sendCampaign(string $campaignHash, string $timeToSend = '')
    {
        $handler = new CampaignSendHandler(new ErrorHandler(), $this->apiKey, $this->apiSecret);
        return $handler->sendCampaign(
            $campaignHash,
            $timeToSend
        );
    }

    /**
     * Creates a new campaign.
     *
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
     * @return string Hash of the new campaign.
     */
    public function createCampaign(
        string $name,
        string $urlToDownloadContent = '',
        string $content = '',
        string $subject = '',
        string $fromAddress = '',
        string $fromName = '',
        string $replyTo = '',
        string $listHash = '',
        string $groupHash = '',
        string $resignLink = ''
    ): string {
        $handler = new CampaignCreateHandler(new ErrorHandler(), $this->apiKey, $this->apiSecret);
        return $handler->createCampaign(
            $name,
            $urlToDownloadContent,
            $content,
            $subject,
            $fromAddress,
            $fromName,
            $replyTo,
            $listHash,
            $groupHash,
            $resignLink
        );
    }

    /**
     * Adds a single subscriber to list.
     *
     * @param string $email
     * @param string $listHash
     * @param int $subscriberStatus
     * @param bool $sendConfirmationToSubscriber
     * @param array $customFieldsWithValues
     * @return null
     */
    public function addSubscriber(
        string $email,
        string $listHash,
        int $subscriberStatus = 0,
        bool $sendConfirmationToSubscriber = false,
        array $customFieldsWithValues = []
    ) {
        $handler = new SubscriberAddHandler(new ErrorHandler(), $this->apiKey, $this->apiSecret);
        return $handler->addSubscriber(
            $email,
            $listHash,
            $subscriberStatus,
            $sendConfirmationToSubscriber,
            $customFieldsWithValues
        );
    }

    /**
     * Updates custom fields of a single subscriber.
     *
     * @param string $email
     * @param string $listHash
     * @param int $subscriberStatus
     * @param array $customFieldsWithValues
     * @return null
     */
    public function editSubscriber(
        string $email,
        string $listHash,
        int $subscriberStatus = 0,
        array $customFieldsWithValues = []
    ) {
        $handler = new SubscriberEditHandler(new ErrorHandler(), $this->apiKey, $this->apiSecret);
        return $handler->editSubscriber(
            $email,
            $listHash,
            $subscriberStatus,
            $customFieldsWithValues
        );
    }

    /**
     * Pulls information about a single subscriber.
     *
     * @param string $email
     * @param string $listHash
     * @return \stdClass
     */
    public function getSubscriber(string $email, string $listHash): \stdClass
    {
        $handler = new SubscriberGetHandler(new ErrorHandler(), $this->apiKey, $this->apiSecret);
        return $handler->getSubscriber(
            $email,
            $listHash
        );
    }

    /**
     * Deletes a single subscriber.
     *
     * @param string $email
     * @param string $listHash
     * @return array
     */
    public function deleteSubscriber(string $email, string $listHash)
    {
        $handler = new SubscriberDeleteHandler(new ErrorHandler(), $this->apiKey, $this->apiSecret);
        return $handler->deleteSubscriber(
            $email,
            $listHash
        );
    }

    /**
     * Registers a new account and returns its hash, api_key and api_secret.
     *
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
        $handler = new AccountCreateHandler(new ErrorHandler(), $this->apiKey, $this->apiSecret);
        return $handler->registerNewAccount(
            $login,
            $password,
            $firstname,
            $lastname,
            $phoneNumber,
            $company,
            $sendActivationEmail,
            $requireActivation,
            $isChildAccount
        );
    }

    /**
     * Creates a subscriber list and returns its hash and array of custom fields.
     *
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
        $handler = new ListCreateHandler(new ErrorHandler(), $this->apiKey, $this->apiSecret);
        return $handler->createSubscriberList(
            $listName,
            $description,
            $customFieldsWithValues
        );
    }

    /**
     * Updates subscriber list.
     *
     * @param string $listHash
     * @param string $listName
     * @param string $description
     * @return null
     */
    public function updateSubscriberList(string $listHash, string $listName, string $description = '')
    {
        return null;
    }

    /**
     * Deletes a subscriber list.
     *
     * @param string $listHash
     * @return null
     */
    public function deleteSubscriberList(string $listHash)
    {
        return null;
    }

    /**
     * Pulls an array of subscriber lists.
     *
     * @return array
     */
    public function getSubscriberLists(): array
    {
        return [];
    }

    /**
     * Returns a list of anti-spam checks the message failed and the likelihood of falling into spam.
     *
     * @param string $subject
     * @param string $content
     * @param string $fromEmail
     * @param string $fromName
     * @return \stdClass
     */
    public function spamCheck(
        string $subject,
        string $content,
        string $fromEmail = '',
        string $fromName = ''
    ): \stdClass {
        $handler = new SpamTestHandler(new ErrorHandler(), $this->apiKey, $this->apiSecret);
        return $handler->spamCheck(
            $subject,
            $content,
            $fromEmail,
            $fromName
        );
    }
}
