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
