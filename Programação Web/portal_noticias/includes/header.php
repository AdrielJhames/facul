<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '../auth.php';
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <title>NewsHub</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../assets/style.css">
</head>

<body>
    <header class="topo">
        <div class="container topo-conteudo">
            <h1>NewsHub</h1>
            <nav class="menu">
                <a href="../public/index.php">Início</a>
                <?php if (usuario_logado()): ?>
                    <?php if (isset($_SESSION['usuario_tipo']) && $_SESSION['usuario_tipo'] === 'admin'): ?>
                        <a href="../admin/noticias_listar.php">Postar Notícia</a>
                    <?php endif; ?>
                    <a href="../public/logout.php">Sair</a>
                <?php else: ?>
                    <a href="../public/login.php">Login</a>
                    <a href="../public/cadastro.php">Cadastro</a>
                <?php endif; ?>
            </nav>
        </div>
    </header>

    <main class="container">
        <?php include __DIR__ . '../messages.php'; ?>