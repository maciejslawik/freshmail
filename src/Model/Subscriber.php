<?php
/**
 * File: Subscriber.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\FreshMail\Model;

/**
 * Class Subscriber
 *
 * @package MSlwk\FreshMail\Model
 */
class Subscriber
{
    const STATUS_ACTIVE = 1;
    const STATUS_TO_ACTIVATE = 2;
    const STATUS_INACTIVE = 3;
    const STATUS_UNSUBSCRIBED = 4;
    const STATUS_SOFT_BOUNCE = 5;
    const STATUS_HARD_BOUNCE = 8;
}
