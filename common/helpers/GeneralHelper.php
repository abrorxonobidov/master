<?php

namespace common\helpers;

use Yii;
use Faker\Provider\DateTime;
use yii\helpers\Json;

/**
 * Class GeneralHelper
 * @package common\helpers
 */
class GeneralHelper
{
    /**
     * @param int $length
     * @return string
     */
    public static function generatePassword($length = 8)
    {
        $alphabetU = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $alphabetS = 'abcdefghijklmnopqrstuvwxyz';
        $symbols = '$-_!@%&*#|';
        $pass = array(); //remember to declare $pass as an array
        $salphaLength = strlen($alphabetU) - 1; //put the length -1 in cache
        $ualphaLength = strlen($alphabetS) - 1; //put the length -1 in cache
        $nalphaLength = strlen($symbols) - 1; //put the length -1 in cache
        for ($i = 0; $i < 20; $i++) {
            $u = rand(0, $salphaLength);
            $s = rand(0, $ualphaLength);
            $n = rand(0, $nalphaLength);
            $pass[] = $alphabetU[$u];
            $pass[] = $alphabetS[$s];
            $pass[] = $symbols[$n];
        }
        $password = substr(implode($pass), 0, $length);

        return $password . rand(0, 99); //turn the array into a string
    }

    /**
     * @param $object
     * @return mixed
     */
    public static function object2Array($object)
    {
        return Json::decode(Json::encode($object));
    }

    /**
     * @param $string
     * @return bool
     */
    public static function isJSON($string)
    {
        return is_string($string) && is_array(json_decode($string, true)) && (json_last_error() == JSON_ERROR_NONE) ? true : false;
    }

    /**
     * @param $var
     * @param $validateTo
     * @return bool
     */
    public static function validateVar($var, $validateTo, $dateFormat = 'Y-m-d H:i:s', $dateTimeZone = 'Asia/Tashkent')
    {
        switch ($validateTo) {
            case 'int':
                if (is_int($var)) {
                    return true;
                } else {
                    return false;
                }
                break;
            case 'bool':
                if (is_bool($var)) {
                    return true;
                } else {
                    return false;
                }
                break;
            case 'array':
                if (is_array($var)) {
                    return true;
                } else {
                    return false;
                }
                break;
            case 'float':
                if (is_float($var)) {
                    return true;
                } else {
                    return false;
                }
                break;
            case 'guid':
                if (preg_match('/^[A-Za-z0-9]{8}-[A-Za-z0-9]{4}-[A-Za-z0-9]{4}-[A-Za-z0-9]{4}-[A-Za-z0-9]{12}$/', $var)) {
                    return true;
                } else {
                    return false;
                }
                break;
            case 'word':
                if (preg_match('/^[A-Za-z-_]+$/', $var)) {
                    return true;
                } else {
                    return false;
                }
                break;
            case 'wordWithNumbers':
                if (preg_match('/^[A-Za-z0-9-_]+$/', $var)) {
                    return true;
                } else {
                    return false;
                }
                break;
            case 'date':
            {
                if (($d = \DateTime::createFromFormat('Y-m-d', $var)) && $d->format('Y-m-d') === date('Y-m-d', strtotime($var)))
                    return true;
                elseif (($d = \DateTime::createFromFormat('Y.m.d', $var)) && $d->format('Y.m.d') === date('Y.m.d', strtotime($var)))
                    return true;
                elseif (($d = \DateTime::createFromFormat('d.m.Y', $var)) && $d->format('d.m.Y') === date('d.m.Y', strtotime($var)))
                    return true;
                return false;

            }
            case 'datetime':
            {
                $date = \DateTime::createFromFormat($dateFormat, $var, new \DateTimeZone($dateTimeZone));
                return $date && \DateTime::getLastErrors()['warning_count'] == 0 && \DateTime::getLastErrors()['error_count'] == 0;
            }
        }
    }

