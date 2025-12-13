<?php
/************************************************************
 * API de contatos 
 * Autor: Rebeka Marcelino
 * Data: 12/12/2025
 * Versão: 1.0
 ************************************************************/

// importações (require once -> garante que o arquivo seja carregado somente uma vez)
require_once __DIR__ . "/../config/database.php";
require_once __DIR__ . "/../config/mensagens.php";
require_once __DIR__ . "/../app/model/Contato.php";

// configuraçoes para http 
configurarCORS();

// requisição de teste
if (ehRequisicaoPreflight()) {
    responder(200);
}

// inicia...
$conexao = (new Database())->getConnection();
$contato = new Contato($conexao);

// métodos
$metodo = $_SERVER["REQUEST_METHOD"];
$id = $_GET["id"] ?? null;

// rotass
switch ($metodo) {
    case "GET":
        listarOuBuscar($contato, $id);
        break;
        
        //post nao precisa do id
    case "POST":
        criarContato($contato);
        break;
        
    case "PUT":
        atualizarContato($contato, $id);
        break;
        
    case "DELETE":
        deletarContato($contato, $id);
        break;
        
    default:
        responderComMensagem(ERRO_METODO_NAO_PERMITIDO);
}


// ////////////////////////
// FUNÇÕES
// ////////////////////////

//GET - Listar ou buscar

function listarOuBuscar($contato, $id) {
    if ($id) {
        $contato->id = $id;
        
        if ($contato->buscarPorId()) {
            $dados = formatarContato($contato);
            responderComMensagem(sucessoComDados($dados, "Contato encontrado"));
        } else {
            responderComMensagem(ERRO_NAO_ENCONTRADO);
        }
        //revisar
    } else {
        $resultado = $contato->listar();
        $lista = $resultado->fetchAll(PDO::FETCH_ASSOC);
        responderComMensagem(sucessoComDados($lista, "Contatos listados"));
    }
}

// POST - Criar

function criarContato($contato) {
    $dados = obterDadosRequisicao();
    
    // valida
    $erros = validarDados($dados);
    if (!empty($erros)) {
        responderComMensagem(erroValidacao($erros));
    }
    
    preencherContato($contato, $dados);
    
    if ($contato->criar()) {
        responderComMensagem(SUCESSO_CRIADO);
    } else {
        responderComMensagem(ERRO_SERVIDOR_MODEL);
    }
}

// PUT - Atualizar

function atualizarContato($contato, $id) {
    if (!$id) {
        responderComMensagem(ERRO_CAMPOS_OBRIGATORIOS);
    }
    
    $dados = obterDadosRequisicao();
    
    $erros = validarDados($dados);
    if (!empty($erros)) {
        responderComMensagem(erroValidacao($erros));
    }
    
    $contato->id = $id;
    preencherContato($contato, $dados);
    
    if ($contato->atualizar()) {
        responderComMensagem(SUCESSO_ATUALIZADO);
    } else {
        responderComMensagem(ERRO_SERVIDOR_MODEL);
    }
}

// DELETE - excluir

function deletarContato($contato, $id) {
    if (!$id) {
        responderComMensagem(ERRO_CAMPOS_OBRIGATORIOS);
    }
    
    $contato->id = $id;
    
    if ($contato->deletar()) {
        responderComMensagem(SUCESSO_DELETADO);
    } else {
        responderComMensagem(ERRO_SERVIDOR_MODEL);
    }
}


// /////////////////////////////
// + FUNÇÕES
// ////////////////////////////

//http que o angular pode acessar

function configurarCORS() {
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type, Authorization");
}

// verificação

function ehRequisicaoPreflight() {
    return $_SERVER["REQUEST_METHOD"] === "OPTIONS";
}

// le o body da requisição e converte para array 
function obterDadosRequisicao() {
    $json = file_get_contents("php://input");
    return json_decode($json, true) /* se der erro, retorna vazio -> */ ?? [];
}

// campos obrigatórios
function validarDados($dados) {
    $erros = [];
    
    if (empty($dados["nome_completo"])) {
        $erros[] = "Nome completo é obrigatório";
    }
    
    if (empty($dados["email"])) {
        $erros[] = "E-mail é obrigatório";
        // função nativa para validar email -filter_var
    } elseif (!filter_var($dados["email"], FILTER_VALIDATE_EMAIL)) {
        $erros[] = "E-mail inválido";
    }
    
    if (empty($dados["data_nascimento"])) {
        $erros[] = "Data de nascimento é obrigatória";
    }
    
    return $erros;
}

// preenche contato com os dados 
function preencherContato($contato, $dados) {
    $contato->nome_completo = $dados["nome_completo"];
    $contato->data_nascimento = $dados["data_nascimento"];
    $contato->email = $dados["email"];
    $contato->profissao = $dados["profissao"] ?? "";
    $contato->telefone = $dados["telefone"] ?? "";
    $contato->celular = $dados["celular"] ?? "";
    $contato->possui_whatsapp = $dados["possui_whatsapp"] ?? false;
    $contato->notificacao_sms = $dados["notificacao_sms"] ?? false;
    $contato->notificacao_email = $dados["notificacao_email"] ?? false;
}

// formatar 
function formatarContato($contato) {
    return [
        "id" => $contato->id,
        "nome_completo" => $contato->nome_completo,
        "data_nascimento" => $contato->data_nascimento,
        "email" => $contato->email,
        "profissao" => $contato->profissao,
        "telefone" => $contato->telefone,
        "celular" => $contato->celular,
        "possui_whatsapp" => (bool) $contato->possui_whatsapp,
        "notificacao_sms" => (bool) $contato->notificacao_sms,
        "notificacao_email" => (bool) $contato->notificacao_email
    ];
}

//resposta
 function responder($codigo) {
    http_response_code($codigo);
    exit;
}

// 
function responderComMensagem($mensagem) {
    http_response_code($mensagem["status_code"]);
    echo json_encode($mensagem);
    exit;
}