<?php

namespace app\src\classes\modules\repository;

use app\src\classes\modules\model\sicLoginModel;

use PDO;
use PDOException;

require_once __DIR__ . "/../config/ConnectionPdo.php";

class sicLoginRepository
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
     * @param sicLoginModel $login
     * @return false|mixed
     */
    public function findLogin(sicLoginModel $login) {

        try {

            $conn = $this->db;

            $sql = "SELECT 
                        u.login,
                        u.senha,
                        u.idNivelAcesso,
                        pf.nome,
                        p.idPessoa,
                        n.idNivelAcesso
                    FROM
                        sicoficial_bd.Usuario u
                            LEFT JOIN
                        sicoficial_bd.Pessoa p ON (p.idPessoa = u.idPessoa)
                            LEFT JOIN
                        sicoficial_bd.PessoaFisica pf ON (pf.idPessoa = p.idPessoa)
                            LEFT JOIN
                        sicoficial_bd.NivelAcesso n ON (n.idNivelAcesso = u.idNivelAcesso
                            AND n.status = 1)
                    WHERE
                        u.login = :login 
                        AND u.senha = :senha
                        AND u.status = 1;";

            $stmt = $conn->prepare($sql);
            $stmt->bindValue(':login', $login->getLogin(), PDO::PARAM_STR);
            $stmt->bindValue(':senha', $login->getSenha(), PDO::PARAM_STR);

            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                return $stmt->fetch(PDO::FETCH_ASSOC);
            } else {
                return false;
            }

        }
        catch (PDOException $ex) {
            throw new $e(self::ERROR);
        }
    }

    public function getEsqueciSenha(sicLoginModel $login) {

        try {

            $conn = $this->db;

            $sql = "SELECT 
                        u.login, u.idPessoa
                    FROM
                        sicoficial_bd.Usuario u
                    WHERE
                        u.login = :login
                        AND u.status = 1;";

            $stmt = $conn->prepare($sql);
            $stmt->bindValue(':login', $login->getLogin(), PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        catch (PDOException $ex) {
            throw new $e(self::ERROR);
        }
    }

    public function alterarSenha($idPessoa, $senha) {

        try {

            $conn = $this->db;

            $sql = "UPDATE sicoficial_bd.Usuario 
                    SET 
                        senha = :senha
                    WHERE
                        idPessoa = :idPessoa;";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(":senha", $senha, PDO::PARAM_STR);
            $stmt->bindValue(":idPessoa", $idPessoa, PDO::PARAM_INT);

            if($stmt->execute()) {
                $this->saveHistoricoUsuario($idPessoa, $senha);
                return true;
            }

            return false;
        }
        catch (PDOException $e) {
            throw new $e(self::ERROR);
        }
    }

    public function saveHistoricoUsuario($idPessoa, $senha)
    {
        try {

            $conn = $this->db;

            $sql = "INSERT INTO
                        sicoficial_bd.HistoricoUsuario (idPessoa, senha, dataCadastro)
                    VALUES
                        (:idPessoa, :senha, :dataCadastro)";

            $stmt = $conn->prepare($sql);

            $stmt->bindValue(':idPessoa', $idPessoa, PDO::PARAM_INT);
            $stmt->bindValue(':senha', $senha, PDO::PARAM_STR);
            $stmt->bindValue(':dataCadastro', date('Y-m-d H:i:s'), PDO::PARAM_STR);

            if($stmt->execute()){
                return $conn->lastInsertId();
            }

            return false;
        }
        catch (PDOException $e) {
            throw new $e(self::ERROR);
        }
    }
}