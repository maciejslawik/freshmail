<?php
/**
 * File: FreshMailCampaignException.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\FreshMail\Exception\Campaign;

use MSlwk\FreshMail\Exception\FreshMailException;

/**
 * Class CampaignException
 *
 * @package MSlwk\FreshMail\Exception\Campaign
 */
class FreshMailCampaignException extends FreshMailException
{
    const EXCEPTION_MESSAGE = 'An error with the campaign occurred';
}
