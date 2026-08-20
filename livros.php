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

 <a href="livro_form.php" class="btn">+ Novo Livro</a>
 
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