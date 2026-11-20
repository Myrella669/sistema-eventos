<?php
require 'funcoes.php';


if (usuario_logado()) {
    header('Location: inicio.php');
    exit;
}

$erro = '';
$email = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = strtolower(trim($_POST['email'] ?? ''));
    $senha = $_POST['senha'] ?? '';

    $usuarios = ler_json(ARQ_USUARIOS);

    foreach ($usuarios as $u) {
        if ($u['email'] === $email && password_verify($senha, $u['senha'])) {
            session_regenerate_id(true);
            $_SESSION['usuario_id'] = $u['id'];
            $_SESSION['usuario_nome'] = $u['nome'];
            header('Location: inicio.php');
            exit;
        }
    }

    $erro = 'E-mail ou senha incorretos.';
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistema de Eventos</title>
    <link rel="stylesheet" href="css/estilo.css">
</head>
<body>
    <main class="caixa">
        <h1>Entrar</h1>

        <?php exibir_mensagem(); ?>
        <?php if ($erro !== ''): ?>
            <div class="mensagem erro"><?= esc($erro) ?></div>
        <?php endif; ?>

        <form method="post" action="login.php" id="form-login">
            <label for="email">E-mail</label>
            <input type="text" id="email" name="email" value="<?= esc($email) ?>">

            <label for="senha">Senha</label>
            <input type="password" id="senha" name="senha">

            <button type="submit">Entrar</button>
        </form>

        <p>Não tem conta? <a href="cadastro.php">Cadastre-se</a></p>
    </main>
</body>
</html>