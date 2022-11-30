<?php

namespace app\src\classes\modules\repository;

use app\src\classes\modules\model\sicEventosModel;
use PDO;
use PDOException;
use PDOStatement;

require_once __DIR__ . "/../config/ConnectionPdo.php";

class sicEventosRepository
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

            $sql = "SELECT 
                        a.idAgenda AS idEventos,
                        a.idPessoa,
                        pf.nome AS nomePessoa,
                        a.nome,
                        a.descricao,
                        DATE_FORMAT(a.dataCadastro, '%d/%m/%Y %H:%i') AS dataCadastro,
                        a.horas,
                        DATE_FORMAT(a.dataInicio, '%d/%m/%Y') AS dataInicio,
                        DATE_FORMAT(a.dataFim, '%d/%m/%Y') AS dataFim,
                        a.status
                    FROM
                        sicoficial_bd.Agenda a
                            LEFT JOIN
                        sicoficial_bd.Pessoa p ON (p.idPessoa = a.idPessoa)
                            LEFT JOIN
                        sicoficial_bd.PessoaFisica pf ON (pf.idPessoa = p.idPessoa)
                    WHERE
                        1
                        {$this->setCriterio($params)}
                    ORDER BY a.dataCadastro DESC;";
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
                $criterio .= count($periodo) > 0 ? " AND date(a.dataCadastro) BETWEEN :datai AND :dataf" : "";
            }

            if ($params['nome'] != '' && !empty($params['nome'])) {
                $nome = $params['nome'];
                $criterio .= isset($params['nome']) ? " AND a.nome like '%{$nome}%' " : "";
            }

            if ($params['idEventos'] != '' && !empty($params['idEventos'])) {
                $criterio .= isset($params['idEventos']) ? " AND a.idAgenda =  :idEventos" : "";
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

        if (isset($params['idEventos']) && !empty($params['idEventos'])) {
            $stmt->bindValue(":Eventos", $params['idEventos'], PDO::PARAM_INT);
        }
    }

    /**
     * Salvar
     * @param sicEventosModel $eventos
     * @return bool
     */
    public function salvar(sicEventosModel $eventos) {

        try {

            $conn = $this->db;

            $sql = "INSERT INTO 
                        sicoficial_bd.Agenda (idPessoa, nome, descricao, dataCadastro, horas, dataInicio, dataFim, status) 
                    VALUES 
                        (:idPessoa, :nome, :descricao, :dataCadastro, :horas, :dataInicio, :dataFim, :status)";

            $stmt = $conn->prepare($sql);
            $stmt->bindValue(":idPessoa", $eventos->getIdPessoa(), PDO::PARAM_INT);
            $stmt->bindValue(":nome", $eventos->getNome(), PDO::PARAM_STR);
            $stmt->bindValue(":descricao", $eventos->getDescricao(), PDO::PARAM_STR);
            $stmt->bindValue(":dataCadastro", $eventos->getDataCadastro(), PDO::PARAM_STR);
            $stmt->bindValue(":horas", $eventos->getHoras(), PDO::PARAM_STR);
            $stmt->bindValue(":dataInicio", $eventos->getDataInicio(), PDO::PARAM_STR);
            $stmt->bindValue(":dataFim", $eventos->getDataFim(), PDO::PARAM_STR);
            $stmt->bindValue(":status", $eventos->getStatus(), PDO::PARAM_INT);
            return $stmt->execute();

        } catch (PDOException $e) {
            throw new $e(self::ERROR);
        }
    }

    /**
     * Editar
     * @param sicEventosModel $eventos
     * @return bool
     */
    public function editar(sicEventosModel $eventos) {

        try {

            $conn = $this->db;

            $sql = "UPDATE
                        sicoficial_bd.Agenda
                    SET
                        idPessoa = :idPessoa,
                        nome = :nome,
                        descricao = :descricao,
                        horas = :horas,
                        dataInicio = :dataInicio,
                        dataFim = :dataFim
                    WHERE
                        idAgenda = :idEventos;";

            $stmt = $conn->prepare($sql);
            $stmt->bindValue(":idEventos", $eventos->getIdEventos(), PDO::PARAM_INT);
            $stmt->bindValue(":idPessoa", $eventos->getIdPessoa(), PDO::PARAM_INT);
            $stmt->bindValue(":nome", $eventos->getNome(), PDO::PARAM_STR);
            $stmt->bindValue(":descricao", $eventos->getDescricao(), PDO::PARAM_STR);
            $stmt->bindValue(":horas", $eventos->getHoras(), PDO::PARAM_STR);
            $stmt->bindValue(":dataInicio", $eventos->getDataInicio(), PDO::PARAM_STR);
            $stmt->bindValue(":dataFim", $eventos->getDataFim(), PDO::PARAM_STR);
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
                        sicoficial_bd.Agenda
                    WHERE
                        idAgenda = :idEventos;";

            $stmt = $conn->prepare($sql);
            $stmt->bindValue(":idEventos", $params['idEventos'], PDO::PARAM_INT);
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
                        sicoficial_bd.Agenda
                    SET
                        status = :status
                    WHERE
                        idAgenda = :idEventos;";

            $stmt = $conn->prepare($sql);

            $stmt->bindValue(":idEventos", $params['idEventos'], PDO::PARAM_INT);
            $stmt->bindValue(":status", $params['status'], PDO::PARAM_INT);

            $stmt->execute();

        } catch (PDOException $e) {
            throw new $e(self::ERROR);
        }
    }
}