    //////////////////////////////////////////////////////////////////////
//PARA: Date Should In YYYY-MM-DD Format
//RESULT FORMAT:
// '%y Year %m Month %d Day %h Hours %i Minute %s Seconds'        =>  1 Year 3 Month 14 Day 11 Hours 49 Minute 36 Seconds
// '%y Year %m Month %d Day'                                    =>  1 Year 3 Month 14 Days
// '%m Month %d Day'                                            =>  3 Month 14 Day
// '%d Day %h Hours'                                            =>  14 Day 11 Hours
// '%d Day'                                                        =>  14 Days
// '%h Hours %i Minute %s Seconds'                                =>  11 Hours 49 Minute 36 Seconds
// '%i Minute %s Seconds'                                        =>  49 Minute 36 Seconds
// '%h Hours                                                    =>  11 Hours
// '%a Days                                                        =>  468 Days
//////////////////////////////////////////////////////////////////////
    /**
     * @param $date_1
     * @param $date_2
     * @param string $differenceFormat
     * @return string
     */
    public static function dateDifference($date_1, $date_2, $differenceFormat = '%a')
    {
        $datetime1 = date_create($date_1);
        $datetime2 = date_create($date_2);

        $interval = date_diff($datetime1, $datetime2);

        return $interval->format($differenceFormat);

    }

    /**
     * Formats a JSON string for pretty printing
     *
     * @param string $json The JSON to make pretty
     * @param bool $html Insert nonbreaking spaces and <br />s for tabs and linebreaks
     * @return string The prettified output
     */
    public static function jsonPrettyPrint($json, $html = true)
    {
        $tabcount = 0;
        $result = '';
        $inquote = false;
        $ignorenext = false;
        if ($html) {
            $tab = "&nbsp;&nbsp;&nbsp;&nbsp;";
            $newline = "<br/>";
        } else {
            $tab = "\t";
            $newline = "\n";
        }
        for ($i = 0; $i < strlen($json); $i++) {
            $char = $json[$i];
            if ($ignorenext) {
                $result .= $char;
                $ignorenext = false;
            } else {
                switch ($char) {
                    case '[':
                    case '{':
                        $tabcount++;
                        $result .= $char . $newline . str_repeat($tab, $tabcount);
                        break;
                    case ']':
                    case '}':
                        $tabcount--;
                        $result = trim($result) . $newline . str_repeat($tab, $tabcount) . $char;
                        break;
                    case ',':
                        $result .= $char . $newline . str_repeat($tab, $tabcount);
                        break;
                    case '"':
                        $inquote = !$inquote;
                        $result .= $char;
                        break;
                    case '\\':
                        if ($inquote) $ignorenext = true;
                        $result .= $char;
                        break;
                    default:
                        $result .= $char;
                }
            }
        }
        return $result;
    }

    public static function get_user_ip()
    {
        if (getenv('REMOTE_ADDR')) $user_ip = getenv('REMOTE_ADDR');
        elseif (getenv('HTTP_FORWARDED_FOR')) $user_ip = getenv('HTTP_FORWARDED_FOR');
        elseif (getenv('HTTP_X_FORWARDED_FOR')) $user_ip = getenv('HTTP_X_FORWARDED_FOR');
        elseif (getenv('HTTP_X_COMING_FROM')) $user_ip = getenv('HTTP_X_COMING_FROM');
        elseif (getenv('HTTP_VIA')) $user_ip = getenv('HTTP_VIA');
        elseif (getenv('HTTP_XROXY_CONNECTION')) $user_ip = getenv('HTTP_XROXY_CONNECTION');
        elseif (getenv('HTTP_CLIENT_IP')) $user_ip = getenv('HTTP_CLIENT_IP');
        $user_ip = trim(@$user_ip);
        if (empty($user_ip)) return false;
        if (!preg_match("/^([1-9]|[1-9][0-9]|1[0-9][0-9]|2[0-4][0-9]|25[0-5])(\.([0-9]|[1-9][0-9]|1[0-9][0-9]|2[0-4][0-9]|25[0-5])){3}$/", $user_ip)) return false;
        return $user_ip;
    }

