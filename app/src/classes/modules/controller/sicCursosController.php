<?php

namespace app\src\classes\modules\controller;

use app\src\classes\modules\config\ConnectionPDO;
use app\src\classes\modules\exception\sicCursosException;
use app\src\classes\modules\model\sicCursosModel;
use app\src\classes\modules\repository\sicCursosRepository;
use app\src\classes\modules\service\sicService;
use app\src\classes\modules\utils\helpers;
use app\src\classes\modules\utils\UploadFile;
use Exception;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Http\UploadedFile;
use Slim\Views\PhpRenderer;

require_once __DIR__ . "/../config/ConnectionPdo.php";

class sicCursosController
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
     * Meus Cursos
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function viewMeusCursos(Request $request, Response $response, array $args)
    {
        session_start();

        $dadosTela = [
            'title' => 'SIC - Sistema Interno Corporativo - Visualizar Cursos',
            'adminSIC' => sicService::adminSIC()
        ];

        return $this->phpview->render($response, '/pages/meus-cursos.php', $dadosTela);
    }

    /**
     * Cursos - Detalhes
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function viewDetalhes(Request $request, Response $response, array $args)
    {
        session_start();

        $dadosTela = [
            'title' => 'SIC - Sistema Interno Corporativo - Cursos / Detalhes',
            'adminSIC' => sicService::adminSIC(),
        ];

        return $this->phpview->render($response, '/pages/detalhes.php', $dadosTela);
    }

    /**
     * Gerenciamento Cursos
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function viewGerenciamentoCursos(Request $request, Response $response, array $args)
    {
        session_start();

        if (!sicService::adminSIC()) {
            header('Location: /cursos/meus-cursos');
            die();
        }

        $dadosTela = [
            'title' => 'SIC - Sistema Interno Corporativo - Cursos',
            'adminSIC' => sicService::adminSIC(),
        ];

        return $this->phpview->render($response, '/pages/gerenciamento/cursos.php', $dadosTela);
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
            $repository = new sicCursosRepository($conn);

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
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function salvar(Request $request, Response $response)
    {
        try {

            session_start();

            $params = $request->getParsedBody();
            $arquivos = $request->getUploadedFiles();

            $conn = ConnectionPdo::getConnection();
            $repository = new sicCursosRepository($conn);

            $enderecoUpload = "/cursos";

            /**
             * @var $arquivos UploadedFile
             */
            $documentos[] = $arquivos['iFoto'];

            foreach ($documentos as $key => $item){
                /**
                 * @var $file UploadedFile
                 */
                $file = $item[$key];

                $upload = new UploadFile();
                $upload->setFile($file);
                $upload->setNameFile($file->getClientFilename());
                $extensao = strtolower($upload->getExtencao());

                if (!in_array($extensao, ['jpg', 'gif', 'png', 'bmp', 'jpeg'])) {
                    throw new sicCursosException(1);
                }

                $status = $upload->upload($enderecoUpload);

                if(!$status){
                    throw new sicCursosException(2);
                }

                $enviarAnexos = '/storage' . $upload->getLocation() .'/'. $upload->getNewname();

                $dataI = (isset($params['iDataInicio'])) ? helpers::converFormatDate($params['iDataInicio'], 'd/m/Y','Y-m-d') : '';
                $dataF = (isset($params['iDataFim'])) ? helpers::converFormatDate($params['iDataFim'], 'd/m/Y','Y-m-d') : '';
                $pessoa = (int) $params['iPessoa'] ? $params['iPessoa'] : $_SESSION['idPessoa'];

                $model = new sicCursosModel();
                $model->setIdCategorias($params['iCategoria']);
                $model->setIdPessoa($pessoa);
                $model->setNome($params['iNome']);
                $model->setDescricao($params['iDescricao']);
                $model->setimg($enviarAnexos);
                $model->setDataCadastro(date('Y-m-d H:i:s'));
                $model->setHoras($params['iHoras']);
                $model->setDataInicio($dataI);
                $model->setDataFim($dataF);
                $model->setStatus(1);

                $dados = $repository->salvar($model);
            }

            return $response->withJson([
                "status" => true,
                'resultSet' => helpers::convertUTF8($dados)
            ])->withStatus(200);
        } catch (sicCursosException $e) {
            return $response->withJson([
                'status' => false, 'message' => $e->getMessage()
            ], 500);
        }catch (Exception $e) {
            return $response->withJson([
                "status" => true,
                "resultSet" => $e->getMessage()
            ], 500);
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

            session_start();

            $params = $request->getParsedBody();
            $arquivos = $request->getUploadedFiles();

            $conn = ConnectionPdo::getConnection();
            $repository = new sicCursosRepository($conn);

            $enderecoUpload = "/cursos";

            /**
             * @var $arquivos UploadedFile
             */
            $documentos[] = $arquivos['iFoto'];

            foreach ($documentos as $key => $item){
                /**
                 * @var $file UploadedFile
                 */
                $file = $item[$key];

                $upload = new UploadFile();
                $upload->setFile($file);
                $upload->setNameFile($file->getClientFilename());
                $extensao = strtolower($upload->getExtencao());

                if (!in_array($extensao, ['jpg', 'gif', 'png', 'bmp', 'jpeg'])) {
                    throw new sicCursosException(1);
                }

                $status = $upload->upload($enderecoUpload);

                if(!$status){
                    throw new sicCursosException(2);
                }

                $enviarAnexos = '/storage' . $upload->getLocation() .'/'. $upload->getNewname();

                $dataI = (isset($params['iDataInicio'])) ? helpers::converFormatDate($params['iDataInicio'], 'd/m/Y','Y-m-d') : '';
                $dataF = (isset($params['iDataFim'])) ? helpers::converFormatDate($params['iDataFim'], 'd/m/Y','Y-m-d') : '';
                $pessoa = (int) $params['iPessoa'] ? $params['iPessoa'] : $_SESSION['idPessoa'];

                $model = new sicCursosModel();
                $model->setIdCursos($params['idCursos']);
                $model->setIdCategorias($params['iCategoria']);
                $model->setIdPessoa($pessoa);
                $model->setNome($params['iNome']);
                $model->setDescricao($params['iDescricao']);
                $model->setimg($enviarAnexos);
                $model->setHoras($params['iHoras']);
                $model->setDataInicio($dataI);
                $model->setDataFim($dataF);

                $dados = $repository->editar($model);
            }

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
            $repository = new sicCursosRepository($conn);

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
            $repository = new sicCursosRepository($conn);

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
     * Busca cursos
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function getCursos(Request $request, Response $response)
    {
        try {

            $conn = ConnectionPdo::getConnection();
            $repository = new sicCursosRepository($conn);

            $dados = $repository->getCursos();

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