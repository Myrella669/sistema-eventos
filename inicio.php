<?php
require 'funcoes.php';
exigir_login();

$titulo = 'Início';
$hoje = date('Y-m-d');

// Próximos eventos (a partir de hoje), no máximo 5
$proximos = [];
foreach (eventos_ordenados() as $e) {
    if ($e['data'] >= $hoje) {
        $proximos[] = $e;
    }
}
$proximos = array_slice($proximos, 0, 5);

require 'cabecalho.php';
?>
<h1>Bem-vindo(a), <?= esc($_SESSION['usuario_nome']) ?>!</h1>

<section class="cartao">
    <h2>Próximos eventos</h2>

    <?php if (empty($proximos)): ?>
        <p>Nenhum evento próximo. <a href="criar-evento.php">Cadastre o primeiro!</a></p>
    <?php else: ?>
        <ul class="lista">
            <?php foreach ($proximos as $e): ?>
                <li>
                    <strong><?= esc($e['nome']) ?></strong><br>
                    <?= formatar_data($e['data']) ?> às <?= esc($e['horario']) ?> — <?= esc($e['local']) ?><br>
                    <a href="detalhes.php?id=<?= (int) $e['id'] ?>">Ver detalhes</a>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</section>
<?php require 'rodape.php'; ?>