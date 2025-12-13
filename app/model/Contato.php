<?php
/************************************************************
 * Model DAO 
 * Autor: Rebeka Marcelino
 * Data: 12/12/2025
 * Versão: 1.0
 ************************************************************/

class Contato {
    
    // Conexão com banco
    private $conexao;
    private $tabela = "contatos";

    // atributos da tabela
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


    //recebe conexao
    public function __construct($conexao) {
        $this->conexao = $conexao;
    }


    // ////////////////////////
    // MÉTODOS CRUD
    // ////////////////////////

    // listar GET 
    public function listar() {
        //ordenando mais recentes para mais antigos de acordo com criação
        $sql = "SELECT * FROM {$this->tabela} ORDER BY created_at DESC";
        
        $stmt = $this->conexao->prepare($sql);
        //executa a query
        $stmt->execute();
        //retorna o PDO
        return $stmt;
    }

    // GET por id 
    public function buscarPorId() {
        $sql = "SELECT * FROM {$this->tabela} WHERE id = :id LIMIT 1";
        
        $stmt = $this->conexao->prepare($sql);
        $stmt->bindParam(":id", $this->id);
        $stmt->execute();
        
        $registro = $stmt->fetch(PDO::FETCH_ASSOC);
        
        //condição para retornar o cadastro
        if ($registro) {
            $this->nome_completo = $registro['nome_completo'];
            $this->data_nascimento = $registro['data_nascimento'];
            $this->email = $registro['email'];
            $this->profissao = $registro['profissao'];
            $this->telefone = $registro['telefone'];
            $this->celular = $registro['celular'];
            $this->possui_whatsapp = $registro['possui_whatsapp'];
            $this->notificacao_sms = $registro['notificacao_sms'];
            $this->notificacao_email = $registro['notificacao_email'];
            return true;
        } else {
            return false;
        }
    }

    // POST - criar 
    public function criar() {
        // atributos que vao receber dados
        $sql = "INSERT INTO {$this->tabela} 
                (nome_completo, 
                data_nascimento, 
                email, profissao, 
                telefone, celular, 
                possui_whatsapp, 
                notificacao_sms, 
                notificacao_email)
                VALUES 
                (:nome_completo, 
                :data_nascimento, 
                :email, :profissao, 
                :telefone, :celular, 
                :possui_whatsapp, 
                :notificacao_sms, 
                :notificacao_email)";

        $stmt = $this->conexao->prepare($sql);
        
        // XSS 
        $this->sanitizarDados();
        
        // converte para 0 ou 1
        $possui_whatsapp = $this->converterParaInteiro($this->possui_whatsapp);
        $notificacao_sms = $this->converterParaInteiro($this->notificacao_sms);
        $notificacao_email = $this->converterParaInteiro($this->notificacao_email);

        // supstitui placeholder
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
        } else {
            return false;
        }
    }

    //Put - atualizar contato
    public function atualizar() {
        $sql = "UPDATE {$this->tabela} SET
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

        $stmt = $this->conexao->prepare($sql);
        
        $this->sanitizarDados();
        
        $possui_whatsapp = $this->converterParaInteiro($this->possui_whatsapp);
        $notificacao_sms = $this->converterParaInteiro($this->notificacao_sms);
        $notificacao_email = $this->converterParaInteiro($this->notificacao_email);

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
        } else {
            return false;
        }
    }

    // DELETE - excluir contato
    public function deletar() {
        $sql = "DELETE FROM {$this->tabela} WHERE id = :id";
        
        $stmt = $this->conexao->prepare($sql);
        $stmt->bindParam(":id", $this->id);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }


    // ///////////////////////
    // adicional
    // ///////////////////////

    // remove caracteres especiais do texto
    private function sanitizarDados() {
        $this->nome_completo = $this->limparTexto($this->nome_completo);
        $this->email = $this->limparTexto($this->email);
        $this->profissao = $this->limparTexto($this->profissao ?? '');
        $this->telefone = $this->limparTexto($this->telefone ?? '');
        $this->celular = $this->limparTexto($this->celular ?? '');
    }

    // remove as tags
    private function limparTexto($texto) {
        $texto = strip_tags($texto);           // Remove tags HTML
        $texto = htmlspecialchars($texto);     // Escapa caracteres especiais
        return $texto;
    }

    //converte valor
    private function converterParaInteiro($valor) {
        if ($valor) {
            return 1;
        } else {
            return 0;
        }
    }
}