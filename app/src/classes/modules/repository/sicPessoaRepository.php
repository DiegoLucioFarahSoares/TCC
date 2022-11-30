<?php

namespace app\src\classes\modules\repository;

use app\src\classes\modules\model\sicPessoaModel;
use PDO;
use PDOException;
use PDOStatement;

require_once __DIR__ . "/../config/ConnectionPdo.php";

class sicPessoaRepository
{

    const ERROR = 'Ocorreu um erro e não foi possível completar a operação.';

    private $db;

    /**
     * @param PDO $db
     */
    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    /**
     * Consultar
     * @param $params
     * @return array|false
     */
    public function consultar($params) {

        try {

            $conn = $this->db;

            $stmt = $conn->prepare("SET SESSION sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''));");
            $stmt->execute();

            $sql = "SELECT 
                        DATE_FORMAT(p.dataCadastro, '%d/%m/%Y %H:%i') AS dataCadastro,
                        u.login,
                        u.idNivelAcesso,
                        u.status,
                        p.idPessoa,
                        pf.nome,
                        pf.cpf,
                        pf.rg,
                        pf.sexo,
                        DATE_FORMAT(pf.dataNascimento, '%d/%m/%Y') AS dataNascimento,
                        n.nome AS nivel,
                        email.email,
                        t.numero AS telefone,
                        CONCAT(e.uf, ' - ', e.nome) AS estado,
                        c.idCidade AS idCidade,
                        c.idEstado,
                        c.nome AS cidade,
                        end.logradouro,
                        end.bairro,
                        end.cep,
                        end.numero,
                        end.complemento
                    FROM
                        sicoficial_bd.Usuario u
                            LEFT JOIN
                        sicoficial_bd.Pessoa p ON (p.idPessoa = u.idPessoa)
                            LEFT JOIN
                        sicoficial_bd.PessoaFisica pf ON (pf.idPessoa = p.idPessoa)
                            LEFT JOIN
                        sicoficial_bd.Endereco end ON (end.idPessoa = p.idPessoa)
                            LEFT JOIN
                        sicoficial_bd.Estado e ON (e.idEstado = pf.idEstado)
                            LEFT JOIN
                        sicoficial_bd.Cidade c ON (c.idEstado = e.idEstado)
                            LEFT JOIN
                        sicoficial_bd.NivelAcesso n ON (n.idNivelAcesso = u.idNivelAcesso)
                            LEFT JOIN
                        sicoficial_bd.Email email ON (email.idPessoa = p.idPessoa)
                            LEFT JOIN
                        sicoficial_bd.Telefone t ON (t.idPessoa = email.idPessoa)
                    WHERE
                        1
                    {$this->setCriterio($params)}
                    GROUP BY p.idPessoa
                    ORDER BY p.dataCadastro DESC;";

            $stmt = $conn->prepare($sql);
            $this->setBindValue($stmt, $params);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            throw new $e(self::ERROR);
        }
    }

    /**
     * setCriterio()
     * @param $params
     * @return string
     */
    private function setCriterio($params)
    {
        try {

            $criterio = '';

            if ($params['periodo'] != '') {
                $periodo = explode('-', $params['periodo']);
                $criterio .= count($periodo) > 0 ? " AND date(p.dataCadastro) BETWEEN :datai AND :dataf" : "";
            }

            if ($params['nome'] != '' && !empty($params['nome'])) {
                $nome = $params['nome'];
                $criterio .= isset($params['nome']) ? " AND pf.nome like '%{$nome}%' " : "";
            }

            if ($params['idPessoa'] != '' && !empty($params['idPessoa'])) {
                $criterio .= isset($params['idPessoa']) ? " AND p.idPessoa =  :idPessoa" : "";
            }

            return $criterio;

        } catch (PDOException $e) {
            throw new $e(self::ERROR);
        }
    }

