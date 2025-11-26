<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function usuario_logado()
{
    return isset($_SESSION['usuario_id']);
}

function exigir_login()
{
    if (!usuario_logado()) {
        $_SESSION['mensagem'] = 'faca login para acessar';
        $_SESSION['mensagem_tipo'] = 'erro';
        header('Location: /public/login.php');
        exit;
    }
}

function exigir_admin()
{
    exigir_login();
    if (!isset($_SESSION['usuario_tipo']) || $_SESSION['usuario_tipo'] !== 'admin') {
        $_SESSION['mensagem'] = 'acesso nao permitido';
        $_SESSION['mensagem_tipo'] = 'erro';
        header('Location: /public/index.php');
        exit;
    }
}
