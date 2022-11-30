<?php

namespace app\src\classes\modules\model;

class sicPessoaModel
{
    private $idPessoa;
    private $idNivelAcesso;
    private $login;
    private $senha;
    private $statusUsuario;
    private $img;
    private $dataCadastro;
    private $nomePessoa;
    private $cpf;
    private $rg;
    private $sexo;
    private $dataNascimento;
    private $idEstado;
    private $uf;
    private $idCidade;
    private $nomeCidade;
    private $codigoIbge;
    private $dddCidade;
    private $idRegiao;
    private $idPopulacao;
    private $logradouro;
    private $bairro;
    private $cep;
    private $numero;
    private $complemento;
    private $email;
    private $telefone;

    /**
     * @return mixed
     */
    public function getIdPessoa()
    {
        return $this->idPessoa;
    }

    /**
     * @param mixed $idPessoa
     */
    public function setIdPessoa($idPessoa): void
    {
        $this->idPessoa = $idPessoa;
    }

    /**
     * @return mixed
     */
    public function getIdNivelAcesso()
    {
        return $this->idNivelAcesso;
    }

    /**
     * @param mixed $idNivelAcesso
     */
    public function setIdNivelAcesso($idNivelAcesso): void
    {
        $this->idNivelAcesso = $idNivelAcesso;
    }

    /**
     * @return mixed
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * @param mixed $login
     */
    public function setLogin($login): void
    {
        $this->login = $login;
    }

    /**
     * @return mixed
     */
    public function getSenha()
    {
        return $this->senha;
    }

    /**
     * @param mixed $senha
     */
    public function setSenha($senha): void
    {
        $this->senha = $senha;
    }

    /**
     * @return mixed
     */
    public function getStatusUsuario()
    {
        return $this->statusUsuario;
    }

    /**
     * @param mixed $statusUsuario
     */
    public function setStatusUsuario($statusUsuario): void
    {
        $this->statusUsuario = $statusUsuario;
    }

    /**
     * @return mixed
     */
    public function getImg()
    {
        return $this->img;
    }

    /**
     * @param mixed $img
     */
    public function setImg($img): void
    {
        $this->img = $img;
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
    public function getNomePessoa()
    {
        return $this->nomePessoa;
    }

    /**
     * @param mixed $nomePessoa
     */
    public function setNomePessoa($nomePessoa): void
    {
        $this->nomePessoa = $nomePessoa;
    }

    /**
     * @return mixed
     */
    public function getCpf()
    {
        return $this->cpf;
    }

    /**
     * @param mixed $cpf
     */
    public function setCpf($cpf): void
    {
        $this->cpf = $cpf;
    }

    /**
     * @return mixed
     */
    public function getRg()
    {
        return $this->rg;
    }

    /**
     * @param mixed $rg
     */
    public function setRg($rg): void
    {
        $this->rg = $rg;
    }

    /**
     * @return mixed
     */
    public function getSexo()
    {
        return $this->sexo;
    }

    /**
     * @param mixed $sexo
     */
    public function setSexo($sexo): void
    {
        $this->sexo = $sexo;
    }

    /**
     * @return mixed
     */
    public function getDataNascimento()
    {
        return $this->dataNascimento;
    }

    /**
     * @param mixed $dataNascimento
     */
    public function setDataNascimento($dataNascimento): void
    {
        $this->dataNascimento = $dataNascimento;
    }

    /**
     * @return mixed
     */
    public function getIdEstado()
    {
        return $this->idEstado;
    }

    /**
     * @param mixed $idEstado
     */
    public function setIdEstado($idEstado): void
    {
        $this->idEstado = $idEstado;
    }

    /**
     * @return mixed
     */
    public function getUf()
    {
        return $this->uf;
    }

    /**
     * @param mixed $uf
     */
    public function setUf($uf): void
    {
        $this->uf = $uf;
    }

    /**
     * @return mixed
     */
    public function getIdCidade()
    {
        return $this->idCidade;
    }

    /**
     * @param mixed $idCidade
     */
    public function setIdCidade($idCidade): void
    {
        $this->idCidade = $idCidade;
    }

    /**
     * @return mixed
     */
    public function getNomeCidade()
    {
        return $this->nomeCidade;
    }

    /**
     * @param mixed $nomeCidade
     */
    public function setNomeCidade($nomeCidade): void
    {
        $this->nomeCidade = $nomeCidade;
    }

    /**
     * @return mixed
     */
    public function getCodigoIbge()
    {
        return $this->codigoIbge;
    }

    /**
     * @param mixed $codigoIbge
     */
    public function setCodigoIbge($codigoIbge): void
    {
        $this->codigoIbge = $codigoIbge;
    }

    /**
     * @return mixed
     */
    public function getDddCidade()
    {
        return $this->dddCidade;
    }

    /**
     * @param mixed $dddCidade
     */
    public function setDddCidade($dddCidade): void
    {
        $this->dddCidade = $dddCidade;
    }

    /**
     * @return mixed
     */
    public function getIdRegiao()
    {
        return $this->idRegiao;
    }

    /**
     * @param mixed $idRegiao
     */
    public function setIdRegiao($idRegiao): void
    {
        $this->idRegiao = $idRegiao;
    }

    /**
     * @return mixed
     */
    public function getIdPopulacao()
    {
        return $this->idPopulacao;
    }

    /**
     * @param mixed $idPopulacao
     */
    public function setIdPopulacao($idPopulacao): void
    {
        $this->idPopulacao = $idPopulacao;
    }

    /**
     * @return mixed
     */
    public function getLogradouro()
    {
        return $this->logradouro;
    }

    /**
     * @param mixed $logradouro
     */
    public function setLogradouro($logradouro): void
    {
        $this->logradouro = $logradouro;
    }

    /**
     * @return mixed
     */
    public function getBairro()
    {
        return $this->bairro;
    }

    /**
     * @param mixed $bairro
     */
    public function setBairro($bairro): void
    {
        $this->bairro = $bairro;
    }

    /**
     * @return mixed
     */
    public function getCep()
    {
        return $this->cep;
    }

    /**
     * @param mixed $cep
     */
    public function setCep($cep): void
    {
        $this->cep = $cep;
    }

    /**
     * @return mixed
     */
    public function getNumero()
    {
        return $this->numero;
    }

    /**
     * @param mixed $numero
     */
    public function setNumero($numero): void
    {
        $this->numero = $numero;
    }

    /**
     * @return mixed
     */
    public function getComplemento()
    {
        return $this->complemento;
    }

    /**
     * @param mixed $complemento
     */
    public function setComplemento($complemento): void
    {
        $this->complemento = $complemento;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email): void
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getTelefone()
    {
        return $this->telefone;
    }

    /**
     * @param mixed $telefone
     */
    public function setTelefone($telefone): void
    {
        $this->telefone = $telefone;
    }
}