    /**
     * setBindValue()
     * @param PDOStatement $stmt
     * @param $params
     * @return void
     */
    private function setBindValue(PDOStatement $stmt, $params)
    {

        if ($params['periodo'] != '') {
            $periodo = array_map('trim', explode('-', $params['periodo']));
            if (isset($periodo[0])) {
                $stmt->bindValue(":datai", date('Y-m-d', strtotime(str_replace("/", '-', $periodo[0]))), PDO::PARAM_STR);
            }

            if (isset($periodo[1])) {
                $stmt->bindValue(":dataf", date('Y-m-d', strtotime(str_replace("/", '-', $periodo[1]))), PDO::PARAM_STR);
            }
        }

        if (isset($params['nome']) && !empty($params['nome'])) {
            $stmt->bindValue(":nome", $params['nome'], PDO::PARAM_STR);
        }

        if (isset($params['idPessoa']) && !empty($params['idPessoa'])) {
            $stmt->bindValue(":idPessoa", $params['idPessoa'], PDO::PARAM_INT);
        }
    }

    /**
     * Salvar pessoa
     * @return false|string
     */
    public function salvarPessoa() {

        try {

            $conn = $this->db;

            $sql = "INSERT INTO
                        sicoficial_bd.Pessoa (dataCadastro)
                    VALUES
                        (now())";

            $stmt = $conn->prepare($sql);
            if($stmt->execute()){
                return $conn->lastInsertId();
            }

            return false;

        } catch (PDOException $e) {
            throw new $e(self::ERROR);
        }
    }

    /**
     * Salvar usuário
     * @param sicPessoaModel $pessoa
     * @return false|string
     */
    public function salvarUsuario(sicPessoaModel $pessoa) {

        try {

            $conn = $this->db;

            $sql = "INSERT INTO
                        sicoficial_bd.Usuario (idPessoa, idNivelAcesso, login, senha, img, status)
                    VALUES
                        (:idPessoa, :idNivelAcesso, :login, :senha, :img, 1)";

            $stmt = $conn->prepare($sql);

            $stmt->bindValue(":idPessoa", $pessoa->getIdPessoa(), PDO::PARAM_INT);
            $stmt->bindValue(":idNivelAcesso", $pessoa->getIdNivelAcesso(), PDO::PARAM_INT);
            $stmt->bindValue(":login", $pessoa->getLogin(), PDO::PARAM_STR);
            $stmt->bindValue(":senha", $pessoa->getSenha(), PDO::PARAM_STR);
            $stmt->bindValue(":img", $pessoa->getImg(), PDO::PARAM_STR);

            if($stmt->execute()){
                return $conn->lastInsertId();
            }

            return false;

        } catch (PDOException $e) {
            throw new $e(self::ERROR);
        }
    }

    /**
     * Salvar pessoa física
     * @param sicPessoaModel $pessoa
     * @return false|string
     */
    public function salvarPessoaFisica(sicPessoaModel $pessoa)
    {

        try {

            $conn = $this->db;

            $sql = "INSERT INTO
                        sicoficial_bd.PessoaFisica (idPessoa, idEstado, nome, cpf, rg, sexo, dataNascimento)
                    VALUES
                        (:idPessoa, :idEstado, :nome, :cpf, :rg, :sexo, :dataNascimento)";

            $stmt = $conn->prepare($sql);

            $stmt->bindValue(":idPessoa", $pessoa->getIdPessoa(), PDO::PARAM_INT);
            $stmt->bindValue(":idEstado", $pessoa->getIdEstado(), PDO::PARAM_INT);
            $stmt->bindValue(":nome", $pessoa->getNomePessoa(), PDO::PARAM_STR);
            $stmt->bindValue(":cpf", $pessoa->getCpf(), PDO::PARAM_STR);
            $stmt->bindValue(":rg", $pessoa->getRg(), PDO::PARAM_STR);
            $stmt->bindValue(":sexo", $pessoa->getSexo(), PDO::PARAM_STR);
            $stmt->bindValue(":dataNascimento", $pessoa->getDataNascimento(), PDO::PARAM_STR);

            if ($stmt->execute()) {
                return $conn->lastInsertId();
            }

            return false;

        } catch (PDOException $e) {
            throw new $e(self::ERROR);
        }
    }

