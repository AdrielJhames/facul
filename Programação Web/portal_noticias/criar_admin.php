<?php
require_once __DIR__ . '/config/db.php';

$nome = 'admin';
$email = 'admin@teste.com';
$senha = password_hash('123456', PASSWORD_DEFAULT);
$tipo = 'admin';

$stmt = $conexao->prepare("insert into usuarios (nome, email, senha, tipo) values (?,?,?,?)");
$stmt->bind_param('ssss', $nome, $email, $senha, $tipo);

if ($stmt->execute()) {
    echo 'admin criado';
} else {
    echo 'erro ao criar admin';
}
