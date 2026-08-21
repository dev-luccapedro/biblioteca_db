<?php
 require_once __DIR__ . '/includes/header.php';
 require_once __DIR__ . '/src/Repositories/LivroRepository.php';
 require_once __DIR__ . '/config/database.php';
 
 $livroRepo = new LivroRepository();
 $db = Database::getConnection();
 
 $categorias = $db->query("SELECT * FROM categorias")->fetchAll();
 $autores = $db->query("SELECT * FROM autores")->fetchAll();
 $id = $_GET['id'] ?? null;
 $livroData = null;
 $autoresSelecionados = [];
 $erro = '';
 
 if ($id) {
     $livroData = $livroRepo->buscarPorId((int)$id);
     if ($livroData) {
         $autoresSelecionados = array_column($livroData['autores'], 'id');
     }
     }
 if ($_SERVER['REQUEST_METHOD'] === 'POST') {
     $titulo = trim($_POST['titulo'] ?? '');
     $isbn = trim($_POST['isbn'] ?? '');
     $categoriaId = (int)($_POST['categoria_id'] ?? 0);
          $status = $_POST['status'] ?? 'disponivel';
     $autoresPost = $_POST['autores'] ?? [];
     $nomeImagem = $livroData['imagem'] ?? null;
     if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
         $ext = strtolower(pathinfo($_FILES['imagem']['name'], PATHINFO_EXTENSION));
         $extensoesPermitidas = ['jpg', 'png', 'webp'];
         $tamanhoMaximo = 2 * 1024 * 1024; // 2MB
         if (!in_array($ext, $extensoesPermitidas)) {
             $erro = "Formato de imagem inválido. Somente JPG, PNG e WEBP.";
         } elseif ($_FILES['imagem']['size'] > $tamanhoMaximo) {
             $erro = "A imagem deve ter no máximo 2MB.";
         } else {
             $nomeImagem = uniqid('capa_') . '.' . $ext;
             move_uploaded_file($_FILES['imagem']['tmp_name'], __DIR__ . '/uploads/' . $nomeImagem);
         }
     }         
     if (empty($erro)) {
         try {
             $livro = new Livro($titulo, $isbn, $categoriaId, $status, $nomeImagem, $id ? (int)$id : null);
             $livro->setAutoresIds($autoresPost);
             $livroRepo->salvar($livro);
 
             $_SESSION['mensagem'] = "Livro salvo com sucesso!";
             header("Location: livros.php");
             exit;
         } catch (Exception $e) {
             $erro = $e->getMessage();
         }
     }
 }
 ?>
  <h2><?= $id ? 'Editar' : 'Cadastrar' ?> Livro</h2>
 <?php if ($erro): ?><div class="alert-error"><?= $erro ?></div><?php endif; ?>
 
 <form method="POST" enctype="multipart/form-data">
     <div class="form-group">
         <label>Título:</label>
         <input type="text" name="titulo" value="<?= htmlspecialchars($livroData['titulo'] ?? '') ?>" required>
     </div>
     <div class="form-group">
         <label>ISBN:</label>
         <input type="text" name="isbn" value="<?= htmlspecialchars($livroData['isbn'] ?? '') ?>" required>
     </div>
     <div class="form-group">
         <label>Categoria (1:N):</label>
         <select name="categoria_id" required>
             <option value="">Selecione...</option>
             <?php foreach ($categorias as $cat): ?>
                 <option value="<?= $cat['id'] ?>" <?= ($livroData['categoria_id'] ?? '') == $cat['id'] ? 'selected' : '' ?>>
                     <?= htmlspecialchars($cat['nome']) ?>
                 </option>
             <?php endforeach; ?>
         </select>
     </div>
     <div class="form-group">
         <label>Autores (N:N - Seleção Múltipla):</label>
         <select name="autores[]" multiple style="height: 100px;">
             <?php foreach ($autores as $aut): ?>
                 <option value="<?= $aut['id'] ?>" <?= in_array($aut['id'], $autoresSelecionados) ? 'selected' : '' ?>>
                     <?= htmlspecialchars($aut['nome']) ?>
                 </option>
             <?php endforeach; ?>
         </select>
         <small>Segure Ctrl para selecionar mais de um autor.</small>
     </div>
     <div class="form-group">
         <label>Status:</label>
         <select name="status">
            <option value="disponivel" <?= ($livroData['status'] ?? '') == 'disponivel' ? 'selected' : '' ?>>Disponível</option>
             <option value="emprestado" <?= ($livroData['status'] ?? '') == 'emprestado' ? 'selected' : '' ?>>Emprestado</option>
             <option value="manutencao" <?= ($livroData['status'] ?? '') == 'manutencao' ? 'selected' : '' ?>>Em Manutenção</option>
         </select>
     </div>
     <div class="form-group">
         <label>Capa do Livro (Imagem):</label>
        <input type="file" name="imagem" accept="image/jpeg,image/png,image/webp">
        <?php if (!empty($livroData['imagem'])): ?>
            <p>Imagem atual: <br><img src="uploads/<?= $livroData['imagem'] ?>" width="100"></p>
        <?php endif; ?>
    </div>
    <button type="submit" class="btn">Salvar Livro</button>
    <a href="livros.php">Voltar</a>
 </form>
 <?php require_once __DIR__ . '/includes/footer.php'; ?>