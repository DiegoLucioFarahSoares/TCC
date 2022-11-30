<?php

namespace app\src\classes\modules\model;

class sicMidiasModel
{

    private $idMidias;
    private $idCursos;
    private $nome;
    private $url;
    private $arquivo;
    private $dataCadastro;
    private $status;

    /**
     * @return mixed
     */
    public function getIdMidias()
    {
        return $this->idMidias;
    }

    /**
     * @param mixed $idMidias
     */
    public function setIdMidias($idMidias): void
    {
        $this->idMidias = $idMidias;
    }

    /**
     * @return mixed
     */
    public function getIdCursos()
    {
        return $this->idCursos;
    }

    /**
     * @param mixed $idCursos
     */
    public function setIdCursos($idCursos): void
    {
        $this->idCursos = $idCursos;
    }

    /**
     * @return mixed
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * @param mixed $nome
     */
    public function setNome($nome): void
    {
        $this->nome = $nome;
    }

    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param mixed $url
     */
    public function setUrl($url): void
    {
        $this->url = $url;
    }

    /**
     * @return mixed
     */
    public function getArquivo()
    {
        return $this->arquivo;
    }

    /**
     * @param mixed $arquivo
     */
    public function setArquivo($arquivo): void
    {
        $this->arquivo = $arquivo;
    }

    /**
     * @return mixed
     */
    public function getDataCadastro()
    {
        return $this->dataCadastro;
    }

    /**
     * @param mixed $dataCadastro
     */
    public function setDataCadastro($dataCadastro): void
    {
        $this->dataCadastro = $dataCadastro;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status): void
    {
        $this->status = $status;
    }
}