<?php
/**
 * File: FreshMailSubscriberException.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\FreshMail\Exception\Subscriber;

use MSlwk\FreshMail\Exception\FreshMailException;

/**
 * Class FreshMailSubscriberException
 *
 * @package MSlwk\FreshMail\Exception\Subscriber
 */
class FreshMailSubscriberException extends FreshMailException
{
    const EXCEPTION_MESSAGE = 'An error with the subscriber occurred';
}
