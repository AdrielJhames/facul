<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../config/db.php';

$erros = [];
$nome = '';
$email = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $senha = trim($_POST['senha'] ?? '');
    $senha2 = trim($_POST['senha2'] ?? '');

    if ($nome === '') {
        $erros[] = 'Informe o nome';
    }
    if ($email === '') {
        $erros[] = 'Informe o email';
    }
    if ($senha === '') {
        $erros[] = 'Informe a senha';
    }
    if ($senha2 === '') {
        $erros[] = 'Confirme a senha';
    }
    if ($senha !== '' && strlen($senha) < 6) {
        $erros[] = 'A senha deve ter pelo menos 6 caracteres';
    }
    if ($senha !== '' && $senha2 !== '' && $senha !== $senha2) {
        $erros[] = 'As senhas nao coincidem';
    }

    if (empty($erros)) {
        $stmt = $conexao->prepare("select id from usuarios where email = ? limit 1");
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $res = $stmt->get_result();
        if ($res->num_rows > 0) {
            $erros[] = 'Email já cadastrado';
        }
    }

    if (empty($erros)) {
        $hash = password_hash($senha, PASSWORD_DEFAULT);
        $tipo = 'editor';
        $stmt = $conexao->prepare("insert into usuarios (nome, email, senha, tipo) values (?,?,?,?)");
        $stmt->bind_param('ssss', $nome, $email, $hash, $tipo);
        if ($stmt->execute()) {
            $_SESSION['mensagem'] = 'Cadastro realizado, faça login';
            $_SESSION['mensagem_tipo'] = 'sucesso';
            header('Location: ../public/login.php');
            exit;
        } else {
            $erros[] = 'Erro ao cadastrar usuario';
        }
    }
}

include __DIR__ . '/../includes/header.php';
?>
<h2>Cadastro de usuario</h2>
<?php if (!empty($erros)): ?>
<ul class="erros">
<?php foreach ($erros as $e): ?>
<li><?php echo htmlspecialchars($e); ?></li>
<?php endforeach; ?>
</ul>
<?php endif; ?>
<form method="post" class="form-cadastro">
<label>Nome</label>
<input type="text" name="nome" maxlength="100" value="<?php echo htmlspecialchars($nome); ?>" required>
<label>Email</label>
<input type="email" name="email" maxlength="100" value="<?php echo htmlspecialchars($email); ?>" required>
<label>Senha</label>
<input type="password" name="senha" required>
<label>Confirmar senha</label>
<input type="password" name="senha2" required>
<button type="submit">Cadastrar</button>
<a class="botao secundario" href="../public/login.php">Já possuo uma conta</a>
</form>
<?php
include __DIR__ . '/../includes/footer.php';
