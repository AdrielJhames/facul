<?php
$host = 'localhost';
$usuario = 'root';
$senha = '';
$banco = 'portal_noticias';

$conexao = new mysqli($host, $usuario, $senha, $banco);

if ($conexao->connect_error) {
    die('erro de conexao: ' . $conexao->connect_error);
}

$conexao->set_charset('utf8');