    public static function getTables($with_column_name = 'section_id')
    {
        $tableNames = \Yii::$app->db->createCommand("
        select
            t.table_name,
            COALESCE(obj_description(pgc.oid),t.table_name) AS comment
        from information_schema.tables t
        inner join information_schema.columns c on c.table_name = t.table_name
        inner join pg_catalog.pg_class pgc on pgc.relname = t.table_name and c.table_schema = t.table_schema
        where c.column_name = :column_name
            AND t.table_schema = 'public'
            AND c.column_default is not null
            and t.table_schema not in ('information_schema', 'pg_catalog')
            and t.table_type = 'BASE TABLE'
        order by t.table_schema", [":column_name" => $with_column_name])
            ->queryAll();
        return $tableNames;
    }

    public static function getTableColumns($table_name, $forDepDrop = false)
    {
        $selectPart = "cols.table_name,   
            cols.column_name,    
            data_type,
            (case
                when character_maximum_length is not null
                    then character_maximum_length
                else numeric_precision 
            end) as max_length,
            column_default                 as default_value,       
            COALESCE(
                (SELECT
                    pg_catalog.col_description(c.oid, cols.ordinal_position::int)
                FROM pg_catalog.pg_class c
                WHERE
                        c.oid     = (SELECT cols.table_name::regclass::oid) AND
                        c.relname = cols.table_name)
            ,cols.column_name) as column_comment,
            ordinal_position as position";
        if ($forDepDrop === true)
            $selectPart = "cols.column_name AS id, 
            COALESCE(
            (SELECT
                    pg_catalog.col_description(c.oid, cols.ordinal_position::int)
                FROM pg_catalog.pg_class c
                WHERE
                        c.oid     = (SELECT cols.table_name::regclass::oid) AND
                        c.relname = cols.table_name
            ),cols.column_name) as name";
        $tableNames = \Yii::$app->db->createCommand("
        SELECT 
              $selectPart  
        FROM information_schema.columns cols
        WHERE
            cols.table_schema  = 'public' AND
            cols.table_name    = :tableName", [':tableName' => $table_name])
            ->queryAll();
        return $tableNames;
    }

   public static function hasTableColumn($table_name, $column_name)
    {
        $selectPart = "cols.table_name,   
            cols.column_name,    
            data_type,
            (case
                when character_maximum_length is not null
                    then character_maximum_length
                else numeric_precision 
            end) as max_length,
            column_default                 as default_value,       
            COALESCE(
                (SELECT
                    pg_catalog.col_description(c.oid, cols.ordinal_position::int)
                FROM pg_catalog.pg_class c
                WHERE
                        c.oid     = (SELECT cols.table_name::regclass::oid) AND
                        c.relname = cols.table_name)
            ,cols.column_name) as column_comment,
            ordinal_position as position";
        $result = \Yii::$app->db->createCommand("
        SELECT 
              $selectPart  
        FROM information_schema.columns cols
        WHERE
            cols.table_schema  = 'public' AND
            cols.table_name    = :tableName AND
            cols.column_name    = :columnName", [':tableName' => $table_name, ':columnName' => $column_name])
            ->queryOne();
        return $result;
    }

    public static function array_diff_assoc_recursive($array1, $array2)
    {
        $difference = array();
        foreach ($array1 as $key => $value) {
            if (is_array($value)) {
                if (!array_key_exists($key, $array2) || !is_array($array2[$key])) {
                    $difference[$key] = $value;
                } else {
                    $new_diff = self::array_diff_assoc_recursive($value, $array2[$key]);
                    if (!empty($new_diff))
                        $difference[$key] = $new_diff;
                }
            } else if (!array_key_exists($key, $array2) || $array2[$key] != $value) {
                $difference[$key] = $value;
            }
        }
        return $difference;
    }
}