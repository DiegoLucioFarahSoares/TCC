<?php

namespace app\src\classes\modules\exception;

use Exception;

class sicTreinamentosException extends Exception
{
    public function __construct($codigo, $value = '') {

        $messages = $this->getException();

        parent::__construct($messages($value)[$codigo], $codigo);
    }

    public function getException()
    {
        return function ($value) {
            return [
                1 => "A extenção do arquivo não é valida, tente importar em um destes formatos JPG, PNG.",
                2 => 'Não foi possível gravar os arquivos, tente novamente mais tarde!',
            ];
        };
    }
}