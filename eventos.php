<?php
require 'funcoes.php';
exigir_login();

$titulo = 'Eventos';
$eventos = eventos_ordenados();

require 'cabecalho.php';
?>
<h1>Eventos</h1>

<?php if (empty($eventos)): ?>
    <p>Nenhum evento cadastrado ainda. <a href="criar-evento.php">Cadastre o primeiro!</a></p>
<?php else: ?>
    <?php foreach ($eventos as $e): ?>
        <section class="cartao">
            <h2><?= esc($e['nome']) ?></h2>
            <p>
                <strong>Data:</strong> <?= formatar_data($e['data']) ?><br>
                <strong>Horário:</strong> <?= esc($e['horario']) ?><br>
                <strong>Local:</strong> <?= esc($e['local']) ?>
            </p>
            <a class="botao" href="detalhes.php?id=<?= (int) $e['id'] ?>">Ver detalhes</a>
        </section>
    <?php endforeach; ?>
<?php endif; ?>
<?php require 'rodape.php'; ?>