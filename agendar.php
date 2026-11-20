<?php
require 'funcoes.php';
exigir_login();


if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: eventos.php');
    exit;
}

$evento_id = (int) ($_POST['evento_id'] ?? 0);
$usuario_id = $_SESSION['usuario_id'];


if (buscar_evento($evento_id) === null) {
    definir_mensagem('erro', 'Evento não encontrado.');
    header('Location: eventos.php');
    exit;
}

$agendamentos = ler_json(ARQ_AGENDAMENTOS);


foreach ($agendamentos as $a) {
    if ($a['usuario_id'] == $usuario_id && $a['evento_id'] == $evento_id) {
        definir_mensagem('erro', 'Você já agendou este evento.');
        header('Location: detalhes.php?id=' . $evento_id);
        exit;
    }
}

$ids = array_column($agendamentos, 'id');
$agendamentos[] = [
    'id' => $ids ? max($ids) + 1 : 1,
    'usuario_id' => $usuario_id,
    'evento_id' => $evento_id
];
salvar_json(ARQ_AGENDAMENTOS, $agendamentos);

definir_mensagem('sucesso', 'Agendamento realizado com sucesso!');
header('Location: meus-agendamentos.php');
exit;