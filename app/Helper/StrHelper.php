<?php

namespace App\Helper;

class StrHelper
{
    //merubah camelcase ke underscore
    public static function camelCase2UnderScore($str, $separator = "_")
    {
        if (empty($str)) {
            return $str;
        }
        $str = lcfirst($str);
        $str = preg_replace("/[A-Z]/", $separator . "$0", $str);
        return strtolower($str);
    }

    // merubah string ke camelcase
    public static function camelize($str, $originSeparator = '_', $newSeparator = '')
    {
        return lcfirst(str_replace($originSeparator, $newSeparator, ucwords($str, $originSeparator)));
    }
}
