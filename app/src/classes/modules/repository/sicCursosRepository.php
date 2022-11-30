<?php

namespace app\src\classes\modules\repository;

use app\src\classes\modules\model\sicCursosModel;
use PDO;
use PDOException;
use PDOStatement;

require_once __DIR__ . "/../config/ConnectionPdo.php";

class sicCursosRepository
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
                        c.idCursos,
                        c.idCategorias,
                        cat.nome AS nomeCategoria,
                        c.idPessoa,
                        pf.nome AS nomePessoa,
                        c.nome,
                        c.descricao,
                        c.img,
                        DATE_FORMAT(c.dataCadastro, '%d/%m/%Y %H:%i') AS dataCadastro,
                        c.horas,
                        DATE_FORMAT(c.dataInicio, '%d/%m/%Y') AS dataInicio,
                        DATE_FORMAT(c.dataFim, '%d/%m/%Y') AS dataFim,
                        c.status,
                        m.nome AS nomeMidia,
                        m.url AS link,
                        m.arquivo
                    FROM
                        sicoficial_bd.Cursos c
                            LEFT JOIN
                        sicoficial_bd.Categorias cat ON (cat.idCategorias = c.idCategorias)
                            LEFT JOIN
                        sicoficial_bd.Pessoa p ON (cat.idPessoa = p.idPessoa)
                            LEFT JOIN
                        sicoficial_bd.PessoaFisica pf ON (pf.idPessoa = p.idPessoa)
                            LEFT JOIN
                        sicoficial_bd.Midias m ON (m.idCursos = c.idCursos)
                    WHERE
                        1
                    {$this->setCriterio($params)}
                    GROUP BY c.idCursos
                    ORDER BY c.dataCadastro DESC;";
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
                $criterio .= count($periodo) > 0 ? " AND date(c.dataCadastro) BETWEEN :datai AND :dataf" : "";
            }

            if ($params['nome'] != '' && !empty($params['nome'])) {
                $nome = $params['nome'];
                $criterio .= isset($params['nome']) ? " AND c.nome like '%{$nome}%' " : "";
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

        if (isset($params['idCursos']) && !empty($params['idCursos'])) {
            $stmt->bindValue(":idCursos", $params['idCursos'], PDO::PARAM_INT);
        }
    }

    /**
     * Salvar
     * @param sicCursosModel $cursos
     * @return bool
     */
    public function salvar(sicCursosModel $cursos) {

        try {

            $conn = $this->db;

            $sql = "INSERT INTO 
                        sicoficial_bd.Cursos (idCategorias, idPessoa, nome, descricao, img, dataCadastro, horas, dataInicio, dataFim, status) 
                    VALUES 
                        (:idCategorias, :idPessoa, :nome, :descricao, :img, :dataCadastro, :horas, :dataInicio, :dataFim, :status)";

            $stmt = $conn->prepare($sql);
            $stmt->bindValue(":idCategorias", $cursos->getIdCategorias(), PDO::PARAM_INT);
            $stmt->bindValue(":idPessoa", $cursos->getIdPessoa(), PDO::PARAM_INT);
            $stmt->bindValue(":nome", $cursos->getNome(), PDO::PARAM_STR);
            $stmt->bindValue(":descricao", $cursos->getDescricao(), PDO::PARAM_STR);
            $stmt->bindValue(":img", $cursos->getImg(), PDO::PARAM_STR);
            $stmt->bindValue(":dataCadastro", $cursos->getDataCadastro(), PDO::PARAM_STR);
            $stmt->bindValue(":horas", $cursos->getHoras(), PDO::PARAM_STR);
            $stmt->bindValue(":dataInicio", $cursos->getDataInicio(), PDO::PARAM_STR);
            $stmt->bindValue(":dataFim", $cursos->getDataFim(), PDO::PARAM_STR);
            $stmt->bindValue(":status", $cursos->getStatus(), PDO::PARAM_INT);
            return $stmt->execute();

        } catch (PDOException $e) {
            throw new $e(self::ERROR);
        }
    }

    /**
     * Editar
     * @param sicCursosModel $cursos
     * @return bool
     */
    public function editar(sicCursosModel $cursos) {

        try {

            $conn = $this->db;

            $sql = "UPDATE
                        sicoficial_bd.Cursos
                    SET
                        idCategorias = :idCategorias, 
                        idPessoa = :idPessoa,
                        nome = :nome,
                        descricao = :descricao,
                        img = :img,
                        horas = :horas,
                        dataInicio = :dataInicio,
                        dataFim = :dataFim
                    WHERE
                        idCursos = :idCursos;";

            $stmt = $conn->prepare($sql);
            $stmt->bindValue(":idCursos", $cursos->getIdCursos(), PDO::PARAM_INT);
            $stmt->bindValue(":idCategorias", $cursos->getIdCategorias(), PDO::PARAM_INT);
            $stmt->bindValue(":idPessoa", $cursos->getIdPessoa(), PDO::PARAM_INT);
            $stmt->bindValue(":nome", $cursos->getNome(), PDO::PARAM_STR);
            $stmt->bindValue(":descricao", $cursos->getDescricao(), PDO::PARAM_STR);
            $stmt->bindValue(":img", $cursos->getImg(), PDO::PARAM_STR);
            $stmt->bindValue(":horas", $cursos->getHoras(), PDO::PARAM_STR);
            $stmt->bindValue(":dataInicio", $cursos->getDataInicio(), PDO::PARAM_STR);
            $stmt->bindValue(":dataFim", $cursos->getDataFim(), PDO::PARAM_STR);
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
                        sicoficial_bd.Cursos
                    WHERE
                        idCursos = :idCursos;";

            $stmt = $conn->prepare($sql);
            $stmt->bindValue(":idCursos", $params['idCursos'], PDO::PARAM_INT);
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
                        sicoficial_bd.Cursos
                    SET
                        status = :status
                    WHERE
                        idCursos = :idCursos;";

            $stmt = $conn->prepare($sql);

            $stmt->bindValue(":idCursos", $params['idCursos'], PDO::PARAM_INT);
            $stmt->bindValue(":status", $params['status'], PDO::PARAM_INT);

            $stmt->execute();

        } catch (PDOException $e) {
            throw new $e(self::ERROR);
        }
    }

    /**
     * Busca cursos
     * @return array|false
     */
    public function getCursos() {

        try {

            $conn = $this->db;

            $sql = "SELECT 
                        idCursos AS codigo,
                        nome
                    FROM
                        sicoficial_bd.Cursos;";

            $stmt = $conn->prepare($sql);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            throw new $e(self::ERROR);
        }
    }
}