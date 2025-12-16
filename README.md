# <img width="400" height="100" alt="logoalpha" src="https://github.com/user-attachments/assets/707316e2-48a2-4036-91c7-205eb9063ae2" />
# API de Contatos - Backend

API REST desenvolvida em PHP para gerenciamento de contatos.

---

## Índice

- Sobre o Projeto
- Tecnologias Utilizadas
- Executando...
- Instalação
- Configuração do Banco de Dados
- Estrutura do Projeto
- Endpoints da API
- Exemplos de Uso

---

## 📄 Sobre o Projeto

Este projeto é uma API RESTful para cadastrar, editar e excluir um contato.

### Funcionalidades

- ✅ Listar todos os contatos
- ✅ Buscar contato por ID
- ✅ Cadastrar novo contato
- ✅ Atualizar contato existente
- ✅ Deletar contato
- ✅ Validação de campos obrigatórios
- ✅ Proteção contra SQL Injection
- ✅ Respostas padronizadas em JSON

---

## 🖱️ Tecnologias Utilizadas

- **PHP 8.x** - Linguagem de programação
- **MySQL** - Banco de dados relacional
- **PDO** - Conexão segura com o banco
- **JSON** - Formato de comunicação da API
- **Servidor local** - Laragon

---

## ⏸️ Para Executar...

Para executar o projeto, você precisa ter instalado:

