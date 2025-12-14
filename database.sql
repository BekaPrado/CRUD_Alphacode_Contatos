/************************************************************
 * SCRIPT SQL
 * Autor: Rebeka Marcelino
 * Data: 12/12/2025
 * Versão: 1.0
 ************************************************************/


CREATE DATABASE IF NOT EXISTS alphacode_contatos;
USE alphacode_contatos;

CREATE TABLE contatos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome_completo VARCHAR(150) NOT NULL,
    data_nascimento DATE NOT NULL,
    email VARCHAR(100) NOT NULL,
    profissao VARCHAR(100),
    telefone VARCHAR(20),
    celular VARCHAR(20),
    possui_whatsapp BOOLEAN DEFAULT FALSE,
    notificacao_sms BOOLEAN DEFAULT FALSE,
    notificacao_email BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

