<?php
/**
 * File: FreshMailAuthorizationException.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\FreshMail\Exception\Authorization;

use MSlwk\FreshMail\Exception\FreshMailException;

class FreshMailAuthorizationException extends FreshMailException
{
    const EXCEPTION_MESSAGE = 'Api authorization failed';
}
