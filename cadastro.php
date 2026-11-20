<?php
require 'funcoes.php';

$erros = [];
$nome = '';
$email = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome'] ?? '');
    $email = strtolower(trim($_POST['email'] ?? ''));
    $senha = $_POST['senha'] ?? '';
    $confirmar = $_POST['confirmar_senha'] ?? '';

    
    if ($nome === '' || $email === '' || $senha === '' || $confirmar === '') {
        $erros[] = 'Preencha todos os campos.';
    }
    if ($email !== '' && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erros[] = 'Informe um e-mail válido.';
    }
    if ($senha !== $confirmar) {
        $erros[] = 'As senhas não são iguais.';
    }

    $usuarios = ler_json(ARQ_USUARIOS);

    
    foreach ($usuarios as $u) {
        if ($u['email'] === $email) {
            $erros[] = 'Já existe um usuário com este e-mail.';
            break;
        }
    }

    if (empty($erros)) {
        $usuarios[] = [
            'id' => count($usuarios) + 1,
            'nome' => $nome,
            'email' => $email,
            'senha' => password_hash($senha, PASSWORD_DEFAULT)
        ];
        salvar_json(ARQ_USUARIOS, $usuarios);
        definir_mensagem('sucesso', 'Cadastro realizado! Faça login.');
        header('Location: login.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro - Sistema de Eventos</title>
    <link rel="stylesheet" href="css/estilo.css">
</head>
<body>
    <main class="caixa">
        <h1>Criar conta</h1>

        <?php foreach ($erros as $erro): ?>
            <div class="mensagem erro"><?= esc($erro) ?></div>
        <?php endforeach; ?>

        <form method="post" action="cadastro.php" id="form-cadastro">
            <label for="nome">Nome</label>
            <input type="text" id="nome" name="nome" value="<?= esc($nome) ?>">

            <label for="email">E-mail</label>
            <input type="text" id="email" name="email" value="<?= esc($email) ?>">

            <label for="senha">Senha</label>
            <input type="password" id="senha" name="senha">

            <label for="confirmar_senha">Confirmar senha</label>
            <input type="password" id="confirmar_senha" name="confirmar_senha">

            <button type="submit">Cadastrar</button>
        </form>

        <p>Já tem conta? <a href="login.php">Entrar</a></p>
    </main>
</body>
</html>