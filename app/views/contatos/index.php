<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Contatos</title>
    <link rel="stylesheet" href="style/style.css">
</head>
<body>
    <header>
        <div class="logo">
            <span class="logo-icon">C</span>
            <span>Cadastro de contatos</span>
        </div>
    </header>

    <main class="container">
        <?php if (isset($_GET["msg"])): ?>
            <div class="alert alert-success">
                <?php
                    switch($_GET["msg"]) {
                        case "criado": echo "Contato cadastrado com sucesso!"; break;
                        case "atualizado": echo "Contato atualizado com sucesso!"; break;
                        case "deletado": echo "Contato deletado com sucesso!"; break;
                    }
                ?>
            </div>
        <?php endif; ?>

        <form action="index.php?acao=criar" method="POST" class="form-contato">
            <div class="form-row">
                <div class="form-group">
                    <label>Nome completo</label>
                    <input type="text" name="nome_completo" placeholder="Ex.: Letícia Pacheco dos Santos" required>
                </div>
                <div class="form-group">
                    <label>Data de nascimento</label>
                    <input type="date" name="data_nascimento" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>E-mail</label>
                    <input type="email" name="email" placeholder="Ex.: leticia@gmail.com" required>
                </div>
                <div class="form-group">
                    <label>Profissão</label>
                    <input type="text" name="profissao" placeholder="Ex.: Desenvolvedora Web">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Telefone para contato</label>
                    <input type="text" name="telefone" placeholder="Ex.: (11) 4033-2019">
                </div>
                <div class="form-group">
                    <label>Celular para contato</label>
                    <input type="text" name="celular" placeholder="Ex.: (11) 98493-2039">
                </div>
            </div>

            <div class="form-row checkboxes">
                <div class="form-group">
                    <label class="checkbox-label">
                        <input type="checkbox" name="possui_whatsapp">
                        Número de celular possui Whatsapp
                    </label>
                    <label class="checkbox-label">
                        <input type="checkbox" name="notificacao_sms">
                        Enviar notificações por SMS
                    </label>
                </div>
                <div class="form-group">
                    <label class="checkbox-label">
                        <input type="checkbox" name="notificacao_email">
                        Enviar notificações por E-mail
                    </label>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Cadastrar contato</button>
            </div>
        </form>

        <table class="tabela-contatos">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Data de nascimento</th>
                    <th>E-mail</th>
                    <th>Celular para contato</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($contatos)): ?>
                    <?php foreach ($contatos as $contato): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($contato["nome_completo"]); ?></td>
                        <td><?php echo date("d/m/Y", strtotime($contato["data_nascimento"])); ?></td>
                        <td><?php echo htmlspecialchars($contato["email"]); ?></td>
                        <td><?php echo htmlspecialchars($contato["celular"]); ?></td>
                        <td class="acoes">
                            <a href="index.php?acao=editar&id=<?php echo $contato["id"]; ?>" class="btn-editar" title="Editar">✏️</a>
                            <a href="index.php?acao=deletar&id=<?php echo $contato["id"]; ?>" class="btn-deletar" title="Deletar" onclick="return confirm('Tem certeza que deseja deletar este contato?')">🗑️</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="sem-registros">Nenhum contato cadastrado.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </main>

    <footer>
        <span>Termos | Políticas</span>
        <span>© Copyright 2022 | Desenvolvido por alphacode</span>
        <span>©Alphacode IT Solutions 2022</span>
    </footer>
</body>
</html>