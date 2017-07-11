<?php
/**
 * File: FreshMailSmsException.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\FreshMail\Exception\Message;

use MSlwk\FreshMail\Exception\FreshMailException;

/**
 * Class FreshMailSmsException
 *
 * @package MSlwk\FreshMail\Exception\Message
 */
class FreshMailSmsException extends FreshMailException
{
    const EXCEPTION_MESSAGE = 'An error occurred while sending the SMS';
}
