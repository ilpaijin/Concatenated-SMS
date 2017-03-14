<?php

namespace Ilpaijin\Exception;

use Exception;

/**
 * Class UnprocessableEntityException
 * @package Ilpaijin\Exception
 */
class UnprocessableEntityException extends Exception
{
    /**
     * UnprocessableEntityException constructor.
     * @param string $message
     * @param int $code
     * @param Exception|null $previous
     */
    function __construct($message = "Unprocessable Entity", $code = 422, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}