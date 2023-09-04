<?php

/**
 * TextGenerator to generate some texts.
 * @author Bantayehu Fikadu <bantayehuf@gmail.com>
 * @package Lib\Utils
 */

namespace Lib\Utils;

class TextGenerator
{
    public static function generateNumber($length)
    {
        $codeAlphabet = "0123456789";

        return self::generate($codeAlphabet, $length);
    }

    public static function generateChar($length)
    {
        $codeAlphabet = "abcdefghijklmnopqrstuvwxyz";

        return self::generate($codeAlphabet, $length);
    }


    private static function generate($codeAlphabet, $length)
    {
        $token = "";

        $max = strlen($codeAlphabet) - 1;
        for ($i = 0; $i < $length; $i++) {
            $token .= $codeAlphabet[mt_rand(1, $max)];
        }
        return $token;
    }
}
