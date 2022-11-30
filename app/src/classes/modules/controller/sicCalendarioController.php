<?php

namespace app\src\classes\modules\controller;

use app\src\classes\modules\service\sicService;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Views\PhpRenderer;

class sicCalendarioController
{

    /**
     * Construct
     */
    public function __construct()
    {
        $this->phpview = new PhpRenderer(__DIR__ . '/../../../../../view/');
    }

    /**
     * Calendário
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function viewCalendario(Request $request, Response $response, array $args)
    {
        session_start();

        $dadosTela = [
            'title' => 'SIC - Sistema Interno Corporativo - Calendário',
            'adminSIC' => sicService::adminSIC(),
        ];

        return $this->phpview->render($response, '/pages/calendario.php', $dadosTela);
    }

}