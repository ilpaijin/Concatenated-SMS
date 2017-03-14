<?php

namespace Ilpaijin\Validator;

/**
 * Class Validator
 * @package Ilpaijin\Validator
 */
class Validator
{
    public function validate($data, $constraint)
    {
        foreach ($data as $property => $value) {
            $method = "validate".ucfirst($property);

            if (!method_exists($constraint, $method)) {
                continue;
            }

            if(!$constraint->$method($value)) {
                return false;
            }
        }

        return true;
    }
}