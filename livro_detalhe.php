 <?php
 require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/src/Repositories/LivroRepository.php'; 
 $id = $_GET['id'] ?? null;
$repo = new LivroRepository();
$livro = $id ? $repo->buscarPorId((int)$id) : null;

if (!$livro) {
	echo "<p>Livro não encontrado.</p>";
	require_once __DIR__ . '/includes/footer.php';
	exit;
}
?>
