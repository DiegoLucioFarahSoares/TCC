<?php

namespace app\src\classes\modules\controller;

use app\src\classes\modules\config\ConnectionPDO;
use app\src\classes\modules\exception\sicException;
use app\src\classes\modules\model\sicLoginModel;
use app\src\classes\modules\repository\sicLoginRepository;
use Exception;
use Slim\Http\Request;
use Slim\Http\Response;

require_once __DIR__ . "/../config/ConnectionPdo.php";

class sicLoginController
{

    /**
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return Response
     */
    public function findLogin(Request $request, Response $response, array $args)
    {
        try {

            $params = $request->getParsedBody();

            if(!isset($params['login']) || empty($params['login'])){
                throw new sicException(1);
            }

            if(!isset($params['senha']) || empty($params['senha'])){
                throw new sicException(2);
            }

            $conn = ConnectionPdo::getConnection();
            $repository = new sicLoginRepository($conn);

            $model = new sicLoginModel();
            $model->setLogin(trim($params['login']));
            $model->setSenha($params['senha']);
            $dados = $repository->findLogin($model);

            if(!empty($dados)) {
                session_start();

                $_SESSION['pessoa'] = $dados['Login'];
                $_SESSION['idPessoa'] = (int)$dados['idPessoa'];
                $_SESSION['idNivelAcesso'] = (int)$dados['idNivelAcesso'];
                $_SESSION['nome']  = $dados['nome'];
                $_SESSION['nivel']  = (int)$dados['idAcesso'];
                $_SESSION['loggeSic']  = true;
            }

            return $response->withJson([
                "status" => true,
                "resultSet" => $dados
            ])->withStatus(200);
        } catch (Exception $e) {
            return $response->withJson([
                "status" => true,
                "resultSet" => $e->getMessage()
            ], 500);
        }
    }

    /**
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return Response
     */
    public function getEsqueciSenha(Request $request, Response $response, array $args)
    {
        try {

            $params = $request->getQueryParams();

            if(!isset($params['login']) || empty($params['login'])){
                throw new sicException(1);
            }

            $conn = ConnectionPdo::getConnection();
            $repository = new sicLoginRepository($conn);

            $model = new sicLoginModel();
            $model->setLogin(trim($params['login']));
            $dados = $repository->getEsqueciSenha($model);

            //todo add vinda e-mail
//            if($dados > 0) {
////                emailRule::enviaEmail($dados);
////                $dados = $repository->alterarSenha($dados['idPessoa'], $params['senha']);
//            }

            return $response->withJson([
                "status" => true,
                "resultSet" => $dados
            ])->withStatus(200);
        } catch (Exception $e) {
            return $response->withJson([
                "status" => true,
                "resultSet" => $e->getMessage()
            ], 500);
        }
    }
}