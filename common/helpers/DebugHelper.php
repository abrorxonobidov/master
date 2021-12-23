<?php
/**
 * Created by JetBrains PhpStorm.
 * User: a_niyazov
 * Date: 14.11.13
 * Time: 15:26
 * To change this template use File | Settings | File Templates.
 */

namespace common\helpers;

use yii\db\ActiveRecord;

/**
 * Class DebugHelper
 * @package common\helpers
 * @property $DEV_USERS
 * @property $DEV_IPS
 */
class DebugHelper
{
    const DEV_USERS = [1, 7, 9, 238];//Bu hozircha aniq emas
    const DEV_IPS = [
        '91.212.89.45', '195.158.3.102', '91.212.89.52','192.168.8.114', '192.168.7.201', '192.168.7.205'//Bu qismga hamma dasturchilar qo'shilmagan
    ];

    /**
     * @param $object
     * @param bool $die
     * @param boolean $pre
     * @param boolean $varDump
     */
    public static function printSingleObject($object, $die = false, $pre = true, $varDump = false)
    {
        if ($pre)
            echo "<pre>";
        if (!$varDump)
            print_r($object);
        else
            var_dump($object);
        if ($pre)
            echo "</pre>";
        if ($die) die;
    }

    /**
     * @param $objectsArray
     * @param bool $die
     */
    public static function printObjectsArray($objectsArray, $die = false)
    {
        echo "<pre>";
        foreach ($objectsArray as $object) {
            print_r($object);
        }
        echo "</pre>";
        if ($die) die;
    }

    /**
     * @param ActiveRecord $object
     * @param bool $die
     */
    public static function printActiveRecordsModel($object, $die = false)
    {
        echo "<pre>";
        print_r($object->getAttributes());
        echo "</pre>";
        if ($die) die;
    }

    /**
     * @param ActiveRecord[] $objectsArray
     * @param bool $die
     * @param bool $pre
     * @param bool $varDump
     */
    public static function printActiveRecordsArray($objectsArray, $die = false, $pre = true, $varDump = false)
    {
        if ($pre) echo "<pre>";
        foreach ($objectsArray as $object) {
            if (!$varDump) {
                print_r($object->attributes);
            } else
                var_dump($object->getAttributes());
        }
        if ($pre) echo "</pre>";
        if ($die) die;
    }

    /**
     * @param $text
     * @param bool $die
     */
    public static function printToSandBox($text, $die = false)
    {
        if (strpos($_SERVER["HTTP_HOST"], "dev")) {
            echo $text;
        } else {
            echo "";
        }
        if ($die) die;
    }

    /**
     * @param ActiveRecord | string $model
     * @param boolean $withHtmlList
     * @return string
     */
    public static function getModelErrorsText($model, $withHtmlList = true)
    {
        $message = '';
        foreach ($model->getErrors() as $attribute => $attributeErrors) {
            if ($withHtmlList)
                $message .= $model->getAttributeLabel($attribute) . ": " . "<ul><li>" . implode("</li>\n<li>", $attributeErrors) . "</li></ul><br>";
            else
                $message .= $model->getAttributeLabel($attribute) . ": " . "\n" . implode("\n", $attributeErrors) . "\n";
        }
        return $message;
    }

    public static function fromDeveloperIps()
    {
        $remote = isset($_SERVER["REMOTE_ADDR"]) ? $_SERVER["REMOTE_ADDR"] : '';
        return in_array($remote, self::DEV_IPS);
    }

    public static function fromCallCenterIps()
    {
        $remote = isset($_SERVER["REMOTE_ADDR"]) ? $_SERVER["REMOTE_ADDR"] : '';
        return in_array($remote, ['91.212.89.45', '195.158.3.102', '91.212.89.52']);
    }


}