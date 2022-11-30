<?php

namespace app\src\classes\modules\strategy;

use app\src\classes\modules\config\ConnectionPDO;
use PDO;
use PDOException;

require_once __DIR__ . "/../../../../../app/src/classes/modules/config/ConnectionPDO.php";

class sicStrategy
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
     * @return array|false
     */
    public function getRoutesApi ()
    {
        try {

            $conn = $this->db;

            $sql = "SELECT 
                        r.pasta
                    FROM
                         sicoficial_bd.RouteApi r
                    WHERE
                        r.status = 1;";

            $stmt = $conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        catch (PDOException $e) {
            throw new $e(self::ERROR);
        }
    }
}