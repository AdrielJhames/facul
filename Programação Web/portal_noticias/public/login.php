<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../config/db.php';

$erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $senha = trim($_POST['senha'] ?? '');
    if ($email === '' || $senha === '') {
        $erro = 'Preencha email e senha';
    } else {
        $stmt = $conexao->prepare("select id, nome, email, senha, tipo from usuarios where email = ? limit 1");
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($user = $result->fetch_assoc()) {
            if (password_verify($senha, $user['senha'])) {
                $_SESSION['usuario_id'] = $user['id'];
                $_SESSION['usuario_nome'] = $user['nome'];
                $_SESSION['usuario_tipo'] = $user['tipo'];
                $_SESSION['mensagem'] = 'login realizado com sucesso';
                $_SESSION['mensagem_tipo'] = 'sucesso';

                if ($user['tipo'] === 'admin') {
                    header('Location: ../admin/noticias_listar.php');
                } else {
                    header('Location: index.php');
                }
                exit;
            } else {
                $erro = 'Senha incorreta';
            }
        } else {
            $erro = 'Usuário não encontrado';
        }
    }
}

include __DIR__ . '/../includes/header.php';
?>
<h2>Login</h2>
<form method="post" class="form-login">
<label>Email</label>
<input type="email" name="email" required>
<label>Senha</label>
<input type="password" name="senha" required>
<?php if ($erro): ?>
<p class="erro"><?php echo htmlspecialchars($erro); ?></p>
<?php endif; ?>
<button type="submit">Entrar</button>
</form>
<?php
include __DIR__ . '/../includes/footer.php';