    /**
     * Salvar endereço
     * @param sicPessoaModel $pessoa
     * @return false|string
     */
    public function salvarEndereco(sicPessoaModel $pessoa)
    {

        try {

            $conn = $this->db;

            $sql = "INSERT INTO
                        sicoficial_bd.Endereco (idCidade, idPessoa, logradouro, bairro, cep, numero, complemento)
                    VALUES
                        (:idCidade, :idPessoa, :logradouro, :bairro, :cep, :numero, :complemento)";

            $stmt = $conn->prepare($sql);

            $stmt->bindValue(":idCidade", $pessoa->getIdCidade(), PDO::PARAM_INT);
            $stmt->bindValue(":idPessoa", $pessoa->getIdPessoa(), PDO::PARAM_INT);
            $stmt->bindValue(":logradouro", $pessoa->getLogradouro(), PDO::PARAM_STR);
            $stmt->bindValue(":bairro", $pessoa->getBairro(), PDO::PARAM_STR);
            $stmt->bindValue(":cep", $pessoa->getCep(), PDO::PARAM_STR);
            $stmt->bindValue(":numero", $pessoa->getNumero(), PDO::PARAM_INT);
            $stmt->bindValue(":complemento", $pessoa->getComplemento(), PDO::PARAM_STR);

            if ($stmt->execute()) {
                return $conn->lastInsertId();
            }

            return false;

        } catch (PDOException $e) {
            throw new $e(self::ERROR);
        }
    }

    /**
     * Salvar email
     * @param sicPessoaModel $pessoa
     * @return false|string
     */
    public function salvarEmail(sicPessoaModel $pessoa)
    {

        try {

            $conn = $this->db;

            $sql = "INSERT INTO
                        sicoficial_bd.Email (idPessoa, email, status)
                    VALUES
                        (:idPessoa, :email, 1)";

            $stmt = $conn->prepare($sql);

            $stmt->bindValue(":idPessoa", $pessoa->getIdPessoa(), PDO::PARAM_INT);
            $stmt->bindValue(":email", $pessoa->getEmail(), PDO::PARAM_STR);

            if ($stmt->execute()) {
                return $conn->lastInsertId();
            }

            return false;

        } catch (PDOException $e) {
            throw new $e(self::ERROR);
        }
    }

    /**
     * Salvar telefone
     * @param sicPessoaModel $pessoa
     * @return false|string
     */
    public function salvarTelefone(sicPessoaModel $pessoa)
    {

        try {

            $conn = $this->db;

            $sql = "INSERT INTO
                        sicoficial_bd.Telefone (idPessoa, numero, dataCadastro, status)
                    VALUES
                        (:idPessoa, :numero, :dataCadastro, 1)";

            $stmt = $conn->prepare($sql);

            $stmt->bindValue(":idPessoa", $pessoa->getIdPessoa(), PDO::PARAM_INT);
            $stmt->bindValue(":numero", $pessoa->getTelefone(), PDO::PARAM_STR);
            $stmt->bindValue(":dataCadastro", $pessoa->getDataCadastro(), PDO::PARAM_STR);

            if ($stmt->execute()) {
                return $conn->lastInsertId();
            }

            return false;

        } catch (PDOException $e) {
            throw new $e(self::ERROR);
        }
    }

    /**
     * Busca nivel de acesso
     * @return array|false
     */
    public function getNivelAcesso() {

        try {

            $conn = $this->db;

            $sql = "SELECT 
                        idNivelAcesso AS codigo,
                        nome
                    FROM
                        sicoficial_bd.NivelAcesso;";

            $stmt = $conn->prepare($sql);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            throw new $e(self::ERROR);
        }
    }

