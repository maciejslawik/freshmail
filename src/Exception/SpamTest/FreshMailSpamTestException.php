<?php
/**
 * File: FreshMailSpamTestException.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\FreshMail\Exception\SpamTest;

use MSlwk\FreshMail\Exception\FreshMailException;

/**
 * Class FreshMailSpamTestException
 *
 * @package MSlwk\FreshMail\Exception\SpamTest
 */
class FreshMailSpamTestException extends FreshMailException
{
    const EXCEPTION_MESSAGE = 'An error occurred while spam-testing the message';
}
