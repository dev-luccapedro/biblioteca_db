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


























 