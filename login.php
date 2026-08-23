 <?php
 require_once __DIR__ . '/src/Repositories/UsuarioRepository.php';
 
 $erro = '';
 if ($_SERVER['REQUEST_METHOD'] === 'POST') {
     $email = trim($_POST['email'] ?? '');
     $senha = trim($_POST['senha'] ?? '');
   
     $repo = new UsuarioRepository();
     $usuario = $repo->buscarPorEmail($email);

     if ($usuario && $senha === $usuario['senha']) {
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

 require_once __DIR__ . '/includes/header.php';
 ?>

 <h2>Login de Acesso</h2>
 <?php if ($erro): ?><div class="alert-error"><?= $erro ?></div><?php endif; ?>
 
 <form method="POST">
     <div class="form-group">
         <label>E-mail:</label>
         <input type="email" name="email" required placeholder="admin@biblioteca.com">
     </div>
     <div class="form-group">
         <label>Senha:</label>
        <input type="password" name="senha" required placeholder="admin123">
     </div>
     <button type="submit" class="btn">Entrar</button>
 </form>

 <?php require_once __DIR__ . '/includes/footer.php'; ?>