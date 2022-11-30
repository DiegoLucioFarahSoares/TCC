<?php

namespace app\src\classes\modules\service;

use app\src\classes\modules\strategy\enum\permissaoEnum;

class sicService
{

    public static function extensoesValidas($filename)
    {

        if(trim($filename) == "") {
            return false;
        }

        $pathinfo   = pathinfo($filename);
        $extensoesliberadas = ['jpg', 'gif', 'png', 'bmp', 'tiff', 'jpeg', 'doc', 'docx', 'pdf', 'xls', 'xlsx', 'xlsm', 'csv', 'xlt',
            'xml', 'ret', 'rem', 'txt', 'wav', 'mp3', 'mpg', 'wav', 'mp4', 'mpeg', 'amr', 'rar', 'zip', 'ogg', 'jfif', 'aac'];

        if(!in_array(strtolower($pathinfo['extension']), $extensoesliberadas)){
            return false;
        }

        return true;
    }

    public static function adminSIC()
    {
        session_start();

        $permissao = in_array($_SESSION['idNivelAcesso'], permissaoEnum::NIVEL_ADM);
        return ($permissao) ? true : false;
    }
}