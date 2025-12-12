<?php

require_once __DIR__ . "/../../config/database.php";
require_once __DIR__ . "/../model/Contato.php";

class ContatoController {
    private $db;
    private $contato;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->contato = new Contato($this->db);
    }

    // Listar todos os contatos
    public function index() {
        $stmt = $this->contato->listar();
        $contatos = $stmt->fetchAll(PDO::FETCH_ASSOC);
        require_once __DIR__ . "/../views/contatos/index.php";
    }

    // Exibir formulário de criação
    public function criar() {
        require_once __DIR__ . "/../views/contatos/criar.php";
    }

    // Salvar novo contato
    public function salvar($dados) {
        $erros = $this->validar($dados);

        if (!empty($erros)) {
            return ["sucesso" => false, "erros" => $erros];
        }

        $this->contato->nome_completo = $dados["nome_completo"];
        $this->contato->data_nascimento = $dados["data_nascimento"];
        $this->contato->email = $dados["email"];
        $this->contato->profissao = $dados["profissao"] ?? "";
        $this->contato->telefone = $dados["telefone"] ?? "";
        $this->contato->celular = $dados["celular"] ?? "";
        $this->contato->possui_whatsapp = isset($dados["possui_whatsapp"]) ? 1 : 0;
        $this->contato->notificacao_sms = isset($dados["notificacao_sms"]) ? 1 : 0;
        $this->contato->notificacao_email = isset($dados["notificacao_email"]) ? 1 : 0;

        if ($this->contato->criar()) {
            return ["sucesso" => true];
        }

        return ["sucesso" => false, "erros" => ["Erro ao salvar contato."]];
    }

    // Exibir formulário de edição
    public function editar($id) {
        $this->contato->id = $id;
        
        if ($this->contato->buscarPorId()) {
            $contato = $this->contato;
            require_once __DIR__ . "/../views/contatos/editar.php";
        } else {
            header("Location: index.php");
            exit;
        }
    }

    // Atualizar contato
    public function atualizar($id, $dados) {
        $erros = $this->validar($dados);

        if (!empty($erros)) {
            return ["sucesso" => false, "erros" => $erros];
        }

        $this->contato->id = $id;
        $this->contato->nome_completo = $dados["nome_completo"];
        $this->contato->data_nascimento = $dados["data_nascimento"];
        $this->contato->email = $dados["email"];
        $this->contato->profissao = $dados["profissao"] ?? "";
        $this->contato->telefone = $dados["telefone"] ?? "";
        $this->contato->celular = $dados["celular"] ?? "";
        $this->contato->possui_whatsapp = isset($dados["possui_whatsapp"]) ? 1 : 0;
        $this->contato->notificacao_sms = isset($dados["notificacao_sms"]) ? 1 : 0;
        $this->contato->notificacao_email = isset($dados["notificacao_email"]) ? 1 : 0;

        if ($this->contato->atualizar()) {
            return ["sucesso" => true];
        }

        return ["sucesso" => false, "erros" => ["Erro ao atualizar contato."]];
    }

    // Deletar contato
    public function deletar($id) {
        $this->contato->id = $id;
        
        if ($this->contato->deletar()) {
            return ["sucesso" => true];
        }

        return ["sucesso" => false];
    }

    // Validações
    private function validar($dados) {
        $erros = [];

        // Nome obrigatório
        if (empty($dados["nome_completo"])) {
            $erros[] = "Nome completo é obrigatório.";
        }

        // Email obrigatório e válido
        if (empty($dados["email"])) {
            $erros[] = "E-mail é obrigatório.";
        } elseif (!filter_var($dados["email"], FILTER_VALIDATE_EMAIL)) {
            $erros[] = "E-mail inválido.";
        }

        // Data de nascimento obrigatória
        if (empty($dados["data_nascimento"])) {
            $erros[] = "Data de nascimento é obrigatória.";
        }

        // Validar formato do telefone (opcional)
        if (!empty($dados["telefone"]) && !preg_match("/^\(\d{2}\)\s?\d{4,5}-?\d{4}$/", $dados["telefone"])) {
            $erros[] = "Telefone inválido. Use o formato (11) 4033-2019.";
        }

        // Validar formato do celular (opcional)
        if (!empty($dados["celular"]) && !preg_match("/^\(\d{2}\)\s?\d{4,5}-?\d{4}$/", $dados["celular"])) {
            $erros[] = "Celular inválido. Use o formato (11) 98493-2039.";
        }

        return $erros;
    }
}