<?php
/************************************************************
 * Padronização de mensagens de Respostas da API
 * Autor: Rebeka Marcelino
 * Data: 12/12/2025
 * Versão: 1.0
 ************************************************************/


// ////////////////////////////////////////////
// STATUS CODE DE MENSAGENS DE ERRO
// ////////////////////////////////////////////

const ERRO_CAMPOS_OBRIGATORIOS = [
    "status" => false, "status_code" => 400, "mensagem" => "Algum campo obrigatório não foi preenchido"
];

const ERRO_VALIDACAO = [
    "status" => false, "status_code" => 400, "mensagem" => "Os dados enviados são inválidos"
];

const ERRO_NAO_ENCONTRADO = [
    "status" => false, "status_code" => 404, "mensagem" => "Cadastro não foi encontrado"
];

const ERRO_METODO_NAO_PERMITIDO = [
    "status" => false, "status_code" => 405, "mensagem" => "Rota não permitida"
];

const ERRO_TIPO_CONTEUDO = [
    "status" => false, "status_code" => 415, "mensagem" => "Erro no formato enviado dos dados!!!"
];

const ERRO_SERVIDOR_MODEL = [
    "status" => false, "status_code" => 500, "mensagem" => "Erro interno na MODEL !"
];

const ERRO_BANCO_DADOS = [
    "status" => false, "status_code" => 500, "mensagem" => "Erro com banco de dados"
];


// /////////////////////////////////
// MENSAGENS DE SUCESSO
// /////////////////////////////////

const SUCESSO_LISTAGEM = [
    "status" => true, "status_code" => 200, "mensagem" => "Cadastrado com Sucesso ! "
];

const SUCESSO_BUSCA = [
    "status" => true, "status_code" => 200, "mensagem" => "Contatos Encontrados com sucesso"
];

const SUCESSO_CRIADO = [
    "status" => true, "status_code" => 201, "mensagem" => "Cadastrado! "
];

const SUCESSO_ATUALIZADO = [
    "status" => true, "status_code" => 200, "mensagem" => "Contato atualizado com sucesso"
];

const SUCESSO_DELETADO = [
    "status" => true, "status_code" => 200, "mensagem" => "Contato Deteletado com Sucesso"
];


// /////////////////////////////////////
// FUNÇÕES AUXILIARES (revisar)
// ////////////////////////////////////

// Monta resposta de erro com erros de validação customizados

function erroValidacao($erros) {
    return [
        "status" => false,
        "status_code" => 400,
        "mensagem" => "Erro de validação",
        "erros" => $erros
    ];
}


// Monta resposta de sucesso com dados
function sucessoComDados($dados, $mensagem = "Operação realizada com sucesso") {
    return [
        "status" => true,
        "status_code" => 200,
        "mensagem" => $mensagem,
        "dados" => $dados
    ];
}


// Monta resposta de sucesso para criação com dados
 
function sucessoCriadoComDados($dados) {
    return [
        "status" => true,
        "status_code" => 201,
        "mensagem" => "Registro criado com sucesso",
        "dados" => $dados
    ];
}