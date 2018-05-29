<?php

namespace JiraClient\Exception;

/**
 * Description of JiraException
 *
 * @author pbrasseur
 */
class JiraException extends \RuntimeException
{

    public function __construct($message = '', $previous = null)
    {
        parent::__construct($message, 0, $previous);
    }

}
