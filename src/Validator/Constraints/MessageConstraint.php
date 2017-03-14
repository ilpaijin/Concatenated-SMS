<?php

namespace Ilpaijin\Validator\Constraints;

/**
 * Class MessageConstraint
 * @package Ilpaijin\Validator
 */
class MessageConstraint
{
    /**
     * @param $value
     * @return bool
     */
    public function validateOriginator($value)
    {
        return is_string($value) && !empty($value) && strlen($value <= 11);
    }

    /**
     * @param $value
     * @return int
     */
    public function validateDirection($value)
    {
        return preg_match("(mt|mo)", $value);
    }

    /**
     * @param $value
     * @return int
     */
    public function validateDatacoding($value)
    {
        return preg_match("(unicode|plain)", $value);
    }
}