<?php
require 'funcoes.php';
exigir_login();

$id = (int) ($_GET['id'] ?? 0);
$evento = buscar_evento($id);

if ($evento === null) {
    definir_mensagem('erro', 'Evento não encontrado.');
    header('Location: eventos.php');
    exit;
}

$titulo = $evento['nome'];
require 'cabecalho.php';
?>
<section class="cartao">
    <h1><?= esc($evento['nome']) ?></h1>
    <p><?= nl2br(esc($evento['descricao'])) ?></p>
    <p>
        <strong>Data:</strong> <?= formatar_data($evento['data']) ?><br>
        <strong>Horário:</strong> <?= esc($evento['horario']) ?><br>
        <strong>Local:</strong> <?= esc($evento['local']) ?>
    </p>

    <form method="post" action="agendar.php">
        <input type="hidden" name="evento_id" value="<?= (int) $evento['id'] ?>">
        <button type="submit">Agendar</button>
    </form>
</section>
<p><a href="eventos.php">&larr; Voltar para os eventos</a></p>
<?php require 'rodape.php'; ?>