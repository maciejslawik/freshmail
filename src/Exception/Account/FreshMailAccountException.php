<?php
/**
 * File: FreshMailAccountException.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\FreshMail\Exception\Account;

use MSlwk\FreshMail\Exception\FreshMailException;

/**
 * Class FreshMailAccountException
 *
 * @package MSlwk\FreshMail\Exception\Account
 */
class FreshMailAccountException extends FreshMailException
{
    const EXCEPTION_MESSAGE = 'An error during account creation';
}
