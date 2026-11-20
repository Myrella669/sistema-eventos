<?php
require 'funcoes.php';
exigir_login();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: meus-agendamentos.php');
    exit;
}

$evento_id = (int) ($_POST['evento_id'] ?? 0);
$usuario_id = $_SESSION['usuario_id'];

$agendamentos = ler_json(ARQ_AGENDAMENTOS);
$restantes = [];
$removeu = false;

foreach ($agendamentos as $a) {
    if ($a['usuario_id'] == $usuario_id && $a['evento_id'] == $evento_id) {
        $removeu = true;
    } else {
        $restantes[] = $a;
    }
}

if ($removeu) {
    // array_values reorganiza os índices para o JSON continuar uma lista
    salvar_json(ARQ_AGENDAMENTOS, array_values($restantes));
    definir_mensagem('sucesso', 'Agendamento cancelado.');
} else {
    definir_mensagem('erro', 'Agendamento não encontrado.');
}

header('Location: meus-agendamentos.php');
exit;