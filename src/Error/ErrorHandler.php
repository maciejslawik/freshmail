<?php
/**
 * File: ErrorHandler.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\FreshMail\Error;

use MSlwk\FreshMail\Exception\Authorization\FreshMailAuthorizationException;
use MSlwk\FreshMail\Exception\FreshMailException;

/**
 * Class ErrorHandler
 *
 * @package MSlwk\FreshMail\Error
 */
class ErrorHandler implements ErrorHandlerInterface
{

    public function raiseException(\stdClass $error)
    {
        $message = $error->message;
        $code = $error->code;

        switch ($code) {
            case $code >= 1000 && $code <= 1004:
                throw new FreshMailAuthorizationException($message, $code);
            default:
                throw new FreshMailException($message, $code);
        }
    }
}
