<?php
require_once __DIR__ . '/../config/db.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../includes/auth.php';
exigir_admin();

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$modo = $id > 0 ? 'editar' : 'criar';

$titulo = '';
$categoria = '';
$conteudo = '';
$destaque = 0;
$erros = [];

if ($modo === 'editar') {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        $stmt = $conexao->prepare("select titulo, categoria, conteudo, destaque from noticias where id = ?");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $resultado = $stmt->get_result();
        if ($row = $resultado->fetch_assoc()) {
            $titulo = $row['titulo'];
            $categoria = $row['categoria'];
            $conteudo = $row['conteudo'];
            $destaque = (int) $row['destaque'];
        } else {
            $_SESSION['mensagem'] = 'noticia nao encontrada';
            $_SESSION['mensagem_tipo'] = 'erro';
            header('Location: noticias_listar.php');
            exit;
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = trim($_POST['titulo'] ?? '');
    $categoria = trim($_POST['categoria'] ?? '');
    $conteudo = trim($_POST['conteudo'] ?? '');
    $destaque = isset($_POST['destaque']) ? 1 : 0;

    if ($titulo === '') {
        $erros[] = 'informe o titulo';
    }
    if ($categoria === '') {
        $erros[] = 'informe a categoria';
    }
    if ($conteudo === '') {
        $erros[] = 'informe o conteudo';
    }

    if ($destaque === 1) {
        if ($modo === 'editar') {
            $stmt = $conexao->prepare("select count(*) as total from noticias where destaque = 1 and id <> ?");
            $stmt->bind_param('i', $id);
        } else {
            $stmt = $conexao->prepare("select count(*) as total from noticias where destaque = 1");
        }
        $stmt->execute();
        $res = $stmt->get_result()->fetch_assoc();
        if ((int) $res['total'] >= 5) {
            $erros[] = 'limite de 5 noticias em destaque atingido';
        }
    }

    if (empty($erros)) {
        $autor_id = $_SESSION['usuario_id'];
        if ($modo === 'criar') {
            $stmt = $conexao->prepare("insert into noticias (titulo, conteudo, categoria, destaque, autor_id) values (?,?,?,?,?)");
            $stmt->bind_param('sssii', $titulo, $conteudo, $categoria, $destaque, $autor_id);
            if ($stmt->execute()) {
                $_SESSION['mensagem'] = 'noticia criada com sucesso';
                $_SESSION['mensagem_tipo'] = 'sucesso';
                header('Location: noticias_listar.php');
                exit;
            } else {
                $erros[] = 'erro ao salvar noticia';
            }
        } else {
            $stmt = $conexao->prepare("update noticias set titulo = ?, conteudo = ?, categoria = ?, destaque = ? where id = ?");
            $stmt->bind_param('sssii', $titulo, $conteudo, $categoria, $destaque, $id);
            if ($stmt->execute()) {
                $_SESSION['mensagem'] = 'noticia atualizada com sucesso';
                $_SESSION['mensagem_tipo'] = 'sucesso';
                header('Location: noticias_listar.php');
                exit;
            } else {
                $erros[] = 'erro ao atualizar noticia';
            }
        }
    }
}

include __DIR__ . '/../includes/header.php';
?>
<h2><?php echo $modo === 'criar' ? 'nova noticia' : 'editar noticia'; ?></h2>
<?php if (!empty($erros)): ?>
    <ul class="erros">
        <?php foreach ($erros as $e): ?>
            <li><?php echo htmlspecialchars($e); ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>
<form method="post" class="form-noticia">
    <label>Título</label>
    <input type="text" name="titulo" maxlength="150" value="<?php echo htmlspecialchars($titulo); ?>" required>
    <label>Categoria</label>
    <input type="text" name="categoria" maxlength="50" value="<?php echo htmlspecialchars($categoria); ?>" required>
    <label>Conteudo</label>
    <textarea name="conteudo" rows="6" required><?php echo htmlspecialchars($conteudo); ?></textarea>
    <label class="check">
        <input type="checkbox" name="destaque" value="1" <?php echo $destaque ? 'checked' : ''; ?>>
        Notícia em destaque
    </label>
    <button type="submit"><?php echo $modo === 'criar' ? 'criar' : 'salvar'; ?></button>
    <a class="botao secundario" href="noticias_listar.php">Voltar</a>
</form>
<?php
include __DIR__ . '/../includes/footer.php';
