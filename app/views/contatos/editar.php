<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Contato</title>
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
        <h2>Editar Contato</h2>

        <?php if (!empty($erros)): ?>
            <div class="alert alert-error">
                <ul>
                    <?php foreach ($erros as $erro): ?>
                        <li><?php echo $erro; ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form action="index.php?acao=editar&id=<?php echo $contato->id; ?>" method="POST" class="form-contato">
            <div class="form-row">
                <div class="form-group">
                    <label>Nome completo</label>
                    <input type="text" name="nome_completo" value="<?php echo htmlspecialchars($contato->nome_completo); ?>" required>
                </div>
                <div class="form-group">
                    <label>Data de nascimento</label>
                    <input type="date" name="data_nascimento" value="<?php echo $contato->data_nascimento; ?>" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>E-mail</label>
                    <input type="email" name="email" value="<?php echo htmlspecialchars($contato->email); ?>" required>
                </div>
                <div class="form-group">
                    <label>Profissão</label>
                    <input type="text" name="profissao" value="<?php echo htmlspecialchars($contato->profissao); ?>">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Telefone para contato</label>
                    <input type="text" name="telefone" value="<?php echo htmlspecialchars($contato->telefone); ?>">
                </div>
                <div class="form-group">
                    <label>Celular para contato</label>
                    <input type="text" name="celular" value="<?php echo htmlspecialchars($contato->celular); ?>">
                </div>
            </div>

            <div class="form-row checkboxes">
                <div class="form-group">
                    <label class="checkbox-label">
                        <input type="checkbox" name="possui_whatsapp" <?php echo $contato->possui_whatsapp ? "checked" : ""; ?>>
                        Número de celular possui Whatsapp
                    </label>
                    <label class="checkbox-label">
                        <input type="checkbox" name="notificacao_sms" <?php echo $contato->notificacao_sms ? "checked" : ""; ?>>
                        Enviar notificações por SMS
                    </label>
                </div>
                <div class="form-group">
                    <label class="checkbox-label">
                        <input type="checkbox" name="notificacao_email" <?php echo $contato->notificacao_email ? "checked" : ""; ?>>
                        Enviar notificações por E-mail
                    </label>
                </div>
            </div>

            <div class="form-actions">
                <a href="index.php" class="btn btn-secondary">Voltar</a>
                <button type="submit" class="btn btn-primary">Salvar alterações</button>
            </div>
        </form>
    </main>

    <footer>
        <span>Termos | Políticas</span>
        <span>© Copyright 2022 | Desenvolvido por alphacode</span>
        <span>©Alphacode IT Solutions 2022</span>
    </footer>
</body>
</html>