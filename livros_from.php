<?php
 require_once __DIR__ . '/includes/header.php';
 require_once __DIR__ . '/src/Repositories/LivroRepository.php';
 require_once __DIR__ . '/config/database.php';
 
 $livroRepo = new LivroRepository();
 $db = Database::getConnection();
 
 $categorias = $db->query("SELECT * FROM categorias")->fetchAll();
 $autores = $db->query("SELECT * FROM autores")->fetchAll();
 