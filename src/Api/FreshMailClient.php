<?php
/**
 * File: FreshMailClient.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\FreshMail\Api;

use MSlwk\FreshMail\Error\ErrorHandler;
use MSlwk\FreshMail\Handler\Ping\PingHandler;

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
        return null;
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
        return null;
    }

    /**
     * Returns array of campaigns. 25 records per page are returned.
     *
     * @param int $page
     * @return array
     */
    public function getCampaigns(int $page = 1): array
    {
        return [];
    }

    /**
     * Returns information about a single campaing.
     *
     * @param string $campaignHash
     * @return \stdClass
     */
    public function getSingleCampaign(string $campaignHash): \stdClass
    {
        return new \stdClass();
    }

    /**
     * Returns information about subscribers behaviour in time.
     *
     * @param string $campaignHash
     * @return array
     */
    public function getCampaignTimeDetails(string $campaignHash): array
    {
        return [];
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
        return null;
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
        return null;
    }

    /**
     * Sends the campaign at given time.
     *
     * @param string $campaignHash
     * @param string $timeToSend
     * @return null
     */
    public function sendCampaing(string $campaignHash, string $timeToSend = '')
    {
        return null;
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
    ): string {
        return '';
    }

    /**
     * Adds multiple subscribers to the list and optionally sets their status.
     *
     * @param array $subscribers
     * @param string $listHash
     * @param int $subscriberStatus
     * @param bool $sendConfirmationToSubscribers
     * @return null
     */
    public function addMultipleSubscribers(
        array $subscribers,
        string $listHash,
        int $subscriberStatus = 0,
        bool $sendConfirmationToSubscribers = false
    ) {
        return null;
    }

    /**
     * Updates fields of multiple subscribers and optionally changes their status.
     *
     * @param array $subscribers
     * @param string $listHash
     * @param int $subscriberStatus
     * @return null
     */
    public function editMultipleSubscribers(array $subscribers, string $listHash, int $subscriberStatus = 0)
    {
        return null;
    }

    /**
     * Updates field value for all subscribers.
     *
     * @param string $listHash
     * @param string $fieldToSetTag
     * @param string $fieldToSetValue
     * @param string $urlToSendResponse
     * @return null
     */
    public function updateMultipleSubscribersFieldValue(
        string $listHash,
        string $fieldToSetTag,
        string $fieldToSetValue,
        string $urlToSendResponse
    ) {
        return null;
    }

    /**
     * Pulls information about multiple subscribers using their email addresses.
     *
     * @param array $subscribersEmails
     * @param string $listHash
     * @return array
     */
    public function getMultipleSubscribers(array $subscribersEmails, string $listHash): array
    {
        return [];
    }

    /**
     * Deletes multiple subscribers using their email addresses.
     *
     * @param array $subscribersEmails
     * @param string $listHash
     * @return null
     */
    public function deleteMultipleSubscribers(array $subscribersEmails, string $listHash)
    {
        return null;
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
        return null;
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
        return null;
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
        return new \stdClass();
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
        return null;
    }

    /**
     * @param string $email
     * @param string $listHash
     * @param int $limit
     * @return array
     */
    public function getSubscriberHistory(string $email, string $listHash, int $limit = 10): array
    {
        return [];
    }

    /**
     * Registers a new account and returns its hash, api_key and api_secret.
     *
     * @param string $login
     * @param string $password
     * @param string $firstname
     * @param string $lastname
     * @param string $company
     * @param string $phoneNumber
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
        string $company,
        string $phoneNumber,
        bool $sendActivationEmail = true,
        bool $requireActivation = true,
        bool $isChildAccount = false
    ): \stdClass {
        return new \stdClass();
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
        return new \stdClass();
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
     * Adds a custom field to a subscriber list and returns its hash.
     *
     * @param string $listHash
     * @param string $fieldName
     * @param string $fieldTag
     * @param int $fieldType
     * @return \stdClass
     */
    public function addCustomFieldToSubscriberList(
        string $listHash,
        string $fieldName,
        string $fieldTag = '',
        int $fieldType = 1
    ): \stdClass {
        return new \stdClass();
    }

    /**
     * Pulls and array of custom fields for a subscriber list.
     *
     * @param string $listHash
     * @return array
     */
    public function getSubscriberListFields(string $listHash): array
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
        return new \stdClass();
    }
}
