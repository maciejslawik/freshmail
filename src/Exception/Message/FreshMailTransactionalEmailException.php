<?php
/**
 * File: FreshMailTransactionalEmailException.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\FreshMail\Exception\Message;

use MSlwk\FreshMail\Exception\FreshMailException;

/**
 * Class FreshMailTransactionalEmailException
 *
 * @package MSlwk\FreshMail\Exception\Message
 */
class FreshMailTransactionalEmailException extends FreshMailException
{
    const EXCEPTION_MESSAGE = 'An error occurred while sending the transactional email';
}