- [Laragon](https://laragon.org/download/) / ou algum outro - Servidor local com Apache, PHP e MySQL
- PHP 8.0 ou superior
- MySQL 5.7 ou superior
- Navegador/Postman/Insomnia

### Verifique a instalação:

```bash
php -v
mysql --version
```

---
## ▶️ Executando... 

### Passo 1: Clonar o repositório

```bash
git clone https://github.com/BekaPrado/CRUD_Alphacode_Contatos
```

### Passo 2: Mover para a pasta do Laragon

```
C:\laragon\www\
```

## 🫆 Banco de Dados

### Passo 1: Acesse o Banco de Dados pelo Laragon

<img width="444" height="290" alt="image" src="https://github.com/user-attachments/assets/814597ef-edb7-43ab-b5a8-c4d0b3c0639f" />

### Passo 2: Crie o banco e a tabela
Execute o script SQL abaixo:

```sql
-- Criar banco de dados
CREATE DATABASE IF NOT EXISTS alphacode_contatos;
USE alphacode_contatos;

-- Criar tabela de contatos
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
```

### Passo 3: Configurar conexão

Edite o arquivo `config/database.php` com seus dados:

```php
private $host = "localhost";
private $banco = "alphacode_contatos";
private $usuario = "root";
private $senha = "";  // deixe vazio se não tiver senha (por padrão vem sem senha)
```

---

## 📁 Estrutura do Projeto

```
Back de Contatos/
│
├── api/
│   └── contatos.php       # Endpoints da API (rotas)
│
├── app/
│   └── model/
│       └── Contato.php    # Model com CRUD
│
├── config/
│   ├── database.php       # Configuração de conexão
│   └── mensagens.php      # Padrão de Mensagens
│
├── database.sql           # Script 
└── README.md            
```

## 🌐 Endpoints da API

Pasta -> laragon\www\alphacode\Back de Contatos

URL Base: `http://localhost/alphacode/Back%20de%20Contatos/api/contatos.php`

| Método | Endpoint | Descrição |
|--------|----------|-----------|
| GET | `/contatos.php` | Lista todos os contatos |
| GET | `/contatos.php?id={id}` | Busca contato por ID |
| POST | `/contatos.php` | Cria novo contato |
| PUT | `/contatos.php?id={id}` | Atualiza contato |
| DELETE | `/contatos.php?id={id}` | Deleta contato |

---

## ‼️ Exemplos de Uso

### Para listar todos os contatos

**Request:**
```
GET http://localhost/alphacode/Back%20de%20Contatos/api/contatos.php
```

**Response:**
```json
{
  "status": true,
  "status_code": 200,
  "mensagem": "Contatos listados",
  "dados": [
    {
      "id": 9,
      "nome_completo": "Luiz Palma",
      "data_nascimento": "2005-05-15",
      "email": "luiz.palma@gmail.com",
      "profissao": "Advogado",
      "telefone": "11937473815",
      "celular": "(11) 937473815",
      "possui_whatsapp": 1,
      "notificacao_sms": 0,
      "notificacao_email": 0,
      "created_at": "2025-12-16 13:13:29",
      "updated_at": "2025-12-16 13:13:29"
    },
    {
      "id": 8,
      "nome_completo": "Rebeka Marcelino do Prado",
      "data_nascimento": "2008-04-19",
      "email": "rebeka.prado.marcelino@gmail.com",
      "profissao": "Desenvolvedora Web",
      "telefone": "11937473815",
      "celular": "(11) 937473815",
      "possui_whatsapp": 0,
      "notificacao_sms": 1,
      "notificacao_email": 1,
      "created_at": "2025-12-15 23:48:25",
      "updated_at": "2025-12-15 23:48:36"
    }
  ]
}
```

### Para buscar contato por ID

**Request:**
```
GET http://localhost/alphacode/Back%20de%20Contatos/api/contatos.php?id=9
```

**Response:**
```json
{
  "status": true,
  "status_code": 200,
  "mensagem": "Contato encontrado",
  "dados": {
    "id": "9",
    "nome_completo": "Luiz Palma",
    "data_nascimento": "2005-05-15",
    "email": "luiz.palma@gmail.com",
    "profissao": "Advogado",
    "telefone": "11937473815",
    "celular": "(11) 937473815",
    "possui_whatsapp": true,
    "notificacao_sms": false,
    "notificacao_email": false
  }
}
```

### Para criar novo contato

**Request:**
```
POST http://localhost/Back%20de%20Contatos/api/contatos.php

{
    "nome_completo": "Pamela Prado",
    "data_nascimento": "1985-10-20",
    "email": "pamela@gmail.com",
    "profissao": "Designer",
    "telefone": "(11) 3333-4444",
    "celular": "(11) 99999-8888",
    "possui_whatsapp": true,
    "notificacao_sms": true,
    "notificacao_email": false
}
```

**Response:**
```json
{
    "status": true,
    "status_code": 201,
    "mensagem": "Cadastrado!"
}
```

### Atualizar contato

**Request:**
```
PUT http://localhost/alphacode/Back%20de%20Contatos/api/contatos.php?id=10

{
    "nome_completo": "Pamela Prado ATUALIZADO",
    "data_nascimento": "1985-10-20",
    "email": "pamela@gmail.com",
    "profissao": "Designer",
    "telefone": "(11) 3333-4444",
    "celular": "(11) 99999-8888",
    "possui_whatsapp": true,
    "notificacao_sms": true,
    "notificacao_email": false
}
```

**Response:**
```json
{
    "status": true,
    "status_code": 200,
    "mensagem": "Atualizado!"
}
```

### Deletar contato

**Request:**
```
DELETE http://localhost/Back%20de%20Contatos/api/contatos.php?id=10
```

**Response:**
```json
{
    "status": true,
    "status_code": 200,
    "mensagem": "Deletado!"
}
```

---

## ⚠️ Códigos de Erro (config/mensagens.php)

| Código | Mensagem | Descrição |
|--------|----------|-----------|
| 400 | Campos obrigatórios | Faltam campos necessários |
| 404 | Não encontrado | Contato não existe |
| 500 | Erro interno | Erro no servidor |


## 👩‍💻

**Feito por: Rebeka Marcelino**

- GitHub: [BekaPrado](https://github.com/BekaPrado)
- LinkedIn: [Rebeka Marcelino](www.linkedin.com/in/rebekamarcelino)

