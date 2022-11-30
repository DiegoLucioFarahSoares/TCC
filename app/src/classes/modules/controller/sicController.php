<?php

namespace app\src\classes\modules\controller;

use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Views\PhpRenderer;

class sicController
{

    /**
     * Construct
     */
    public function __construct()
    {
        $this->phpview = new PhpRenderer(__DIR__ . '/../../../../../view/');
    }

    /**
     * Login
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function viewLogin(Request $request, Response $response, array $args)
    {
        $dadosTela = [
            'title' => 'SIC - Sistema Interno Corporativo - Login'
        ];

        return $this->phpview->render($response, '/pages/login.php', $dadosTela);
    }

    /**
     * Esqueci minha senha
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function viewEsqueciSenha(Request $request, Response $response, array $args)
    {
        $dadosTela = [
            'title' => 'SIC - Sistema Interno Corporativo - Esqueci minha senha'
        ];

        return $this->phpview->render($response, '/pages/esqueci-senha.php', $dadosTela);
    }

    /**
     * Logout
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return Response
     */
    public function logout(Request $request, Response $response, array $args)
    {
        unset($_SESSION['pessoa']);
        unset($_SESSION['idPessoa']);
        unset($_SESSION['idNivelAcesso']);
        unset($_SESSION['nome']);
        unset($_SESSION['nivel']);
        unset($_SESSION['loggeSic']);
        return $response->withRedirect('/', 301);
    }

    /**
     * Configurar Permissões
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function viewConfigurarPermissoes(Request $request, Response $response, array $args)
    {
        $dadosTela = [
            'title' => 'SIC - Sistema Interno Corporativo - Configurar Permissões'
        ];

        return $this->phpview->render($response, '/pages/configurar-permissoes.php', $dadosTela);
    }

}