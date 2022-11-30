<?php

namespace app\src\classes\modules\controller;

use app\src\classes\modules\config\ConnectionPDO;
use app\src\classes\modules\exception\sicMidiasException;
use app\src\classes\modules\model\sicMidiasModel;
use app\src\classes\modules\repository\sicMidiasRepository;
use app\src\classes\modules\service\sicService;
use app\src\classes\modules\utils\helpers;
use app\src\classes\modules\utils\uploadFile;
use Exception;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Http\UploadedFile;
use Slim\Views\PhpRenderer;

require_once __DIR__ . "/../config/ConnectionPdo.php";

class sicMidiasController
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
     * Gerenciamento Mídias
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function viewGerenciamentoMidias(Request $request, Response $response, array $args)
    {
        session_start();

        if (!sicService::adminSIC()) {
            header('Location: /cursos/meus-cursos');
            die();
        }

        $dadosTela = [
            'title' => 'SIC - Sistema Interno Corporativo - Mídias',
            'adminSIC' => sicService::adminSIC(),
        ];

        return $this->phpview->render($response, '/pages/gerenciamento/midias.php', $dadosTela);
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
            $repository = new sicMidiasRepository($conn);

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

            error_reporting(E_ALL);
            ini_set("display_errors", 1);

            session_start();

            $params = $request->getParsedBody();
            $arquivos = $request->getUploadedFiles();

            $conn = ConnectionPdo::getConnection();
            $repository = new sicMidiasRepository($conn);

            $enderecoUpload = "/midias";

            $model = new sicMidiasModel();

            /**
             * @var $arquivos UploadedFile
             */
            $documentos[] = $arquivos['iArquivo'];

            foreach ($documentos as $key => $item){
                /**
                 * @var $file UploadedFile
                 */
                $file = $item[$key];

                $upload = new UploadFile();
                $upload->setFile($file);
                $upload->setNameFile($file->getClientFilename());
                $extensao = strtolower($upload->getExtencao());

                if (!in_array($extensao, ['mp4'])) {
                    throw new sicMidiasException(1);
                }

                $status = $upload->upload($enderecoUpload);

                if(!$status){
                    throw new sicMidiasException(2);
                }

                $enviarAnexos = '/storage' . $upload->getLocation() .'/'. $upload->getNewname();

                $model = new sicMidiasModel();
                $model->setIdCursos($params['iCursos']);
                $model->setNome($params['iNome']);
                $model->setUrl($params['iUrl']);
                $model->setArquivo($enviarAnexos);
                $model->setDataCadastro(date('Y-m-d H:i:s'));
                $model->setStatus(1);

                $dados = $repository->salvar($model);
            }

            return $response->withJson([
                "status" => true,
                'resultSet' => helpers::convertUTF8($dados)
            ])->withStatus(200);
        } catch (sicMidiasException $e) {
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
            $repository = new sicMidiasRepository($conn);

            $enderecoUpload = "/midias";
            $enviarAnexos = '';

            /**
             * @var $arquivos UploadedFile
             */
            $documentos[] = $arquivos['iArquivo'];

            foreach ($documentos as $key => $item){
                if (empty($item[$key])) {
                    /**
                     * @var $file UploadedFile
                     */
                    $file = $item[$key];

                    $upload = new UploadFile();
                    $upload->setFile($file);
                    $upload->setNameFile($file->getClientFilename());
                    $extensao = strtolower($upload->getExtencao());

                    if (!in_array($extensao, ['mp4'])) {
                        throw new sicMidiasException(1);
                    }

                    $status = $upload->upload($enderecoUpload);

                    if(!$status){
                        throw new sicMidiasException(2);
                    }

                    $enviarAnexos = '/storage' . $upload->getLocation() .'/'. $upload->getNewname();
                }

                $model = new sicMidiasModel();
                $model->setIdMidias($params['idMidias']);
                $model->setIdCursos($params['iCursos']);
                $model->setNome($params['iNome']);
                $model->setUrl($params['iUrl']);
                $model->setArquivo($enviarAnexos);

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
            $repository = new sicMidiasRepository($conn);

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
            $repository = new sicMidiasRepository($conn);

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
}