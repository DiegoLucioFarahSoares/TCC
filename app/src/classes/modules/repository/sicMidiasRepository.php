<?php

namespace app\src\classes\modules\repository;

use app\src\classes\modules\model\sicMidiasModel;
use PDO;
use PDOException;
use PDOStatement;

require_once __DIR__ . "/../config/ConnectionPdo.php";

class sicMidiasRepository
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
                        m.idMidias,
                        m.nome,
                        m.idCursos,
                        c.nome AS nomeCurso,
                        c.idPessoa,
                        pf.nome AS nomePessoa,
                        m.url,
                        DATE_FORMAT(m.dataCadastro, '%d/%m/%Y %H:%i') AS dataCadastro,
                        m.arquivo,
                        m.status
                    FROM
                        sicoficial_bd.Midias m
                            LEFT JOIN
                        sicoficial_bd.Cursos c ON (c.idCursos = m.idCursos)
                            LEFT JOIN
                        sicoficial_bd.Pessoa p ON (p.idPessoa = c.idPessoa)
                            LEFT JOIN
                        sicoficial_bd.PessoaFisica pf ON (pf.idPessoa = p.idPessoa)
                    WHERE
                        1
                        {$this->setCriterio($params)}
                    ORDER BY m.idMidias asc;";

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
                $criterio .= count($periodo) > 0 ? " AND date(m.dataCadastro) BETWEEN :datai AND :dataf" : "";
            }

            if ($params['nome'] != '' && !empty($params['nome'])) {
                $nome = $params['nome'];
                $criterio .= isset($params['nome']) ? " AND m.nome like '%{$nome}%' " : "";
            }

            if ($params['idMidias'] != '' && !empty($params['idMidias'])) {
                $criterio .= isset($params['idMidias']) ? " AND m.idMidias =  :idMidias" : "";
            }

            if ($params['idCursos'] != '' && !empty($params['idCursos'])) {
                $criterio .= isset($params['idCursos']) ? " AND c.idCursos =  :idCursos" : "";
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

        if (isset($params['idMidias']) && !empty($params['idMidias'])) {
            $stmt->bindValue(":idMidias", $params['idMidias'], PDO::PARAM_INT);
        }

        if (isset($params['idCursos']) && !empty($params['idCursos'])) {
            $stmt->bindValue(":idCursos", $params['idCursos'], PDO::PARAM_INT);
        }
    }

    /**
     * Salvar
     * @param sicMidiasModel $midias
     * @return bool
     */
    public function salvar(sicMidiasModel $midias) {

        try {

            $conn = $this->db;

            $sql = "INSERT INTO 
                        sicoficial_bd.Midias (idCursos, nome, url, arquivo, dataCadastro, status) 
                    VALUES 
                        (:idCursos, :nome, :url, :arquivo, :dataCadastro, :status)";

            $stmt = $conn->prepare($sql);
            $stmt->bindValue(":idCursos", $midias->getIdCursos(), PDO::PARAM_INT);
            $stmt->bindValue(":nome", $midias->getNome(), PDO::PARAM_STR);
            $stmt->bindValue(":url", $midias->getUrl(), PDO::PARAM_STR);
            $stmt->bindValue(":arquivo", $midias->getArquivo(), PDO::PARAM_STR);
            $stmt->bindValue(":dataCadastro", $midias->getDataCadastro(), PDO::PARAM_STR);
            $stmt->bindValue(":status", $midias->getStatus(), PDO::PARAM_INT);
            return $stmt->execute();

        } catch (PDOException $e) {
            throw new $e(self::ERROR);
        }
    }

    /**
     * Editar
     * @param sicMidiasModel $midias
     * @return bool
     */
    public function editar(sicMidiasModel $midias) {

        try {

            $conn = $this->db;

            $sql = "UPDATE
                        sicoficial_bd.Midias
                    SET
                        idCursos = :idCursos, 
                        nome = :nome,
                        url = :url,
                        arquivo = :arquivo
                    WHERE
                        idMidias = :idMidias;";

            $stmt = $conn->prepare($sql);
            $stmt->bindValue(":idMidias", $midias->getIdMidias(), PDO::PARAM_INT);
            $stmt->bindValue(":idCursos", $midias->getIdCursos(), PDO::PARAM_INT);
            $stmt->bindValue(":nome", $midias->getNome(), PDO::PARAM_STR);
            $stmt->bindValue(":url", $midias->getUrl(), PDO::PARAM_STR);
            $stmt->bindValue(":arquivo", $midias->getArquivo(), PDO::PARAM_STR);
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
                        sicoficial_bd.Midias
                    WHERE
                        idMidias = :idMidias;";

            $stmt = $conn->prepare($sql);
            $stmt->bindValue(":idMidias", $params['idMidias'], PDO::PARAM_INT);
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
                        sicoficial_bd.Midias
                    SET
                        status = :status
                    WHERE
                        idMidias = :idMidias;";

            $stmt = $conn->prepare($sql);

            $stmt->bindValue(":idMidias", $params['idMidias'], PDO::PARAM_INT);
            $stmt->bindValue(":status", $params['status'], PDO::PARAM_INT);

            $stmt->execute();

        } catch (PDOException $e) {
            throw new $e(self::ERROR);
        }
    }
}