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
         if (!in_array($ext, $extensoesPermitidas)) {
             $erro = "Formato de imagem inválido. Somente JPG, PNG e WEBP.";
         } elseif ($_FILES['imagem']['size'] > $tamanhoMaximo) {
             $erro = "A imagem deve ter no máximo 2MB.";
         } else {
             $nomeImagem = uniqid('capa_') . '.' . $ext;
             move_uploaded_file($_FILES['imagem']['tmp_name'], __DIR__ . '/uploads/' . $nomeImagem);
         }
     }         $tamanhoMaximo = 2 * 1024 * 1024; // 2MB