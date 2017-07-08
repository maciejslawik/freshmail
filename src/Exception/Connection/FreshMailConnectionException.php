<?php
/**
 * File: FreshMailConnectionException.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\FreshMail\Exception\Connection;

use MSlwk\FreshMail\Exception\FreshMailException;

/**
 * Class FreshMailConnectionException
 *
 * @package MSlwk\FreshMail\Exception\Connection
 */
class FreshMailConnectionException extends FreshMailException
{
    const EXCEPTION_MESSAGE = 'An error occured while connecting to the API';
}
