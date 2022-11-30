<?php

namespace app\src\classes\modules\controller;

use app\src\classes\modules\config\ConnectionPDO;
use app\src\classes\modules\model\sicPessoaModel;
use app\src\classes\modules\repository\sicMeuPerfilRepository;
use app\src\classes\modules\repository\sicPessoaRepository;
use app\src\classes\modules\service\sicService;
use app\src\classes\modules\utils\helpers;
use Exception;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Views\PhpRenderer;

require_once __DIR__ . "/../config/ConnectionPdo.php";

class sicMeuPerfilController
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
     * Meu Perfil
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function viewMeuPerfil(Request $request, Response $response, array $args)
    {
        session_start();

        $dadosTela = [
            'title' => 'SIC - Sistema Interno Corporativo - Meu Perfil',
            'adminSIC' => sicService::adminSIC(),
        ];

        return $this->phpview->render($response, '/pages/meu-perfil.php', $dadosTela);
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

            $conn = ConnectionPdo::getConnection();
            $repository = new sicPessoaRepository($conn);

            session_start();
            $params['idPessoa'] = $_SESSION['idPessoa'];

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
}