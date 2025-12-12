<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Novo Contato</title>
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
        <h2>Novo Contato</h2>

        <?php if (!empty($erros)): ?>
            <div class="alert alert-error">
                <ul>
                    <?php foreach ($erros as $erro): ?>
                        <li><?php echo $erro; ?></li>
                    <?php endforeach; ?>
                </ul>
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
                <a href="index.php" class="btn btn-secondary">Voltar</a>
                <button type="submit" class="btn btn-primary">Cadastrar contato</button>
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