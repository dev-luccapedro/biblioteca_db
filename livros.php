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