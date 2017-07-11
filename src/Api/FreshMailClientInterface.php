<?php
/**
 * File: FreshMailClientInterface.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\FreshMail\Api;

/**
 * Interface FreshMailClientInterface
 *
 * @package MSlwk\FreshMail\Api
 */
interface FreshMailClientInterface
{
    /**—
     * @return string
     */
    public function ping(): string;

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
    );

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
    );

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
    );

    /**
     * Deletes campaign.
     *
     * @param string $campaignHash
     * @return null
     */
    public function deleteCampaign(string $campaignHash);

    /**
     * Sends the campaign as a test to given list of email addresses.
     *
     * @param string $campaignHash
     * @param array $emailAddresses
     * @param array $customFieldsWithValues
     * @return null
     */
    public function testCampaign(string $campaignHash, array $emailAddresses, array $customFieldsWithValues = []);

    /**
     * Sends the campaign at given time.
     *
     * @param string $campaignHash
     * @param string $timeToSend
     * @return null
     */
    public function sendCampaing(string $campaignHash, string $timeToSend = '');

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
    ): string;

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
    );

    /**
     * Updates fields of multiple subscribers and optionally changes their status.
     *
     * @param array $subscribers
     * @param string $listHash
     * @param int $subscriberStatus
     * @return null
     */
    public function editMultipleSubscribers(array $subscribers, string $listHash, int $subscriberStatus = 0);

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
    );

    /**
     * Pulls information about multiple subscribers using their email addresses.
     *
     * @param array $subscribersEmails
     * @param string $listHash
     * @return array
     */
    public function getMultipleSubscribers(array $subscribersEmails, string $listHash): array;

    /**
     * Deletes multiple subscribers using their email addresses.
     *
     * @param array $subscribersEmails
     * @param string $listHash
     * @return null
     */
    public function deleteMultipleSubscribers(array $subscribersEmails, string $listHash);

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
    );

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
    );

    /**
     * Pulls information about a single subscriber.
     *
     * @param string $email
     * @param string $listHash
     * @return \stdClass
     */
    public function getSubscriber(string $email, string $listHash): \stdClass;

    /**
     * Deletes a single subscriber.
     *
     * @param string $email
     * @param string $listHash
     * @return array
     */
    public function deleteSubscriber(string $email, string $listHash);

    /**
     * @param string $email
     * @param string $listHash
     * @param int $limit
     * @return array
     */
    public function getSubscriberHistory(string $email, string $listHash, int $limit = 10): array;

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
    ): \stdClass;

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
    ): \stdClass;

    /**
     * Updates subscriber list.
     *
     * @param string $listHash
     * @param string $listName
     * @param string $description
     * @return null
     */
    public function updateSubscriberList(string $listHash, string $listName, string $description = '');

    /**
     * Deletes a subscriber list.
     *
     * @param string $listHash
     * @return null
     */
    public function deleteSubscriberList(string $listHash);

    /**
     * Pulls an array of subscriber lists.
     *
     * @return array
     */
    public function getSubscriberLists(): array;

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
    ): \stdClass;

    /**
     * Pulls and array of custom fields for a subscriber list.
     *
     * @param string $listHash
     * @return array
     */
    public function getSubscriberListFields(string $listHash): array;

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
    ): \stdClass;
}
