 <?php
 require_once __DIR__ . '/src/Repositories/UsuarioRepository.php';
 
 $erro = '';
 if ($_SERVER['REQUEST_METHOD'] === 'POST') {
     $email = trim($_POST['email'] ?? '');
     $senha = trim($_POST['senha'] ?? '');
   
     $repo = new UsuarioRepository();
     $usuario = $repo->buscarPorEmail($email);

     if ($usuario && password_verify($senha, $usuario['senha'])) {
         session_start();
         $_SESSION['usuario'] = [
             'id' => $usuario['id'],
             'nome' => $usuario['nome'],
             'email' => $usuario['email']
         ];
         header("Location: livros.php");
         exit;
     } else {
         $erro = "E-mail ou senha inválidos.";
     }
 }