    /**
     * Busca cidades por estado
     * @param $params
     * @return array|false
     */
    public function getCidadesPorEstado($params) {

        try {

            $conn = $this->db;

            $sql = "SELECT
                        c.idCidade as codigo, 
                        c.nome
                    FROM
                        sicoficial_bd.Cidade c
                            LEFT JOIN
                        sicoficial_bd.Estado e ON (e.idEstado = c.idEstado)
                    WHERE
                        e.uf = :idEstado;";

            $stmt = $conn->prepare($sql);
            $stmt->bindValue(":idEstado", $params['idEstado'],PDO::PARAM_STR);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            throw new $e(self::ERROR);
        }
    }

//    /**
//     * Obter estado
//     * @param $params
//     * @return mixed
//     */
//    public function obterEstado($params) {
//
//        try {
//
//            $conn = $this->db;
//
//            $sql = "select
//                        idEstado,
//                        uf,
//                        nome
//                    from
//                        sicoficial_bd.Estado
//                    where
//                        idEstado = :idEstado";
//
//            $stmt = $conn->prepare($sql);
//            $stmt->bindValue(":idEstado", $params['idEstado'], PDO::PARAM_INT);
//            $stmt->execute();
//            return  $stmt->fetch(PDO::FETCH_ASSOC);
//        }
//        catch (PDOException $e){
//            throw new $e(self::ERROR);
//        }
//    }

    /**
     * Obter cidade pelo ibge
     * @param $ibge
     * @return mixed
     */
    public function obterCidadePeloIbge($ibge) {

        try {

            $conn = $this->db;

            $sql = "select 
                        idCidade, 
                        upper(nome) as nome, 
                        codigoIbge, 
                        ddd, 
                        idEstado, 
                        idRegiao, 
                        idPopulacao 
                    from 
                        sicoficial_bd.Cidade 
                    where 
                        codigoIbge = :codigoIbge";

            $stmt = $conn->prepare($sql);
            $stmt->bindValue(":codigoIbge", $ibge, PDO::PARAM_INT);
            $stmt->execute();
            return  $stmt->fetch(PDO::FETCH_ASSOC);
        }
        catch (PDOException $e){
            throw new $e(self::ERROR);
        }
    }

    /**
     * Editar pessoa
     * @param sicPessoaModel $pessoa
     * @return false|string
     */
    public function editarPessoa(sicPessoaModel $pessoa) {

        try {

            $conn = $this->db;

            $sql = "UPDATE
                        sicoficial_bd.Pessoa
                    SET
                        datacadastro = now()
                    WHERE
                        idPessoa = :idPessoa;";

            $stmt = $conn->prepare($sql);

            $stmt->bindValue(":idPessoa", $pessoa->getIdPessoa(), PDO::PARAM_INT);

            $stmt->execute();

        } catch (PDOException $e) {
            throw new $e(self::ERROR);
        }
    }

    /**
     * Editar usuário
     * @param sicPessoaModel $pessoa
     * @return false|string
     */
    public function editarUsuario(sicPessoaModel $pessoa) {

        try {

            $conn = $this->db;

            $sql = "UPDATE
                        sicoficial_bd.Usuario
                    SET
                        idPessoa = :idPessoa, 
                        idNivelAcesso = :idNivelAcesso, 
                        login = :login, 
                        img = :img, 
                        status = 1
                    WHERE
                        idPessoa = :idPessoa;";

            $stmt = $conn->prepare($sql);

            $stmt->bindValue(":idPessoa", $pessoa->getIdPessoa(), PDO::PARAM_INT);
            $stmt->bindValue(":idNivelAcesso", $pessoa->getIdNivelAcesso(), PDO::PARAM_INT);
            $stmt->bindValue(":login", $pessoa->getLogin(), PDO::PARAM_STR);
            $stmt->bindValue(":img", $pessoa->getImg(), PDO::PARAM_STR);

            if($stmt->execute()){
                return $this->editarPessoa($pessoa);
            }

            return false;

        } catch (PDOException $e) {
            throw new $e(self::ERROR);
        }
    }

