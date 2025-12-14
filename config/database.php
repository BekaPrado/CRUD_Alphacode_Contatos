<?php
/************************************************************
 * Conecta com banco de dados
 * Autor: Rebeka Marcelino
 * Data: 12/12/2025
 * Versão: 1.0
 ************************************************************/

class Database {
// configuracoes
    private $host = "localhost";
    private $banco = "alphacode_contatos";
    private $usuario = "root";
    private $senha = "";
    
    // guarda
    private $conexao;


    //cria a conexao
    public function getConnection() {
        
        $this->conexao = null;

        try {
            // usando try/catch                                     codificação para acentos funcionarem 
            $dsn = "mysql:host={$this->host};dbname={$this->banco};charset=utf8";
            $this->conexao = new PDO($dsn, $this->usuario, $this->senha);
            
          ///erros
            $this->conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            //caso o try falhe
        } catch (PDOException $erro) {
            echo "Erro na conexão: " . $erro->getMessage();
        }

        return $this->conexao;
    }
}