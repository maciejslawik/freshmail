<?php
/**
 * File: FreshMailException.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\FreshMail\Exception;

use Throwable;

/**
 * Class FreshMailException
 *
 * @package MSlwk\FreshMail\Exception
 */
class FreshMailException extends \Exception
{
    const EXCEPTION_MESSAGE = 'FreshMail exception';

    /**
     * FreshMailException constructor.
     *
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct($message = '', $code = 0, Throwable $previous = null)
    {
        if (!$message) {
            $message = $this->getDefaultMessage();
        }
        parent::__construct($message, $code, $previous);
    }

    /**
     * @return string
     */
    protected function getDefaultMessage(): string
    {
        return static::EXCEPTION_MESSAGE;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return 'Message: ' . $this->getMessage() . '. Code: ' . $this->getCode();
    }
}
