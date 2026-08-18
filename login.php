 <?php
 require_once __DIR__ . '/src/Repositories/UsuarioRepository.php';
 
 $erro = '';
 if ($_SERVER['REQUEST_METHOD'] === 'POST') {
     $email = trim($_POST['email'] ?? '');
     $senha = trim($_POST['senha'] ?? '');
   
     