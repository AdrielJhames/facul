<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
session_unset();
session_destroy();
session_start();
$_SESSION['mensagem'] = 'logout realizado';
$_SESSION['mensagem_tipo'] = 'sucesso';
header('Location: ../public/index.php');
exit;
