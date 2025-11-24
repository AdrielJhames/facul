<?php
include __DIR__ . '/../includes/header.php';

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

$stmt = $conexao->prepare("select n.titulo, n.conteudo, n.categoria, n.data_publicacao, u.nome as autor from noticias n left join usuarios u on n.autor_id = u.id where n.id = ?");
$stmt->bind_param('i', $id);
$stmt->execute();
$result = $stmt->get_result();
$noticia = $result->fetch_assoc();
?>
<?php if ($noticia): ?>
<article class="noticia-detalhe">
<h2><?php echo htmlspecialchars($noticia['titulo']); ?></h2>
<p class="meta"><?php echo htmlspecialchars($noticia['categoria']); ?> - <?php echo date('d/m/Y H:i', strtotime($noticia['data_publicicao'] ?? $noticia['data_publicacao'])); ?><?php if ($noticia['autor']): ?> - por <?php echo htmlspecialchars($noticia['autor']); ?><?php endif; ?></p>
<p><?php echo nl2br(htmlspecialchars($noticia['conteudo'])); ?></p>
</article>
<?php else: ?>
<p>Noticia não encontrada.</p>
<?php endif; ?>
<?php
include __DIR__ . '/../includes/footer.php';
