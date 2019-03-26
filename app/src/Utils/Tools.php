<?php
namespace App\Utils;

/**
 * Class Tools: kit tools
 * @package App\Utils
 */
class Tools
{
    //200
    public const X_NUMBERS = 3;
    public const X_LETTERS = 10;

    public function shuffleNumbers(int $x = self::X_NUMBERS) : int {
        return substr(str_shuffle("0123456789"), 0, $x);
    }


    public function shuffleAlphabets(int $x = self::X_LETTERS) : string {
        return trim(substr(str_shuffle(" qwertyu iopas dfgh jklzxcvbnm QWERTYUIO PA SDFGHJ KLZXCVBNM"), 0, $x));
    }
}