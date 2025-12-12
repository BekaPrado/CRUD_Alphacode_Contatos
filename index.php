<?php

require_once __DIR__ . "/app/controllers/ContatoController.php";

$controller = new ContatoController();

// Roteamento simples
$acao = $_GET["acao"] ?? "index";
$id = $_GET["id"] ?? null;

switch ($acao) {
    case "index":
        $controller->index();
        break;

    case "criar":
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $resultado = $controller->salvar($_POST);
            if ($resultado["sucesso"]) {
                header("Location: index.php?acao=index&msg=criado");
                exit;
            } else {
                $erros = $resultado["erros"];
                require_once __DIR__ . "/app/views/contatos/criar.php";
            }
        } else {
            require_once __DIR__ . "/app/views/contatos/criar.php";
        }
        break;

    case "editar":
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $resultado = $controller->atualizar($id, $_POST);
            if ($resultado["sucesso"]) {
                header("Location: index.php?acao=index&msg=atualizado");
                exit;
            } else {
                $erros = $resultado["erros"];
            }
        }
        $controller->editar($id);
        break;

    case "deletar":
        $controller->deletar($id);
        header("Location: index.php?acao=index&msg=deletado");
        exit;
        break;

    default:
        $controller->index();
        break;
}