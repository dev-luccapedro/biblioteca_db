 <?php
 session_start();
  require_once __DIR__ . '/src/Repositories/LivroRepository.php';
 
 if (!isset($_SESSION['usuario'])) {
     header("Location: login.php");
     exit;
 }