<?php

namespace App\Helpers;

class Input
{
    public static function clean($value = null)
    {
        if (empty($value)) {
            return null;
        }

        return htmlentities($value, ENT_QUOTES, 'UTF-8');
    }

    public static function bool($field = null)
    {
        if (is_null($field)) {
            return false;
        }

        if ((int) $field) {
            return true;
        }

        if ($field == 'on') {
            return true;
        }

        return false;
    }
}
