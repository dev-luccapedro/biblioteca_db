<?php
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/src/Repositories/LivroRepository.php';
require_once __DIR__ . '/config/database.php';

 $repo = new LivroRepository();
 $db = Database::getConnection();

 $busca = $_GET['busca'] ?? '';
 $categoriaId = $_GET['categoria_id'] ?? '';
 
 $livros = $repo->listarTodos($busca, $categoriaId);
 $categorias = $db->query("SELECT * FROM categorias")->fetchAll();
 ?>

 <h2>Gestão de Livros</h2>
 <?php if (isset($_SESSION['mensagem'])): ?>
     <div class="alert-success"><?= $_SESSION['mensagem']; unset($_SESSION['mensagem']); ?></div>
 <?php endif; ?>

 <a href="livros_form.php" class="btn">+ Novo Livro</a>
 
 <form method="GET" style="margin-top: 15px; display: flex; gap: 10px;">
     <input type="text" name="busca" placeholder="Buscar por Título ou ISBN..." value="<?= htmlspecialchars($busca) ?>">
     <select name="categoria_id">
         <option value="">Todas as Categorias</option>
         <?php foreach ($categorias as $cat): ?>
             <option value="<?= $cat['id'] ?>" <?= $categoriaId == $cat['id'] ? 'selected' : '' ?>>
                 <?= htmlspecialchars($cat['nome']) ?>
             </option>
         <?php endforeach; ?>
     </select>
     <button type="submit" class="btn btn-info">Filtrar</button>
 </form>
 <table>
     <thead>
         <tr>
             <th>Capa</th>
             <th>Título</th>
             <th>ISBN</th>
             <th>Categoria</th>
             <th>Autor(es)</th>
             <th>Status</th>
             <th>Ações</th>
         </tr>
     </thead>
     <tbody>
         <?php foreach ($livros as $l): ?>
         <tr>
             <td>
                 <?php if ($l['imagem']): ?>
                     <img src="uploads/<?= htmlspecialchars($l['imagem']) ?>" width="50" height="70" style="object-fit: cover;">
                 <?php else: ?>
                     <span>Sem Capa</span>
                 <?php endif; ?>
             </td>
             <td><?= htmlspecialchars($l['titulo']) ?></td>
             <td><?= htmlspecialchars($l['isbn']) ?></td>
             <td><?= htmlspecialchars($l['categoria_nome']) ?></td>
             <td><?= htmlspecialchars($l['autores'] ?? 'Sem autor') ?></td>
             <td><strong><?= strtoupper($l['status']) ?></strong></td>
             <td>
                 <a href="livro_detalhe.php?id=<?= $l['id'] ?>" class="btn btn-info">Ver</a>
                 <a href="livros_form.php?id=<?= $l['id'] ?>" class="btn">Editar</a>
                 <a href="livro_excluir.php?id=<?= $l['id'] ?>" class="btn btn-danger" onclick="return confirm('Tem certeza?')">Excluir</a>
             </td>
         </tr>
         <?php endforeach; ?>
     </tbody>
 </table>
<?php require_once __DIR__ . '/includes/footer.php'; ?>