<?php

class Contato {
    private $conn;
    private $table = "contatos";

    public $id;
    public $nome_completo;
    public $data_nascimento;
    public $email;
    public $profissao;
    public $telefone;
    public $celular;
    public $possui_whatsapp;
    public $notificacao_sms;
    public $notificacao_email;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function listar() {
        $query = "SELECT * FROM " . $this->table . " ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function buscarPorId() {
        $query = "SELECT * FROM " . $this->table . " WHERE id = :id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $this->id);
        $stmt->execute();
        
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($row) {
            $this->nome_completo = $row['nome_completo'];
            $this->data_nascimento = $row['data_nascimento'];
            $this->email = $row['email'];
            $this->profissao = $row['profissao'];
            $this->telefone = $row['telefone'];
            $this->celular = $row['celular'];
            $this->possui_whatsapp = $row['possui_whatsapp'];
            $this->notificacao_sms = $row['notificacao_sms'];
            $this->notificacao_email = $row['notificacao_email'];
            return true;
        }
        
        return false;
    }

    public function criar() {
        $query = "INSERT INTO " . $this->table . " 
                  (nome_completo, data_nascimento, email, profissao, telefone, celular, possui_whatsapp, notificacao_sms, notificacao_email)
                  VALUES 
                  (:nome_completo, :data_nascimento, :email, :profissao, :telefone, :celular, :possui_whatsapp, :notificacao_sms, :notificacao_email)";

        $stmt = $this->conn->prepare($query);

        $this->nome_completo = htmlspecialchars(strip_tags($this->nome_completo));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->profissao = htmlspecialchars(strip_tags($this->profissao ?? ''));
        $this->telefone = htmlspecialchars(strip_tags($this->telefone ?? ''));
        $this->celular = htmlspecialchars(strip_tags($this->celular ?? ''));
        
        // Converter boolean pra inteiro
        $possui_whatsapp = $this->possui_whatsapp ? 1 : 0;
        $notificacao_sms = $this->notificacao_sms ? 1 : 0;
        $notificacao_email = $this->notificacao_email ? 1 : 0;

        $stmt->bindParam(":nome_completo", $this->nome_completo);
        $stmt->bindParam(":data_nascimento", $this->data_nascimento);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":profissao", $this->profissao);
        $stmt->bindParam(":telefone", $this->telefone);
        $stmt->bindParam(":celular", $this->celular);
        $stmt->bindParam(":possui_whatsapp", $possui_whatsapp);
        $stmt->bindParam(":notificacao_sms", $notificacao_sms);
        $stmt->bindParam(":notificacao_email", $notificacao_email);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    public function atualizar() {
        $query = "UPDATE " . $this->table . " SET
                  nome_completo = :nome_completo,
                  data_nascimento = :data_nascimento,
                  email = :email,
                  profissao = :profissao,
                  telefone = :telefone,
                  celular = :celular,
                  possui_whatsapp = :possui_whatsapp,
                  notificacao_sms = :notificacao_sms,
                  notificacao_email = :notificacao_email
                  WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        $this->nome_completo = htmlspecialchars(strip_tags($this->nome_completo));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->profissao = htmlspecialchars(strip_tags($this->profissao ?? ''));
        $this->telefone = htmlspecialchars(strip_tags($this->telefone ?? ''));
        $this->celular = htmlspecialchars(strip_tags($this->celular ?? ''));

        // Converter boolean pra inteiro
        $possui_whatsapp = $this->possui_whatsapp ? 1 : 0;
        $notificacao_sms = $this->notificacao_sms ? 1 : 0;
        $notificacao_email = $this->notificacao_email ? 1 : 0;

        $stmt->bindParam(":nome_completo", $this->nome_completo);
        $stmt->bindParam(":data_nascimento", $this->data_nascimento);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":profissao", $this->profissao);
        $stmt->bindParam(":telefone", $this->telefone);
        $stmt->bindParam(":celular", $this->celular);
        $stmt->bindParam(":possui_whatsapp", $possui_whatsapp);
        $stmt->bindParam(":notificacao_sms", $notificacao_sms);
        $stmt->bindParam(":notificacao_email", $notificacao_email);
        $stmt->bindParam(":id", $this->id);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    public function deletar() {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $this->id);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }
}