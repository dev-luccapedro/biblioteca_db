 <?php
 if (session_status() === PHP_SESSION_NONE) {
     session_start();
 }

 $paginasPublicas = ['login.php'];
 $paginaAtual = basename($_SERVER['PHP_SELF']);
 
 if (!in_array($paginaAtual, $paginasPublicas) && !isset($_SESSION['usuario'])) {
     header("Location: login.php");
     exit;
 }

?>

 <!DOCTYPE html>
 <html lang="pt-br">
 <head>
     <meta charset="UTF-8">
     <title>Sistema de Biblioteca Online</title>
     
 </head>
 <body>
 <?php if (isset($_SESSION['usuario'])): ?>
 <header>
     <h2>📚 Biblioteca Online</h2>
     <nav>
         <span>Olá, <?= htmlspecialchars($_SESSION['usuario']['nome']) ?></span>
         <a href="livros.php">Livros</a>
         <a href="logout.php" style="color: #ff6b6b;">Sair</a>
     </nav>
 </header>
 <?php endif; ?>
 <div class="container">























 