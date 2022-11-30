<?php

use app\src\classes\modules\controller\sicCategoriasController;
use app\src\classes\modules\controller\sicConfigurarPermissoesController;
use app\src\classes\modules\controller\sicController;
use app\src\classes\modules\controller\sicCursosController;
use app\src\classes\modules\controller\sicEventosController;
use app\src\classes\modules\controller\sicMeuPerfilController;
use app\src\classes\modules\controller\sicMidiasController;
use app\src\classes\modules\controller\sicPainelGestaoController;
use app\src\classes\modules\controller\sicTreinamentosController;
use app\src\classes\modules\controller\sicPessoaController;

/**
 * Login
 */
$app->get('/',
    sicController::class . ':viewLogin');

$app->get('/esqueci-senha',
    sicController::class . ':viewEsqueciSenha');

/**
 * Logout
 */
$app->get('/logout',
    sicController::class . ':logout');

/**
 * Painel de Gestão
 */
$app->get('/painel-gestao[/]',
    sicPainelGestaoController::class . ':viewPainelGestao');

/**
 * Cursos
 */
$app->get('/cursos/meus-cursos[/]',
    sicCursosController::class . ':viewMeusCursos');

$app->get('/cursos/meus-cursos/detalhes[/]',
    sicCursosController::class . ':viewDetalhes');

/**
 * Treinamentos
 */
$app->get('/treinamentos/meus-treinamentos[/]',
    sicTreinamentosController::class . ':viewTreinamentos');

$app->get('/treinamentos/meus-treinamentos/detalhes[/]',
    sicTreinamentosController::class . ':viewTreinamentosDetalhes');

/**
 * Eventos
 */
$app->get('/eventos[/]',
    sicEventosController::class . ':viewEventos');

/**
 * Gerenciamento
 */
$app->get('/gerenciamento/configurar-permissoes',
    sicConfigurarPermissoesController::class . ':viewConfigurarPermissoes');

$app->get('/gerenciamento/pessoa',
    sicPessoaController::class . ':viewGerenciamentoPessoa');

$app->get('/gerenciamento/categorias',
    sicCategoriasController::class . ':viewGerenciamentoCategorias');

$app->get('/gerenciamento/cursos',
    sicCursosController::class . ':viewGerenciamentoCursos');

$app->get('/gerenciamento/treinamentos',
    sicTreinamentosController::class . ':viewGerenciamentoTreinamentos');

$app->get('/gerenciamento/eventos',
    sicEventosController::class . ':viewGerenciamentoEventos');

$app->get('/gerenciamento/midias',
    sicMidiasController::class . ':viewGerenciamentoMidias');

/**
 * Meu Perfil
 */
$app->get('/meu-perfil[/]',
    sicMeuPerfilController::class . ':viewMeuPerfil');