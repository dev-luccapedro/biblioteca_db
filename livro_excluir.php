 <?php
 session_start();
  require_once __DIR__ . '/src/Repositories/LivroRepository.php';
 
 if (!isset($_SESSION['usuario'])) {
     header("Location: login.php");
     exit;
 }
  $id = $_GET['id'] ?? null;
 if ($id) {
     $repo = new LivroRepository();
     
     $livro = $repo->buscarPorId((int)$id);
     if ($livro && $livro['imagem'] && file_exists(__DIR__ . '/uploads/' . $livro['imagem'])) {
         unlink(__DIR__ . '/uploads/' . $livro['imagem']);
     }

    $repo->excluir((int)$id);
    $_SESSION['mensagem'] = "Livro excluído com sucesso!";
     header("Location: livros.php");
     exit;    





 }