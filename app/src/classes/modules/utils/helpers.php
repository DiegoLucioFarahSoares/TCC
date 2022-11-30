<?php

namespace app\src\classes\modules\utils;

use DateTime;
use Exception;

class helpers
{

    public static function getSettingsApp()
    {

        $settings = require __DIR__ . "/../../../../src/settings.php";
        $settings = array_shift($settings);

        return $settings;
    }

    public static function exception($message, $code = 500){
        return array(
            'code' => $code,
            'status' => false,
            'message' => $message
        );
    }

    public static function convertUTF8($data) {

        if (is_array($data)) {

            $arrayConverted = array();

            foreach ($data as $key => $value) {
                $arrayConverted[$key] = self::convertUTF8($value);
            }

            return $arrayConverted;
        }
        else if(is_object($data)) {

            $arrayConverted = array();

            foreach ((array)$data as $key => $value) {
                $arrayConverted[$key] = self::convertUTF8($value);
            }

            return (object) $arrayConverted;
        }
        else {

            if (!mb_detect_encoding($data, 'UTF-8', true)) {
                return utf8_encode($data);
            }

            return $data;
        }
    }

    public static function validateDate($date, $format = 'Y-m-d') {
        try {

            $d = DateTime::createFromFormat($format, $date);
            return $d && $d->format($format) == $date;

        } catch (Exception $ex) { return false; }
    }

    public static function formatDate($data, $format = 'Y-m-d'){
        try {
            return (new DateTime($data))->format($format);
        }
        catch (Exception $x){
            return '';
        }
    }

    public static function converFormatDate($data, $formatEntrada = '', $formatSaida = ''){

        if($formatEntrada == '') $formatEntrada = 'd/m/Y';
        if($formatSaida == '') $formatSaida = 'Y-m-d';

        $d = DateTime::createFromFormat($formatEntrada, $data);

        if(!$d) return '';

        return $d->format($formatSaida);
    }
}