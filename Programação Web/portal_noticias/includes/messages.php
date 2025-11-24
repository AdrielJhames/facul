<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['mensagem'])) {
    $tipo = isset($_SESSION['mensagem_tipo']) ? $_SESSION['mensagem_tipo'] : 'info';
    echo '<div class="mensagem '.$tipo.'">'.htmlspecialchars($_SESSION['mensagem']).'</div>';
    unset($_SESSION['mensagem'], $_SESSION['mensagem_tipo']);
}
