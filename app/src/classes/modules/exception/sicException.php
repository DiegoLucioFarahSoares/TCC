<?php

namespace app\src\classes\modules\exception;

use Exception;

class sicException extends Exception
{
    public function __construct($codigo, $value = '') {

        $messages = $this->getException();

        parent::__construct($messages($value)[$codigo], $codigo);
    }

    public function getException()
    {
        return function ($value) {
            return [
                1 => "Login obrigatório.",
                2 => "Senha obrigatório.",
                19 => "Atenção página não validada."
            ];
        };
    }
}