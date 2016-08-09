<?php

namespace DisputeSuite\Entities;

use Respect\Validation\Validator as v;

class Customer
{
    public static function isSupportedType($type)
    {
        return v::in('primary secondary')->validate($type);
    }
}