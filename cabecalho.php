<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($titulo) ?> - Sistema de Eventos</title>
    <link rel="stylesheet" href="css/estilo.css">
</head>
<body>
    <header class="topo">
        <span class="logo">Sistema de Eventos</span>
        <nav>
            <a href="inicio.php">Início</a>
            <a href="eventos.php">Eventos</a>
            <a href="criar-evento.php">Novo evento</a>
            <a href="meus-agendamentos.php">Meus agendamentos</a>
            <a href="logout.php">Sair</a>
        </nav>
    </header>
    <main class="container">
        <?php exibir_mensagem(); ?>