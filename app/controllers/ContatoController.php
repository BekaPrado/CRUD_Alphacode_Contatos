<?php
/************************************************************
 * API de contatos - Controller
 * Autor: Rebeka Marcelino
 * Data: 12/12/2025
 * Versão: 1.0
 ************************************************************/

require_once __DIR__ . "/../../config/database.php";
require_once __DIR__ . "/../../config/mensagens.php";
require_once __DIR__ . "/../model/Contato.php";

class ContatoController {
    
    private $conexao;
    private $contato;

    // iniciar 
    public function __construct() {
        $this->conexao = (new Database())->getConnection();
        $this->contato = new Contato($this->conexao);
    }


    // ////////////////////////////////////////
    // MÉTODOS PÚBLICOS (chamados pelas rotas)
    // ////////////////////////////////////////

    // listar 
    
    public function index() {
        $resultado = $this->contato->listar();
        $contatos = $resultado->fetchAll(PDO::FETCH_ASSOC);
        
        require_once __DIR__ . "/../views/contatos/index.php";
    }

    /*
     * Exibe formulário de criação
     */
    public function criar() {
        require_once __DIR__ . "/../views/contatos/criar.php";
    }

    /*
     * Exibe formulário de edição
     */
    public function editar($id) {
        $this->contato->id = $id;
        
        if ($this->contato->buscarPorId()) {
            // Encontrou o contato, exibe o formulário
            $contato = $this->contato;
            require_once __DIR__ . "/../views/contatos/editar.php";
        } else {
            // Não encontrou, volta pra lista
            $this->redirecionar("index.php");
        }
    }

    /*
     * Salva novo contato no banco
     * Retorna array com status e erros (se houver)
     */
    public function salvar($dados) {
        $erros = $this->validar($dados);
        
        if (!empty($erros)) {
            // Tem erros de validação, retorna eles
            return $this->retornoErro($erros);
        } else {
            // Dados válidos, tenta salvar
            $this->preencherContato($dados);
            
            if ($this->contato->criar()) {
                return $this->retornoSucesso();
            } else {
                return $this->retornoErro(["Falha ao salvar no banco"]);
            }
        }
    }

    /*
     * Atualiza contato existente
     */
    public function atualizar($id, $dados) {
        $erros = $this->validar($dados);
        
        if (!empty($erros)) {
            // Tem erros de validação
            return $this->retornoErro($erros);
        } else {
            // Dados válidos, tenta atualizar
            $this->contato->id = $id;
            $this->preencherContato($dados);
            
            if ($this->contato->atualizar()) {
                return $this->retornoSucesso();
            } else {
                return $this->retornoErro(["Falha ao atualizar no banco"]);
            }
        }
    }

    /*
     * Remove contato do banco
     */
    public function deletar($id) {
        $this->contato->id = $id;
        
        if ($this->contato->deletar()) {
            return $this->retornoSucesso();
        } else {
            return $this->retornoErro(["Falha ao deletar"]);
        }
    }


    // ==========================================
    // MÉTODOS PRIVADOS (uso interno)
    // ==========================================

    /*
     * Preenche o objeto contato com os dados do formulário
     */
    private function preencherContato($dados) {
        $this->contato->nome_completo = $dados["nome_completo"];
        $this->contato->data_nascimento = $dados["data_nascimento"];
        $this->contato->email = $dados["email"];
        $this->contato->profissao = $dados["profissao"] ?? "";
        $this->contato->telefone = $dados["telefone"] ?? "";
        $this->contato->celular = $dados["celular"] ?? "";
        
        // Checkbox: se marcado = 1, se não = 0
        $this->contato->possui_whatsapp = isset($dados["possui_whatsapp"]) ? 1 : 0;
        $this->contato->notificacao_sms = isset($dados["notificacao_sms"]) ? 1 : 0;
        $this->contato->notificacao_email = isset($dados["notificacao_email"]) ? 1 : 0;
    }

    /*
     * Valida os dados do formulário
     * Retorna array vazio se tudo ok, ou lista de erros
     */
    private function validar($dados) {
        $erros = [];

        // Campos obrigatórios
        if (empty($dados["nome_completo"])) {
            $erros[] = "Nome completo é obrigatório";
        }

        if (empty($dados["email"])) {
            $erros[] = "E-mail é obrigatório";
        } elseif (!filter_var($dados["email"], FILTER_VALIDATE_EMAIL)) {
            $erros[] = "E-mail inválido";
        }

        if (empty($dados["data_nascimento"])) {
            $erros[] = "Data de nascimento é obrigatória";
        }

        // Telefone (opcional, mas se preencheu tem que ser válido)
        if (!empty($dados["telefone"])) {
            if (!$this->telefoneValido($dados["telefone"])) {
                $erros[] = "Telefone inválido. Use: (11) 4033-2019";
            }
        }

        if (!empty($dados["celular"])) {
            if (!$this->telefoneValido($dados["celular"])) {
                $erros[] = "Celular inválido. Use: (11) 98493-2039";
            }
        }

        return $erros;
    }

    /*
     * Verifica se telefone está no formato correto
     * Aceita: (11) 4033-2019 ou (11) 98493-2039
     */
    private function telefoneValido($telefone) {
        $padrao = "/^\(\d{2}\)\s?\d{4,5}-?\d{4}$/";
        return preg_match($padrao, $telefone);
    }

    /*
     * Redireciona pra outra página
     */
    private function redirecionar($url) {
        header("Location: " . $url);
        exit;
    }

    /*
     * Monta retorno de sucesso padronizado
     */
    private function retornoSucesso() {
        return ["sucesso" => true];
    }

    /*
     * Monta retorno de erro padronizado
     */
    private function retornoErro($erros) {
        return [
            "sucesso" => false,
            "erros" => $erros
        ];
    }
}