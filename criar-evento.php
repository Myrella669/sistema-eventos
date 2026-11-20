<?php
require 'funcoes.php';
exigir_login();

$titulo = 'Novo evento';
$erros = [];
$nome = $descricao = $data = $horario = $local = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome'] ?? '');
    $descricao = trim($_POST['descricao'] ?? '');
    $data = trim($_POST['data'] ?? '');
    $horario = trim($_POST['horario'] ?? '');
    $local = trim($_POST['local'] ?? '');

    if ($nome === '' || $descricao === '' || $data === '' || $horario === '' || $local === '') {
        $erros[] = 'Preencha todos os campos.';
    }

    // Confere se a data e o horário têm formato válido
    if ($data !== '') {
        $d = DateTime::createFromFormat('Y-m-d', $data);
        if (!$d || $d->format('Y-m-d') !== $data) {
            $erros[] = 'Data inválida.';
        }
    }
    if ($horario !== '') {
        $h = DateTime::createFromFormat('H:i', $horario);
        if (!$h || $h->format('H:i') !== $horario) {
            $erros[] = 'Horário inválido.';
        }
    }

    if (empty($erros)) {
        $eventos = ler_json(ARQ_EVENTOS);
        $ids = array_column($eventos, 'id');
        $novo_id = $ids ? max($ids) + 1 : 1;

        $eventos[] = [
            'id' => $novo_id,
            'nome' => $nome,
            'descricao' => $descricao,
            'data' => $data,
            'horario' => $horario,
            'local' => $local,
            'criado_por' => $_SESSION['usuario_id']
        ];
        salvar_json(ARQ_EVENTOS, $eventos);

        definir_mensagem('sucesso', 'Evento cadastrado com sucesso!');
        header('Location: eventos.php');
        exit;
    }
}

require 'cabecalho.php';
?>
<h1>Cadastrar evento</h1>

<section class="cartao">
    <?php foreach ($erros as $erro): ?>
        <div class="mensagem erro"><?= esc($erro) ?></div>
    <?php endforeach; ?>

    <form method="post" action="criar-evento.php" id="form-evento">
        <label for="nome">Nome do evento</label>
        <input type="text" id="nome" name="nome" value="<?= esc($nome) ?>">

        <label for="descricao">Descrição</label>
        <textarea id="descricao" name="descricao" rows="4"><?= esc($descricao) ?></textarea>

        <label for="data">Data</label>
        <input type="date" id="data" name="data" value="<?= esc($data) ?>">

        <label for="horario">Horário</label>
        <input type="time" id="horario" name="horario" value="<?= esc($horario) ?>">

        <label for="local">Local</label>
        <input type="text" id="local" name="local" value="<?= esc($local) ?>">

        <button type="submit">Cadastrar evento</button>
    </form>
</section>
<?php require 'rodape.php'; ?>