<?php

namespace app\src\classes\modules\controller;

use app\src\classes\modules\config\ConnectionPDO;
use app\src\classes\modules\email\service\emailService;
use app\src\classes\modules\model\sicPessoaModel;
use app\src\classes\modules\repository\sicPessoaRepository;
use app\src\classes\modules\service\sicService;
use app\src\classes\modules\utils\helpers;
use Exception;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Views\PhpRenderer;

require_once __DIR__ . "/../config/ConnectionPdo.php";

class sicPessoaController
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
     * Visualizar Pessoas
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function viewGerenciamentoPessoa(Request $request, Response $response, array $args)
    {
        session_start();

        if (!sicService::adminSIC()) {
            header('Location: /cursos/meus-cursos');
            die();
        }

        $dadosTela = [
            'title' => 'SIC - Sistema Interno Corporativo - Visualizar Pessoas',
            'adminSIC' => sicService::adminSIC(),
        ];

        return $this->phpview->render($response, '/pages/gerenciamento/pessoa.php', $dadosTela);
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
            $repository = new sicPessoaRepository($conn);

            $dados = $repository->consultar($params);

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
     * Salvar
     */
    public function salvar(Request $request, Response $response)
    {
        try {

            $params = $request->getParsedBody();

            $conn = ConnectionPdo::getConnection();
            $repository = new sicPessoaRepository($conn);

            $senha = date('Y-m-d', mktime(0, 0, 0, date('n'), date('j') - 5));
            $params['senha'] = $senha;

            $cidade = $repository->obterCidadePeloIbge($params['iCidade']);

            $idPessoa = $repository->salvarPessoa();

            if((int)$idPessoa > 0) {
                $model = new sicPessoaModel();
                $model->setIdPessoa($idPessoa);
                $model->setIdNivelAcesso($params['iNivelAcesso']);
                $model->setLogin($params['iLogin']);
                $model->setSenha($params['senha']);
                $model->setImg('/view/pages/assets/img/icon.png');
                $model->setDataCadastro(date('Y-m-d H:i:s'));
                $model->setNomePessoa($params['iNome']);
                $model->setCpf(preg_replace('/\D/', '', $params['iCpf']));
                $model->setRg(preg_replace('/\D/', '', $params['iRg']));
                $model->setSexo($params['iSexo']);
                $model->setDataNascimento(helpers::formatDate($params['iDataNascimento']));
                $model->setIdEstado($cidade['idEstado']);
                $model->setUf($params['iEstado']);
                $model->setNomeCidade($cidade['nome']);
                $model->setIdCidade($cidade['idCidade']);
                $model->setCodigoIbge($cidade['codigoIbge']);
                $model->setDddCidade($cidade['ddd']);
                $model->setIdRegiao($cidade['idRegiao']);
                $model->setIdPopulacao($cidade['idPopulacao']);
                $model->setLogradouro($params['iLogradouro']);
                $model->setBairro($params['iBairro']);
                $model->setCep(preg_replace('/\D/', '', $params['iCep']));
                $model->setNumero($params['iNumero']);
                $model->setComplemento($params['iComplemento']);
                $model->setEmail($params['iEmail']);
                $model->setTelefone($params['iTelefone']);

                $idUsuario = $repository->salvarUsuario($model);

                if((int)$idUsuario > 0){
                    $idPessoaFisica = $repository->salvarPessoaFisica($model);

                    if((int)$idPessoaFisica > 0) {
                        $idEndereco = $repository->salvarEndereco($model);

                        if((int)$idEndereco > 0) {
                            $idEmail = $repository->salvarEmail($model);

                            if((int)$idEmail > 0) {
                                $sucess = $repository->salvarTelefone($model);

                                if($sucess) {
                                    $email = new emailService();
                                    $email->AddEmbeddedImage('blue.png', 'logotipo');

                                    $templateEmail = file_get_contents(__DIR__ . "/../email/templates/template.html");

                                    foreach ($params as $key => $val) {
                                        $templateEmail = str_replace('{{' . $key . '}}', $val, $templateEmail);
                                    }

                                    $email->setAssunto('Bem vindo(a) ao SIC');
                                    $email->addCopy([$params['iEmail']]);
                                    $email->addCopyHidden(['sicnotificacao@sicoficial.com.br']);
                                    $email->setConteudo($templateEmail);

                                    $statusEnvio = $email->enviarEmail($params['iEmail'], 'SIC');

                                    return $response->withJson([
                                        "status" => $statusEnvio,
                                        "resultSet" => [],
                                        "message" => ($statusEnvio) ? 'Operação realizada com sucesso.' : 'Não foi possível realizar esta ação, tente novamente mais tarde.'
                                    ], 200);
                                }
                            }
                        }
                    }
                }
            }

            return $response->withJson([
                "status" => false
            ])->withStatus(500);
        } catch (Exception $ex) {
            return $response->withJson([
                'status' => false,
                'message' =>  self::ERROR
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
            $repository = new sicPessoaRepository($conn);

            $cidade = $repository->obterCidadePeloIbge($params['iCidade']);

            $model = new sicPessoaModel();
            $model->setIdPessoa($params['idPessoa']);
            $model->setIdNivelAcesso($params['iNivelAcesso']);
            $model->setLogin($params['iLogin']);
            $model->setImg('/view/pages/assets/img/icon.png');
            $model->setDataCadastro(date('Y-m-d H:i:s'));
            $model->setNomePessoa($params['iNome']);
            $model->setCpf(preg_replace('/\D/', '', $params['iCpf']));
            $model->setRg(preg_replace('/\D/', '', $params['iRg']));
            $model->setSexo($params['iSexo']);
            $model->setDataNascimento(helpers::formatDate($params['iDataNascimento']));
            $model->setIdEstado($cidade['idEstado']);
            $model->setUf($params['iEstado']);
            $model->setNomeCidade($cidade['nome']);
            $model->setIdCidade($cidade['idCidade']);
            $model->setCodigoIbge($cidade['codigoIbge']);
            $model->setDddCidade($cidade['ddd']);
            $model->setIdRegiao($cidade['idRegiao']);
            $model->setIdPopulacao($cidade['idPopulacao']);
            $model->setLogradouro($params['iLogradouro']);
            $model->setBairro($params['iBairro']);
            $model->setCep(preg_replace('/\D/', '', $params['iCep']));
            $model->setNumero($params['iNumero']);
            $model->setComplemento($params['iComplemento']);
            $model->setEmail($params['iEmail']);
            $model->setTelefone($params['iTelefone']);

            $repository->editarEmail($model);

            return $response->withJson([
                "status" => true
            ])->withStatus(200);
        } catch (Exception $ex) {
            return $response->withJson([
                'status' => false,
                'message' =>  self::ERROR
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
            $repository = new sicPessoaRepository($conn);

            $model = new sicPessoaModel();
            $model->setIdPessoa($params['idPessoa']);

            $repository->excluir($model);

            return $response->withJson([
                "status" => true
            ])->withStatus(200);
        } catch (Exception $ex) {
            return $response->withJson([
                'status' => false,
                'message' =>  self::ERROR
            ],500);
        }
    }

    /**
     * Busca nivel de acesso
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function getNivelAcesso(Request $request, Response $response)
    {
        try {

            $conn = ConnectionPdo::getConnection();
            $repository = new sicPessoaRepository($conn);

            $dados = $repository->getNivelAcesso();

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
     * Busca cidades por estado
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function getCidadesPorEstado(Request $request, Response $response, array $args)
    {
        try {

            $params = $request->getQueryParams();

            $conn = ConnectionPdo::getConnection();
            $repository = new sicPessoaRepository($conn);

            $dados = $repository->getCidadesPorEstado($params);

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
            $repository = new sicPessoaRepository($conn);

            $model = new sicPessoaModel();
            $model->setIdPessoa($params['idPessoa']);
            $model->setStatusUsuario($params['status']);

            $dados = $repository->status($model);

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
     * Busca pessoas
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function getPessoas(Request $request, Response $response)
    {
        try {

            $conn = ConnectionPdo::getConnection();
            $repository = new sicPessoaRepository($conn);

            $dados = $repository->getPessoas();

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