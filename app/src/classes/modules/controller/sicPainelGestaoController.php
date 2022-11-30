<?php

namespace app\src\classes\modules\controller;

use app\src\classes\modules\config\ConnectionPDO;
use app\src\classes\modules\repository\sicCursosRepository;
use app\src\classes\modules\repository\sicTreinamentosRepository;
use app\src\classes\modules\service\sicService;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Views\PhpRenderer;

require_once __DIR__ . "/../config/ConnectionPdo.php";

class sicPainelGestaoController
{

    /**
     * Construct
     */
    public function __construct()
    {
        $this->phpview = new PhpRenderer(__DIR__ . '/../../../../../view/');
    }

    /**
     * Painel de Gestão
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function viewPainelGestao(Request $request, Response $response, array $args)
    {
        session_start();

        if (!sicService::adminSIC()) {
            header('Location: /cursos/meus-cursos');
            die();
        }

        $conn = ConnectionPdo::getConnection();
        $repository = new sicCursosRepository($conn);
        $retornoTreinamentos = new sicTreinamentosRepository($conn);

        $params = '';
        $qtdeCursos = 0;

        $retorno = $repository->consultar($params);
        $retornoTreinamentos = $repository->consultar($params);

        $c = 0;
        foreach ($retorno as $item) {
            $qtdeCursos = $c++;
        }

        $t = 0;
        foreach ($retornoTreinamentos as $item) {
            $qtdeTreinamentos = $t++;
        }

        $dadosTela = [
            'title' => 'SIC - Sistema Interno Corporativo - Painel de Gestão',
            'adminSIC' => sicService::adminSIC(),
            'qtdeCursos' => $qtdeCursos,
            'qtdeTreinamentos' => $qtdeTreinamentos
        ];

        return $this->phpview->render($response, '/pages/painel-gestao.php', $dadosTela);
    }
}