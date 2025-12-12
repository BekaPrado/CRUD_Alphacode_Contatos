<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Trata requisições OPTIONS (preflight do CORS)
if ($_SERVER["REQUEST_METHOD"] == "OPTIONS") {
    http_response_code(200);
    exit;
}

require_once __DIR__ . "/../config/database.php";
require_once __DIR__ . "/../app/model/Contato.php";

$database = new Database();
$db = $database->getConnection();
$contato = new Contato($db);

$method = $_SERVER["REQUEST_METHOD"];
$id = $_GET["id"] ?? null;

switch ($method) {
    case "GET":
        if ($id) {
            // Buscar um contato
            $contato->id = $id;
            if ($contato->buscarPorId()) {
                http_response_code(200);
                echo json_encode([
                    "id" => $contato->id,
                    "nome_completo" => $contato->nome_completo,
                    "data_nascimento" => $contato->data_nascimento,
                    "email" => $contato->email,
                    "profissao" => $contato->profissao,
                    "telefone" => $contato->telefone,
                    "celular" => $contato->celular,
                    "possui_whatsapp" => (bool)$contato->possui_whatsapp,
                    "notificacao_sms" => (bool)$contato->notificacao_sms,
                    "notificacao_email" => (bool)$contato->notificacao_email
                ]);
            } else {
                http_response_code(404);
                echo json_encode(["mensagem" => "Contato não encontrado."]);
            }
        } else {
            // Listar todos
            $stmt = $contato->listar();
            $contatos = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            http_response_code(200);
            echo json_encode($contatos);
        }
        break;

    case "POST":
        $dados = json_decode(file_get_contents("php://input"), true);
        
        $erros = validar($dados);
        if (!empty($erros)) {
            http_response_code(400);
            echo json_encode(["erros" => $erros]);
            break;
        }

        $contato->nome_completo = $dados["nome_completo"];
        $contato->data_nascimento = $dados["data_nascimento"];
        $contato->email = $dados["email"];
        $contato->profissao = $dados["profissao"] ?? "";
        $contato->telefone = $dados["telefone"] ?? "";
        $contato->celular = $dados["celular"] ?? "";
        $contato->possui_whatsapp = $dados["possui_whatsapp"] ?? false;
        $contato->notificacao_sms = $dados["notificacao_sms"] ?? false;
        $contato->notificacao_email = $dados["notificacao_email"] ?? false;

        if ($contato->criar()) {
            http_response_code(201);
            echo json_encode(["mensagem" => "Contato criado com sucesso."]);
        } else {
            http_response_code(500);
            echo json_encode(["mensagem" => "Erro ao criar contato."]);
        }
        break;

    case "PUT":
        if (!$id) {
            http_response_code(400);
            echo json_encode(["mensagem" => "ID é obrigatório."]);
            break;
        }

        $dados = json_decode(file_get_contents("php://input"), true);
        
        $erros = validar($dados);
        if (!empty($erros)) {
            http_response_code(400);
            echo json_encode(["erros" => $erros]);
            break;
        }

        $contato->id = $id;
        $contato->nome_completo = $dados["nome_completo"];
        $contato->data_nascimento = $dados["data_nascimento"];
        $contato->email = $dados["email"];
        $contato->profissao = $dados["profissao"] ?? "";
        $contato->telefone = $dados["telefone"] ?? "";
        $contato->celular = $dados["celular"] ?? "";
        $contato->possui_whatsapp = $dados["possui_whatsapp"] ?? false;
        $contato->notificacao_sms = $dados["notificacao_sms"] ?? false;
        $contato->notificacao_email = $dados["notificacao_email"] ?? false;

        if ($contato->atualizar()) {
            http_response_code(200);
            echo json_encode(["mensagem" => "Contato atualizado com sucesso."]);
        } else {
            http_response_code(500);
            echo json_encode(["mensagem" => "Erro ao atualizar contato."]);
        }
        break;

    case "DELETE":
        if (!$id) {
            http_response_code(400);
            echo json_encode(["mensagem" => "ID é obrigatório."]);
            break;
        }

        $contato->id = $id;

        if ($contato->deletar()) {
            http_response_code(200);
            echo json_encode(["mensagem" => "Contato deletado com sucesso."]);
        } else {
            http_response_code(500);
            echo json_encode(["mensagem" => "Erro ao deletar contato."]);
        }
        break;

    default:
        http_response_code(405);
        echo json_encode(["mensagem" => "Método não permitido."]);
        break;
}

function validar($dados) {
    $erros = [];

    if (empty($dados["nome_completo"])) {
        $erros[] = "Nome completo é obrigatório.";
    }

    if (empty($dados["email"])) {
        $erros[] = "E-mail é obrigatório.";
    } elseif (!filter_var($dados["email"], FILTER_VALIDATE_EMAIL)) {
        $erros[] = "E-mail inválido.";
    }

    if (empty($dados["data_nascimento"])) {
        $erros[] = "Data de nascimento é obrigatória.";
    }

    return $erros;
}
