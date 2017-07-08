<?php
/**
 * File: ErrorHandlerInterface.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\FreshMail\Error;

/**
 * Interface ErrorHandlerInterface
 *
 * @package MSlwk\FreshMail\Error
 */
interface ErrorHandlerInterface
{
    /**
     * @param \stdClass $error
     * @return mixed
     */
    public function raiseException(\stdClass $error);
}
