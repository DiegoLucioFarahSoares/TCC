<?php

namespace app\src\classes\modules\controller;

use app\src\classes\modules\config\ConnectionPDO;
use app\src\classes\modules\repository\sicCategoriasRepository;
use app\src\classes\modules\service\sicService;
use app\src\classes\modules\utils\helpers;
use Exception;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Views\PhpRenderer;

require_once __DIR__ . "/../config/ConnectionPdo.php";

class sicCategoriasController
{

    const ERROR = 'Não foi possível realizar esta ação, tente novamente mais tarde.';

    /**
     * Construct
     */
    public function __construct()
    {
        $this->phpview = new PhpRenderer(__DIR__ . '/../../../../../view/');
    }

    /**
     * Visualizar Categorias
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function viewGerenciamentoCategorias(Request $request, Response $response, array $args)
    {
        session_start();

        if (!sicService::adminSIC()) {
            header('Location: /cursos/meus-cursos');
            die();
        }

        $dadosTela = [
            'title' => 'SIC - Sistema Interno Corporativo - Visualizar Categorias',
            'adminSIC' => sicService::adminSIC(),
        ];

        return $this->phpview->render($response, '/pages/gerenciamento/categorias.php', $dadosTela);
    }

    /**
     * Consultar
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function consultar(Request $request, Response $response)
    {

        try {

            $params = $request->getQueryParams();

            $conn = ConnectionPdo::getConnection();
            $repository = new sicCategoriasRepository($conn);

            $dados = $repository->consultar($params);

            return $response->withJson([
                "status" => true,
                'resultSet' => helpers::convertUTF8($dados)
            ])->withStatus(200);
        } catch (Exception $ex) {
            return $response->withJson([
                'status' => false,
                'message' =>  'Não foi possível realizar esta ação, tente novamente mais tarde.'
            ],500);
        }
    }

    /**
     * Salvar
     */
    public function salvar(Request $request, Response $response)
    {
        try {

            $params = $request->getParsedBody();

            $conn = ConnectionPdo::getConnection();
            $repository = new sicCategoriasRepository($conn);

            session_start();
            $params['idPessoa'] = $_SESSION['idPessoa'];

            $dados = $repository->salvar($params);

            return $response->withJson([
                "status" => true,
                'resultSet' => helpers::convertUTF8($dados)
            ])->withStatus(200);
        } catch (Exception $ex) {
            return $response->withJson([
                'status' => false,
                'message' =>  'Não foi possível realizar esta ação, tente novamente mais tarde.'
            ],500);
        }
    }

    /**
     * Editar
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function editar(Request $request, Response $response)
    {
        try {

            $params = $request->getParsedBody();

            $conn = ConnectionPdo::getConnection();
            $repository = new sicCategoriasRepository($conn);

            $dados = $repository->editar($params);

            return $response->withJson([
                "status" => true,
                'resultSet' => helpers::convertUTF8($dados)
            ])->withStatus(200);
        } catch (Exception $ex) {
            return $response->withJson([
                'status' => false,
                'message' =>  'Não foi possível realizar esta ação, tente novamente mais tarde.'
            ],500);
        }
    }

    /**
     * Excluir
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function excluir(Request $request, Response $response)
    {
        try {

            $params = $request->getParsedBody();

            $conn = ConnectionPdo::getConnection();
            $repository = new sicCategoriasRepository($conn);

            $dados = $repository->excluir($params);

            return $response->withJson([
                "status" => true,
                'resultSet' => helpers::convertUTF8($dados)
            ])->withStatus(200);
        } catch (Exception $ex) {
            return $response->withJson([
                'status' => false,
                'message' =>  'Não foi possível realizar esta ação, tente novamente mais tarde.'
            ],500);
        }
    }

    /**
     * Status
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function status(Request $request, Response $response)
    {
        try {

            $params = $request->getQueryParams();

            $conn = ConnectionPdo::getConnection();
            $repository = new sicCategoriasRepository($conn);

            $dados = $repository->status($params);

            return $response->withJson([
                "status" => true,
                'resultSet' => helpers::convertUTF8($dados)
            ])->withStatus(200);
        } catch (Exception $ex) {
            return $response->withJson([
                'status' => false,
                'message' =>  self::ERROR
            ],500);
        }
    }

    /**
     * Busca categorias
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function getCategorias(Request $request, Response $response)
    {
        try {

            $conn = ConnectionPdo::getConnection();
            $repository = new sicCategoriasRepository($conn);

            $dados = $repository->getCategorias();

            return $response->withJson([
                "status" => true,
                'resultSet' => helpers::convertUTF8($dados)
            ])->withStatus(200);
        } catch (Exception $ex) {
            return $response->withJson([
                'status' => false,
                'message' =>  self::ERROR
            ],500);
        }
    }
}