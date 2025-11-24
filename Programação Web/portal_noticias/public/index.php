<?php
include __DIR__ . '/../includes/header.php';

$sql_destaque = "select id, titulo, categoria, data_publicacao from noticias where destaque = 1 order by data_publicacao desc limit 3";
$result_destaque = $conexao->query($sql_destaque);

$sql_ultimas = "select id, titulo, categoria, data_publicacao from noticias order by data_publicacao desc limit 10";
$result_ultimas = $conexao->query($sql_ultimas);
?>

<h2>Notícias em destaque</h2>

<div class="lista-noticias destaque">
<?php if ($result_destaque && $result_destaque->num_rows > 0): ?>
<?php while ($n = $result_destaque->fetch_assoc()): ?>

<article class="noticia">
<h3><a href="noticia.php?id=<?php echo $n['id']; ?>"><?php echo htmlspecialchars($n['titulo']); ?></a></h3>
<p class="meta"><?php echo htmlspecialchars($n['categoria']); ?> - <?php echo date('d/m/Y H:i', strtotime($n['data_publicacao'])); ?></p>
</article>

<?php endwhile; ?>
<?php else: ?>

<p>Nenhuma notícia em destaque.</p>

<?php endif; ?>
</div>

<h2>Ultimas notícias</h2>

<div class="lista-noticias">
<?php if ($result_ultimas && $result_ultimas->num_rows > 0): ?>
<?php while ($n = $result_ultimas->fetch_assoc()): ?>
<article class="noticia">
<h3><a href="noticia.php?id=<?php echo $n['id']; ?>"><?php echo htmlspecialchars($n['titulo']); ?></a></h3>
<p class="meta"><?php echo htmlspecialchars($n['categoria']); ?> - <?php echo date('d/m/Y H:i', strtotime($n['data_publicacao'])); ?></p>
</article>
<?php endwhile; ?>
<?php else: ?>

<p>Nenhuma notícia cadastrada.</p>

<?php endif; ?>
</div>
<?php
include __DIR__ . '/../includes/footer.php';
