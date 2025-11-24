<?php
require_once __DIR__ . '/../config/db.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../includes/auth.php';
exigir_admin();
include __DIR__ . '/../includes/header.php';

$result = $conexao->query("select id, titulo, categoria, data_publicacao, destaque from noticias order by data_publicacao desc");
?>
<div class="topo-lista">
<h2>Notícias</h2>
<a class="botao" href="noticias_form.php">Nova notícia</a>
</div>
<table class="tabela">
<thead>
<tr>
<th>Id</th>
<th>Título</th>
<th>Categoria</th>
<th>Data</th>
<th>Destaque</th>
<th>Ações</th>
</tr>
</thead>
<tbody>
<?php if ($result && $result->num_rows > 0): ?>
<?php while ($n = $result->fetch_assoc()): ?>
<tr>
<td><?php echo $n['id']; ?></td>
<td><?php echo htmlspecialchars($n['titulo']); ?></td>
<td><?php echo htmlspecialchars($n['categoria']); ?></td>
<td><?php echo date('d/m/Y H:i', strtotime($n['data_publicacao'])); ?></td>
<td><?php echo $n['destaque'] ? 'sim' : 'nao'; ?></td>
<td>
<a href="noticias_form.php?id=<?php echo $n['id']; ?>">Editar</a>
<a href="noticias_excluir.php?id=<?php echo $n['id']; ?>" onclick="return confirm('tem certeza que deseja excluir?');">Excluir</a>
</td>
</tr>
<?php endwhile; ?>
<?php else: ?>
<tr><td colspan="6">Nenhuma notícia cadastrada.</td></tr>
<?php endif; ?>
</tbody>
</table>
<?php
include __DIR__ . '/../includes/footer.php';
