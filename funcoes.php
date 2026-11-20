<?php
session_start();

define('ARQ_USUARIOS', __DIR__ . '/dados/usuarios.json');
define('ARQ_EVENTOS', __DIR__ . '/dados/eventos.json');
define('ARQ_AGENDAMENTOS', __DIR__ . '/dados/agendamentos.json');


function ler_json($arquivo) {
    if (!file_exists($arquivo)) {
        return [];
    }
    $dados = json_decode(file_get_contents($arquivo), true);
    return is_array($dados) ? $dados : [];
}

function salvar_json($arquivo, $dados) {
    $json = json_encode($dados, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    file_put_contents($arquivo, $json, LOCK_EX);
}


function esc($texto) {
    return htmlspecialchars($texto, ENT_QUOTES, 'UTF-8');
}

function usuario_logado() {
    return isset($_SESSION['usuario_id']);
}


function exigir_login() {
    if (!usuario_logado()) {
        header('Location: login.php');
        exit;
    }
}


function definir_mensagem($tipo, $texto) {
    $_SESSION['mensagem'] = ['tipo' => $tipo, 'texto' => $texto];
}

function exibir_mensagem() {
    if (isset($_SESSION['mensagem'])) {
        $m = $_SESSION['mensagem'];
        echo '<div class="mensagem ' . esc($m['tipo']) . '">' . esc($m['texto']) . '</div>';
        unset($_SESSION['mensagem']);
    }
}
function buscar_evento($id) {
    foreach (ler_json(ARQ_EVENTOS) as $e) {
        if ($e['id'] == $id) {
            return $e;
        }
    }
    return null;
}


function eventos_ordenados() {
    $eventos = ler_json(ARQ_EVENTOS);
    usort($eventos, function ($a, $b) {
        return strcmp($a['data'] . ' ' . $a['horario'], $b['data'] . ' ' . $b['horario']);
    });
    return $eventos;
}

// 2026-12-02 vira 02/12/2026
function formatar_data($data) {
    return date('d/m/Y', strtotime($data));
}