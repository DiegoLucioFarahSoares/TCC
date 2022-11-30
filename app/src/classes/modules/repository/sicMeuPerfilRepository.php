<?php

namespace app\src\classes\modules\repository;

use PDO;
use PDOException;
use PDOStatement;

require_once __DIR__ . "/../config/ConnectionPdo.php";

class sicMeuPerfilRepository
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

//    /**
//     * Consultar
//     * @param $params
//     * @return array|false
//     */
//    public function consultar($idPessoa) {
//
//        try {
//
//            $conn = $this->db;
//
//            $stmt = $conn->prepare("SET SESSION sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''));");
//            $stmt->execute();
//
//            $sql = "SELECT
//                        DATE_FORMAT(p.dataCadastro, '%d/%m/%Y %H:%i') AS dataCadastro,
//                        u.idNivelAcesso,
//                        u.status,
//                        p.idPessoa,
//                        pf.nome,
//                        pf.cpf,
//                        pf.rg,
//                        pf.sexo,
//                        DATE_FORMAT(pf.dataNascimento, '%d/%m/%Y') AS dataNascimento,
//                        n.nome AS nivel,
//                        email.email,
//                        t.numero AS telefone,
//                        CONCAT(e.uf, ' - ', e.nome) AS estado,
//                        c.nome AS cidade,
//                        end.logradouro,
//                        end.bairro,
//                        end.cep,
//                        end.numero,
//                        end.complemento
//                    FROM
//                        sicoficial_bd.Usuario u
//                            LEFT JOIN
//                        sicoficial_bd.Pessoa p ON (p.idPessoa = u.idPessoa)
//                            LEFT JOIN
//                        sicoficial_bd.PessoaFisica pf ON (pf.idPessoa = p.idPessoa)
//                            LEFT JOIN
//                        sicoficial_bd.Endereco end ON (end.idPessoa = p.idPessoa)
//                            LEFT JOIN
//                        sicoficial_bd.Estado e ON (e.idEstado = pf.idEstado)
//                            LEFT JOIN
//                        sicoficial_bd.Cidade c ON (c.idEstado = e.idEstado)
//                            LEFT JOIN
//                        sicoficial_bd.NivelAcesso n ON (n.idNivelAcesso = u.idNivelAcesso)
//                            LEFT JOIN
//                        sicoficial_bd.Email email ON (email.idPessoa = p.idPessoa)
//                            LEFT JOIN
//                        sicoficial_bd.Telefone t ON (t.idPessoa = p.idPessoa)
//                    WHERE
//                        p.idPessoa =  :idPessoa
//                    GROUP BY p.idPessoa
//                    ORDER BY p.dataCadastro DESC;";
//
//            $stmt = $conn->prepare($sql);
//            $stmt->bindValue(":idPessoa", $idPessoa, PDO::PARAM_INT);
//            $stmt->execute();
//
//            return $stmt->fetchAll(PDO::FETCH_ASSOC);
//
//        } catch (PDOException $e) {
//            throw new $e(self::ERROR);
//        }
//    }
}