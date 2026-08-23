 <?php
 require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/src/Repositories/LivroRepository.php'; 
 $id = $_GET['id'] ?? null;
$repo = new LivroRepository();
$livro = $id ? $repo->buscarPorId((int)$id) : null;

if (!$livro) {
	echo "<p>Livro não encontrado.</p>";
	require_once __DIR__ . '/includes/footer.php';
	exit;
}
?>
 <h2>Detalhes do Livro</h2>
 <div style="display: flex; gap: 20px;">
     <div>
         <?php if ($livro['imagem']): ?>
             <img src="uploads/<?= htmlspecialchars($livro['imagem']) ?>" width="200">
         <?php else: ?>
             <p><em>Sem imagem cadastrada.</em></p>
         <?php endif; ?>
     </div>
     <div>
         <h3><?= htmlspecialchars($livro['titulo']) ?></h3>
        <p><strong>ISBN:</strong> <?= htmlspecialchars($livro['isbn']) ?></p>
         <p><strong>Categoria:</strong> <?= htmlspecialchars($livro['categoria_nome']) ?></p>
         <p><strong>Status:</strong> <?= strtoupper($livro['status']) ?></p>
         <p><strong>Autor(es):</strong></p>
         <ul>
             <?php foreach ($livro['autores'] as $autor): ?>
                 <li><?= htmlspecialchars($autor['nome']) ?></li>
             <?php endforeach; ?>
         </ul>
         <a href="livro_form.php?id=<?= $livro['id'] ?>" class="btn">Editar</a>
         <a href="livros.php" class="btn btn-info">Voltar</a>
     </div>
 </div>
 <?php require_once __DIR__ . '/includes/footer.php'; ?>