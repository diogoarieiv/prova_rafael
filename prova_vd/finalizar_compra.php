<?php
session_start();
include('conexao.php');

// Verificar se o cliente está autenticado
if (!isset($_SESSION['cliente_id'])) {
    header('Location: login.php');
    exit();
}

// Verificar se os dados do carrinho foram enviados via POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $cliente_id = $_SESSION['cliente_id'];
    $produto_ids = $_POST['produto_id'];
    $quantidades = $_POST['quantidade'];
    $precos = $_POST['preco'];

    // Processar os itens do carrinho
    foreach ($produto_ids as $index => $produto_id) {
        $quantidade = $quantidades[$index];
        $preco = $precos[$index];

        // Inserir os dados na tabela carrinho_compras
        $stmt = $pdo->prepare("INSERT INTO carrinho_compras (cliente_id, produto_id, quantidade) VALUES (?, ?, ?)");
        $stmt->execute([$cliente_id, $produto_id, $quantidade]);
    }

    // Redirecionar para a página de confirmação ou de sucesso
    header('Location: sucesso.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Finalizar Compra</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Compra Finalizada com Sucesso!</h2>
    <p>Obrigado pela sua compra! Você será redirecionado em breve.</p>
</body>
</html>