    /**
     * Editar pessoa física
     * @param sicPessoaModel $pessoa
     * @return false|string
     */
    public function editarPessoaFisica(sicPessoaModel $pessoa)
    {

        try {

            $conn = $this->db;

            $sql = "UPDATE
                        sicoficial_bd.PessoaFisica
                    SET
                        idPessoa = :idPessoa, 
                        idEstado = :idEstado, 
                        nome = :nome, 
                        cpf = :cpf, 
                        rg = :rg, 
                        sexo = :sexo,
                        dataNascimento = :dataNascimento
                    WHERE
                        idPessoa = :idPessoa;";

            $stmt = $conn->prepare($sql);

            $stmt->bindValue(":idPessoa", $pessoa->getIdPessoa(), PDO::PARAM_INT);
            $stmt->bindValue(":idEstado", $pessoa->getIdEstado(), PDO::PARAM_INT);
            $stmt->bindValue(":nome", $pessoa->getNomePessoa(), PDO::PARAM_STR);
            $stmt->bindValue(":cpf", $pessoa->getCpf(), PDO::PARAM_STR);
            $stmt->bindValue(":rg", $pessoa->getRg(), PDO::PARAM_STR);
            $stmt->bindValue(":sexo", $pessoa->getSexo(), PDO::PARAM_STR);
            $stmt->bindValue(":dataNascimento", $pessoa->getDataNascimento(), PDO::PARAM_STR);

            if($stmt->execute()){
                return $this->editarUsuario($pessoa);
            }

            return false;

        } catch (PDOException $e) {
            throw new $e(self::ERROR);
        }
    }

    /**
     * Editar endereço
     * @param sicPessoaModel $pessoa
     * @return false|string
     */
    public function editarEndereco(sicPessoaModel $pessoa)
    {

        try {

            $conn = $this->db;

            $sql = "UPDATE
                        sicoficial_bd.Endereco
                    SET
                        idPessoa = :idPessoa, 
                        idCidade = :idCidade, 
                        logradouro = :logradouro, 
                        bairro = :bairro, 
                        cep = :cep, 
                        numero = :numero,
                        complemento = :complemento
                    WHERE
                        idPessoa = :idPessoa;";

            $stmt = $conn->prepare($sql);

            $stmt->bindValue(":idCidade", $pessoa->getIdCidade(), PDO::PARAM_INT);
            $stmt->bindValue(":idPessoa", $pessoa->getIdPessoa(), PDO::PARAM_INT);
            $stmt->bindValue(":logradouro", $pessoa->getLogradouro(), PDO::PARAM_STR);
            $stmt->bindValue(":bairro", $pessoa->getBairro(), PDO::PARAM_STR);
            $stmt->bindValue(":cep", $pessoa->getCep(), PDO::PARAM_STR);
            $stmt->bindValue(":numero", $pessoa->getNumero(), PDO::PARAM_INT);
            $stmt->bindValue(":complemento", $pessoa->getComplemento(), PDO::PARAM_STR);

            if($stmt->execute()){
                return $this->editarPessoaFisica($pessoa);
            }

            return false;

        } catch (PDOException $e) {
            throw new $e(self::ERROR);
        }
    }

    /**
     * Editar email
     * @param sicPessoaModel $pessoa
     * @return false|string
     */
    public function editarEmail(sicPessoaModel $pessoa)
    {

        try {

            $conn = $this->db;

            $sql = "UPDATE
                        sicoficial_bd.Email
                    SET
                        idPessoa = :idPessoa, 
                        email = :email, 
                        status = 1
                    WHERE
                        idPessoa = :idPessoa;";

            $stmt = $conn->prepare($sql);

            $stmt->bindValue(":idPessoa", $pessoa->getIdPessoa(), PDO::PARAM_INT);
            $stmt->bindValue(":email", $pessoa->getEmail(), PDO::PARAM_STR);

            if($stmt->execute()){
                return $this->editarTelefone($pessoa);
            }

            return false;

        } catch (PDOException $e) {
            throw new $e(self::ERROR);
        }
    }

    /**
     * Editar telefone
     * @param sicPessoaModel $pessoa
     * @return false|string
     */
    public function editarTelefone(sicPessoaModel $pessoa)
    {

        try {

            $conn = $this->db;

            $sql = "UPDATE
                        sicoficial_bd.Telefone
                    SET
                        idPessoa = :idPessoa, 
                        numero = :numero, 
                        dataCadastro = :dataCadastro,
                        status = 1
                    WHERE
                        idPessoa = :idPessoa;";

            $stmt = $conn->prepare($sql);

            $stmt->bindValue(":idPessoa", $pessoa->getIdPessoa(), PDO::PARAM_INT);
            $stmt->bindValue(":numero", $pessoa->getTelefone(), PDO::PARAM_STR);
            $stmt->bindValue(":dataCadastro", $pessoa->getDataCadastro(), PDO::PARAM_STR);

            if($stmt->execute()){
                return $this->editarEndereco($pessoa);
            }

            return false;

        } catch (PDOException $e) {
            throw new $e(self::ERROR);
        }
    }

