<?php

use app\src\classes\modules\controller\sicCategoriasController;
use app\src\classes\modules\controller\sicConfigurarPermissoesController;
use app\src\classes\modules\controller\sicCursosController;
use app\src\classes\modules\controller\sicEventosController;
use app\src\classes\modules\controller\sicLoginController;
use app\src\classes\modules\controller\sicMeuPerfilController;
use app\src\classes\modules\controller\sicMidiasController;
use app\src\classes\modules\controller\sicPessoaController;
use app\src\classes\modules\controller\sicTreinamentosController;
use Slim\App;

/**
 * @var $app App
 */

/**
 * Login
 */
$app->group('/api/login', function () use ($app) {
    $app->post('/findLogin',
        sicLoginController::class . ':findLogin');

    $app->get('/getEsqueciSenha',
        sicLoginController::class . ':getEsqueciSenha');
});

/**
 * Gerenciamento de Permissões
 */
$app->group('/api/permissoes', function () use ($app) {
    $app->get('/consultar',
        sicConfigurarPermissoesController::class . ':consultar');

    $app->post('/salvar',
        sicConfigurarPermissoesController::class . ':salvar');

    $app->post('/editar',
        sicConfigurarPermissoesController::class . ':editar');

    $app->post('/excluir',
        sicConfigurarPermissoesController::class . ':excluir');
});

/**
 * Gerenciamento de Pessoas
 */
$app->group('/api/pessoa', function () use ($app) {
    $app->get('/consultar',
        sicPessoaController::class . ':consultar');

    $app->post('/salvar',
        sicPessoaController::class . ':salvar');

    $app->post('/editar',
        sicPessoaController::class . ':editar');

    $app->post('/excluir',
        sicPessoaController::class . ':excluir');

    $app->get('/getNivelAcesso',
        sicPessoaController::class . ':getNivelAcesso');

    $app->get('/getCidadesPorEstado',
        sicPessoaController::class . ':getCidadesPorEstado');

    $app->get('/status',
        sicPessoaController::class . ':status');

    $app->get('/getPessoas',
        sicPessoaController::class . ':getPessoas');
});

/**
 * Meu Perfil
 */
$app->group('/api/meu-perfil', function () use ($app) {
    $app->get('/consultar',
        sicMeuPerfilController::class . ':consultar');

    $app->post('/editar',
        sicMeuPerfilController::class . ':editar');
});

/**
 * Categorias
 */
$app->group('/api/categorias', function () use ($app) {
    $app->get('/consultar',
        sicCategoriasController::class . ':consultar');

    $app->post('/salvar',
        sicCategoriasController::class . ':salvar');

    $app->post('/editar',
        sicCategoriasController::class . ':editar');

    $app->post('/excluir',
        sicCategoriasController::class . ':excluir');

    $app->get('/status',
        sicCategoriasController::class . ':status');

    $app->get('/getCategorias',
        sicCategoriasController::class . ':getCategorias');
});

/**
 * Cursos
 */
$app->group('/api/cursos', function () use ($app) {
    $app->get('/consultar',
        sicCursosController::class . ':consultar');

    $app->post('/salvar',
        sicCursosController::class . ':salvar');

    $app->post('/editar',
        sicCursosController::class . ':editar');

    $app->post('/excluir',
        sicCursosController::class . ':excluir');

    $app->get('/status',
        sicCursosController::class . ':status');

    $app->get('/getCursos',
        sicCursosController::class . ':getCursos');
});

/**
 * Treinamentos
 */
$app->group('/api/treinamentos', function () use ($app) {
    $app->get('/consultar',
        sicTreinamentosController::class . ':consultar');

    $app->post('/salvar',
        sicTreinamentosController::class . ':salvar');

    $app->post('/editar',
        sicTreinamentosController::class . ':editar');

    $app->post('/excluir',
        sicTreinamentosController::class . ':excluir');

    $app->get('/status',
        sicTreinamentosController::class . ':status');
});

/**
 * Eventos
 */
$app->group('/api/eventos', function () use ($app) {
    $app->get('/consultar',
        sicEventosController::class . ':consultar');

    $app->post('/salvar',
        sicEventosController::class . ':salvar');

    $app->post('/editar',
        sicEventosController::class . ':editar');

    $app->post('/excluir',
        sicEventosController::class . ':excluir');

    $app->get('/status',
        sicEventosController::class . ':status');
});

/**
 * Mídias
 */
$app->group('/api/midias', function () use ($app) {
    $app->get('/consultar',
        sicMidiasController::class . ':consultar');

    $app->post('/salvar',
        sicMidiasController::class . ':salvar');

    $app->post('/editar',
        sicMidiasController::class . ':editar');

    $app->post('/excluir',
        sicMidiasController::class . ':excluir');

    $app->get('/status',
        sicMidiasController::class . ':status');
});