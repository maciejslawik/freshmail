<?php
/**
 * File: ErrorHandler.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\FreshMail\Error;

use MSlwk\FreshMail\Exception\Authorization\FreshMailAuthorizationException;
use MSlwk\FreshMail\Exception\Campaign\FreshMailCampaignException;
use MSlwk\FreshMail\Exception\FreshMailException;
use MSlwk\FreshMail\Exception\Message\FreshMailSmsException;
use MSlwk\FreshMail\Exception\Message\FreshMailTransactionalEmailException;

/**
 * Class ErrorHandler
 *
 * @package MSlwk\FreshMail\Error
 */
class ErrorHandler implements ErrorHandlerInterface
{
    /**
     * @param \stdClass $error
     * @throws FreshMailAuthorizationException
     * @throws FreshMailCampaignException
     * @throws FreshMailException
     * @throws FreshMailSmsException
     * @throws FreshMailTransactionalEmailException
     * @return null
     */
    public function raiseException(\stdClass $error)
    {
        $message = $error->message;
        $code = $error->code;

        switch ($code) {
            case $code >= 1000 && $code <= 1004:
                throw new FreshMailAuthorizationException($message, $code);
            case $code >= 1101 && $code <= 1109:
            case 1150:
                throw new FreshMailSmsException($message, $code);
            case $code >= 1201 && $code <= 1213:
            case $code >= 1250 && $code <= 1251:
                throw new FreshMailTransactionalEmailException($message, $code);
            case $code >= 1721 && $code <= 1726:
            case $code >= 1750 && $code <= 1751:
            case 1798:
                throw new FreshMailCampaignException($message, $code);
            default:
                throw new FreshMailException($message, $code);
        }
    }
}
