<?php
session_start();

// Se o usuário já estiver logado, vai direto para a lista de livros
if (isset($_SESSION['usuario'])) {
    header("Location: livros.php");
    exit;
}

// Caso contrário, redireciona para a tela de login
header("Location: login.php");
exit;