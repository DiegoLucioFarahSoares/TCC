<?php

namespace app\src\classes\modules\repository;

use PDO;
use PDOException;
use PDOStatement;

require_once __DIR__ . "/../config/ConnectionPdo.php";

class sicConfigurarPermissoesRepository
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
                        idNivelAcesso,
                        nome,
                        DATE_FORMAT(dataCadastro, '%d/%m/%Y %H:%i') AS dataCadastro,
                        status
                    FROM
                        sicoficial_bd.NivelAcesso
                    WHERE
                        1
                        {$this->setCriterio($params)}
                    ORDER BY dataCadastro DESC;";
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
                $criterio .= count($periodo) > 0 ? " AND date(dataCadastro) BETWEEN :datai AND :dataf" : "";
            }

            if ($params['nome'] != '' && !empty($params['nome'])) {
                $nome = $params['nome'];
                $criterio .= isset($params['nome']) ? " AND nome like '%{$nome}%' " : "";
            }

            if ($params['idNivelAcesso'] != '' && !empty($params['idNivelAcesso'])) {
                $criterio .= isset($params['idNivelAcesso']) ? " AND idNivelAcesso =  :idNivelAcesso" : "";
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

        if (isset($params['idNivelAcesso']) && !empty($params['idNivelAcesso'])) {
            $stmt->bindValue(":idNivelAcesso", $params['idNivelAcesso'], PDO::PARAM_INT);
        }
    }

    /**
     * Salvar
     * @param $param
     * @return mixed
     */
    public function salvar($params) {

        try {

            $conn = $this->db;

            $sql = "INSERT INTO 
                        sicoficial_bd.NivelAcesso (nome, dataCadastro, status) 
                    VALUES 
                        (:nome, now(), 1)";

            $stmt = $conn->prepare($sql);
            $this->setBindValue($stmt, $params);
            return $stmt->execute();

        } catch (PDOException $e) {
            throw new $e(self::ERROR);
        }
    }

    /**
     * Editar
     * @param $params
     * @return bool
     */
    public function editar($params) {

        try {

            $conn = $this->db;

            $sql = "UPDATE 
                        sicoficial_bd.NivelAcesso
                    SET 
                        nome = :nome,
                        datacadastro = now()
                    WHERE
                        idNivelAcesso = :idNivelAcesso;";

            $stmt = $conn->prepare($sql);
            $stmt->bindValue(":idNivelAcesso", $params['idNivelAcesso'], PDO::PARAM_INT);
            $this->setBindValue($stmt, $params);
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
                        sicoficial_bd.NivelAcesso
                    WHERE
                        idNivelAcesso = :idNivelAcesso;";

            $stmt = $conn->prepare($sql);
            $stmt->bindValue(":idNivelAcesso", $params['idNivelAcesso'], PDO::PARAM_INT);
            return $stmt->execute();

        } catch (PDOException $e) {
            throw new $e(self::ERROR);
        }
    }
}