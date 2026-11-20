<?php
require 'funcoes.php';

if (usuario_logado()) {
    header('Location: inicio.php');
} else {
    header('Location: login.php');
}
exit;