    /**
     * Excluir
     * @param sicPessoaModel $pessoa
     * @return bool
     */
    public function excluir(sicPessoaModel $pessoa) {

        try {

            $conn = $this->db;

            $sql = "DELETE FROM
                        sicoficial_bd.Email
                    WHERE
                        idPessoa = :idPessoa;";

            $stmt = $conn->prepare($sql);
            $stmt->bindValue(":idPessoa", $pessoa->getIdPessoa(), PDO::PARAM_INT);

            if($stmt->execute()){

                $sql = "DELETE FROM
                            sicoficial_bd.Telefone
                        WHERE
                            idPessoa = :idPessoa;";

                $stmt = $conn->prepare($sql);
                $stmt->bindValue(":idPessoa", $pessoa->getIdPessoa(), PDO::PARAM_INT);

                if($stmt->execute()){

                    $sql = "DELETE FROM
                            sicoficial_bd.Endereco
                        WHERE
                            idPessoa = :idPessoa;";

                    $stmt = $conn->prepare($sql);
                    $stmt->bindValue(":idPessoa", $pessoa->getIdPessoa(), PDO::PARAM_INT);

                    if($stmt->execute()){

                        $sql = "DELETE FROM
                                    sicoficial_bd.PessoaFisica
                                WHERE
                                    idPessoa = :idPessoa;";

                        $stmt = $conn->prepare($sql);
                        $stmt->bindValue(":idPessoa", $pessoa->getIdPessoa(), PDO::PARAM_INT);

                        if($stmt->execute()){

                            $sql = "DELETE FROM
                                        sicoficial_bd.Usuario
                                    WHERE
                                        idPessoa = :idPessoa;";

                            $stmt = $conn->prepare($sql);
                            $stmt->bindValue(":idPessoa", $pessoa->getIdPessoa(), PDO::PARAM_INT);

                            if($stmt->execute()){

                                $sql = "DELETE FROM
                                            sicoficial_bd.Pessoa
                                        WHERE
                                            idPessoa = :idPessoa;";

                                $stmt = $conn->prepare($sql);
                                $stmt->bindValue(":idPessoa", $pessoa->getIdPessoa(), PDO::PARAM_INT);

                                $stmt->execute();
                            }
                        }
                    }
                }
            }

            return false;


        } catch (PDOException $e) {
            throw new $e(self::ERROR);
        }
    }

    /**
     * Status
     * @param sicPessoaModel $pessoa
     * @return void
     */
    public function status(sicPessoaModel $pessoa)
    {

        try {

            $conn = $this->db;

            $sql = "UPDATE
                        sicoficial_bd.Usuario
                    SET
                        status = :status
                    WHERE
                        idPessoa = :idPessoa;";

            $stmt = $conn->prepare($sql);

            $stmt->bindValue(":idPessoa", $pessoa->getIdPessoa(), PDO::PARAM_INT);
            $stmt->bindValue(":status", $pessoa->getStatusUsuario(), PDO::PARAM_INT);

            $stmt->execute();

        } catch (PDOException $e) {
            throw new $e(self::ERROR);
        }
    }

    /**
     * Busca pessoas
     * @return array|false
     */
    public function getPessoas() {

        try {

            $conn = $this->db;

            $sql = "SELECT 
                        p.idPessoa AS codigo, nome
                    FROM
                        sicoficial_bd.Pessoa p
                            LEFT JOIN
                        sicoficial_bd.PessoaFisica pf ON (pf.idPessoa = p.idPessoa);";

            $stmt = $conn->prepare($sql);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            throw new $e(self::ERROR);
        }
    }
}