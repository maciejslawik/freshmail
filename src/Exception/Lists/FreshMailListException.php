<?php
/**
 * File: FreshMailListException.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\FreshMail\Exception\Lists;

use MSlwk\FreshMail\Exception\FreshMailException;

/**
 * Class FreshMailListException
 *
 * @package MSlwk\FreshMail\Exception\Lists
 */
class FreshMailListException extends FreshMailException
{
    const EXCEPTION_MESSAGE = 'An error with the subscription list occurred';
}
