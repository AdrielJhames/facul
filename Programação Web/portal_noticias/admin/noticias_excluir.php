<?php
require_once __DIR__ . '/../config/db.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../includes/auth.php';
exigir_admin();

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if ($id > 0) {
    $stmt = $conexao->prepare("delete from noticias where id = ?");
    $stmt->bind_param('i', $id);
    if ($stmt->execute()) {
        $_SESSION['mensagem'] = 'noticia excluida';
        $_SESSION['mensagem_tipo'] = 'sucesso';
    } else {
        $_SESSION['mensagem'] = 'erro ao excluir noticia';
        $_SESSION['mensagem_tipo'] = 'erro';
    }
} else {
    $_SESSION['mensagem'] = 'id invalido';
    $_SESSION['mensagem_tipo'] = 'erro';
}

header('Location: noticias_listar.php');
exit;
