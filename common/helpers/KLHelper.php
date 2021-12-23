<?php
/**
 * Created by PhpStorm.
 * User: a_djuraev
 * Date: 18.10.17
 * Time: 10:40
 */

namespace common\helpers;


class KLHelper
{
    // ҳқў
    private static $symbols = [
        'Sh' => 'Ш',
        'Ch' => 'Ч',
        'Ya' => 'Я',
        'Yu' => 'Ю',
        'O`' => 'Ў',
        'O\'' => 'Ў',
        'G`' => 'Ғ',
        'G\'' => 'Ғ',
        'Sex' => 'Цех',

        'sh' => 'ш',
        'ch' => 'ч',
        'ya' => 'я',
        'yu' => 'ю',
        'o`' => 'ў',
        'o\'' => 'ў',
        'g`' => 'ғ',
        'g\'' => 'ғ',
        'sex' => 'цех',

        'a' => 'а',
        'b' => 'б',
        'd' => 'д',
        'e' => 'е',
        'f' => 'ф',
        'g' => 'г',
        'h' => 'ҳ',
        'i' => 'и',
        'j' => 'ж',
        'k' => 'к',
        'l' => 'л',
        'm' => 'м',
        'n' => 'н',
        'o' => 'о',
        'p' => 'п',
        'q' => 'қ', //-------------------------------
        'r' => 'р',
        's' => 'с',
        't' => 'т',
        'u' => 'у',
        'v' => 'в',
        'x' => 'х',
        'y' => 'й',
        'z' => 'з',
        //------------------------------------------

        'A' => 'А',
        'B' => 'Б',
        'D' => 'Д',
        'E' => 'Е',
        'F' => 'Ф',
        'G' => 'Г',
        'H' => 'Ҳ',
        'I' => 'И',
        'J' => 'Ж',
        'K' => 'К',
        'L' => 'Л',
        'M' => 'М',
        'N' => 'Н',
        'O' => 'О',
        'P' => 'П',
        'Q' => 'Қ', //-------------------------------
        'R' => 'Р',
        'S' => 'С',
        'T' => 'Т',
        'U' => 'У',
        'V' => 'В',
        'X' => 'Х',
        'Y' => 'Й',
        'Z' => 'З',
    ];

    public static function help($word){ // Latin to Kiril
        foreach (self::$symbols as $k=>$v)
            $word = str_replace($k,$v,$word);
        return $word;
    }

    public static function helpI($word){ // Kiril to Latin
        foreach (self::$symbols as $k=>$v)
            $word = str_replace($v,$k,$word);
        return $word;
    }

}