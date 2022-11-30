<?php

namespace app\src\classes\modules\repository;

use app\src\classes\modules\model\sicTreinamentosModel;
use PDO;
use PDOException;
use PDOStatement;

require_once __DIR__ . "/../config/ConnectionPdo.php";

class sicTreinamentosRepository
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
                        COUNT(t.idPessoa) AS total,
                        t.idTreinamentos,
                        t.idPessoa,
                        pf.nome AS nomePessoa,
                        t.nome,
                        t.descricao,
                        t.img,
                        DATE_FORMAT(t.dataCadastro, '%d/%m/%Y %H:%i') AS dataCadastro,
                        t.horas,
                        DATE_FORMAT(t.dataInicio, '%d/%m/%Y') AS dataInicio,
                        DATE_FORMAT(t.dataFim, '%d/%m/%Y') AS dataFim,
                        t.status
                    FROM
                        sicoficial_bd.Treinamentos t
                            LEFT JOIN
                        sicoficial_bd.Pessoa p ON (p.idPessoa = t.idPessoa)
                            LEFT JOIN
                        sicoficial_bd.PessoaFisica pf ON (pf.idPessoa = p.idPessoa)
                    WHERE
                        1
                    {$this->setCriterio($params)}
                    GROUP BY t.idTreinamentos
                    ORDER BY t.dataCadastro DESC;";

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
                $criterio .= count($periodo) > 0 ? " AND date(t.dataCadastro) BETWEEN :datai AND :dataf" : "";
            }

            if ($params['nome'] != '' && !empty($params['nome'])) {
                $nome = $params['nome'];
                $criterio .= isset($params['nome']) ? " AND t.nome like '%{$nome}%' " : "";
            }

            if ($params['idTreinamentos'] != '' && !empty($params['idTreinamentos'])) {
                $criterio .= isset($params['idTreinamentos']) ? " AND t.idTreinamentos =  :idTreinamentos" : "";
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

        if (isset($params['idTreinamentos']) && !empty($params['idTreinamentos'])) {
            $stmt->bindValue(":idTreinamentos", $params['idTreinamentos'], PDO::PARAM_INT);
        }
    }

    /**
     * Salvar
     * @param sicTreinamentosModel $treinamentos
     * @return bool
     */
    public function salvar(sicTreinamentosModel $treinamentos) {

        try {

            $conn = $this->db;

            $sql = "INSERT INTO 
                        sicoficial_bd.Treinamentos (idPessoa, nome, descricao, img, dataCadastro, horas, dataInicio, dataFim, status) 
                    VALUES 
                        (:idPessoa, :nome, :descricao, :img, :dataCadastro, :horas, :dataInicio, :dataFim, :status)";

            $stmt = $conn->prepare($sql);
            $stmt->bindValue(":idPessoa", $treinamentos->getIdPessoa(), PDO::PARAM_INT);
            $stmt->bindValue(":nome", $treinamentos->getNome(), PDO::PARAM_STR);
            $stmt->bindValue(":descricao", $treinamentos->getDescricao(), PDO::PARAM_STR);
            $stmt->bindValue(":img", $treinamentos->getImg(), PDO::PARAM_STR);
            $stmt->bindValue(":dataCadastro", $treinamentos->getDataCadastro(), PDO::PARAM_STR);
            $stmt->bindValue(":horas", $treinamentos->getHoras(), PDO::PARAM_STR);
            $stmt->bindValue(":dataInicio", $treinamentos->getDataInicio(), PDO::PARAM_STR);
            $stmt->bindValue(":dataFim", $treinamentos->getDataFim(), PDO::PARAM_STR);
            $stmt->bindValue(":status", $treinamentos->getStatus(), PDO::PARAM_INT);
            return $stmt->execute();

        } catch (PDOException $e) {
            throw new $e(self::ERROR);
        }
    }

    /**
     * Editar
     * @param sicTreinamentosModel $treinamentos
     * @return bool
     */
    public function editar(sicTreinamentosModel $treinamentos) {

        try {

            $conn = $this->db;

            $sql = "UPDATE
                        sicoficial_bd.Treinamentos
                    SET
                        idPessoa = :idPessoa,
                        nome = :nome,
                        descricao = :descricao,
                        img = :img,
                        horas = :horas,
                        dataInicio = :dataInicio,
                        dataFim = :dataFim
                    WHERE
                        idTreinamentos = :idTreinamentos;";

            $stmt = $conn->prepare($sql);
            $stmt->bindValue(":idTreinamentos", $treinamentos->getIdTreinamentos(), PDO::PARAM_INT);
            $stmt->bindValue(":idPessoa", $treinamentos->getIdPessoa(), PDO::PARAM_INT);
            $stmt->bindValue(":nome", $treinamentos->getNome(), PDO::PARAM_STR);
            $stmt->bindValue(":descricao", $treinamentos->getDescricao(), PDO::PARAM_STR);
            $stmt->bindValue(":img", $treinamentos->getImg(), PDO::PARAM_STR);
            $stmt->bindValue(":horas", $treinamentos->getHoras(), PDO::PARAM_STR);
            $stmt->bindValue(":dataInicio", $treinamentos->getDataInicio(), PDO::PARAM_STR);
            $stmt->bindValue(":dataFim", $treinamentos->getDataFim(), PDO::PARAM_STR);
            return $stmt->execute();

        } catch (PDOException $e) {
            throw new $e(self::ERROR);
        }
    }

    /**
     * Excluir
     * @param $params
     * @return bool
     */
    public function excluir($params) {

        try {

            $conn = $this->db;

            $sql = "DELETE FROM 
                        sicoficial_bd.Treinamentos
                    WHERE
                        idTreinamentos = :idTreinamentos;";

            $stmt = $conn->prepare($sql);
            $stmt->bindValue(":idTreinamentos", $params['idTreinamentos'], PDO::PARAM_INT);
            return $stmt->execute();

        } catch (PDOException $e) {
            throw new $e(self::ERROR);
        }
    }

    /**
     * Status
     * @param $params
     * @return void
     */
    public function status($params)
    {

        try {

            $conn = $this->db;

            $sql = "UPDATE
                        sicoficial_bd.Treinamentos
                    SET
                        status = :status
                    WHERE
                        idTreinamentos = :idTreinamentos;";

            $stmt = $conn->prepare($sql);

            $stmt->bindValue(":idTreinamentos", $params['idTreinamentos'], PDO::PARAM_INT);
            $stmt->bindValue(":status", $params['status'], PDO::PARAM_INT);

            $stmt->execute();

        } catch (PDOException $e) {
            throw new $e(self::ERROR);
        }
    }
}