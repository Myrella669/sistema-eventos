<?php
require 'funcoes.php';
exigir_login();

$titulo = 'Meus agendamentos';
$usuario_id = $_SESSION['usuario_id'];

// Junta cada agendamento do usuário com os dados do evento
$meus = [];
foreach (ler_json(ARQ_AGENDAMENTOS) as $a) {
    if ($a['usuario_id'] == $usuario_id) {
        $evento = buscar_evento($a['evento_id']);
        if ($evento !== null) {
            $meus[] = $evento;
        }
    }
}

usort($meus, function ($x, $y) {
    return strcmp($x['data'] . ' ' . $x['horario'], $y['data'] . ' ' . $y['horario']);
});

require 'cabecalho.php';
?>
<h1>Meus agendamentos</h1>

<?php if (empty($meus)): ?>
    <p>Você ainda não agendou nenhum evento. <a href="eventos.php">Ver eventos</a></p>
<?php else: ?>
    <?php foreach ($meus as $e): ?>
        <section class="cartao">
            <h2><?= esc($e['nome']) ?></h2>
            <p>
                <strong>Data e horário:</strong> <?= formatar_data($e['data']) ?> às <?= esc($e['horario']) ?><br>
                <strong>Local:</strong> <?= esc($e['local']) ?>
            </p>
            <a class="botao" href="detalhes.php?id=<?= (int) $e['id'] ?>">Ver detalhes</a>

            <form method="post" action="cancelar.php" class="form-cancelar" style="display:inline">
                <input type="hidden" name="evento_id" value="<?= (int) $e['id'] ?>">
                <button type="submit" class="btn-perigo">Cancelar agendamento</button>
            </form>
        </section>
    <?php endforeach; ?>
<?php endif; ?>
<?php require 'rodape.php'; ?>