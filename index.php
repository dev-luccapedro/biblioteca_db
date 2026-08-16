<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <metaz charset="UTF-8">
    <title>Meu Site PHP e HTML</title>
       <link rel="stylesheet" href="index.css">
</head>
<body>
    <h1>Bem-vindo ao meu site</h1>
    <p>Esta parte é apenas HTML puro.</p>

    <?php
        // Aqui começa o código PHP processado pelo servidor
        $mensagem = "Olá! Este texto foi gerado dinamicamente usando PHP.";
        echo "<p style='color: red;'>$mensagem</p>";
    ?>
</body>
</html>
