<?php
session_start();
include('conexao.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validação e upload de arquivos
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);
    
    // Foto
    if ($_FILES['foto']['type'] == 'image/jpeg' || $_FILES['foto']['type'] == 'image/png') {
        $foto = 'uploads/' . basename($_FILES['foto']['name']);
        move_uploaded_file($_FILES['foto']['tmp_name'], $foto);
    } else {
        echo "Erro: Foto deve ser JPEG ou PNG.";
        exit;
    }
    
    // PDF
    if ($_FILES['pdf']['type'] == 'application/pdf') {
        $pdf = 'uploads/' . basename($_FILES['pdf']['name']);
        move_uploaded_file($_FILES['pdf']['tmp_name'], $pdf);
    } else {
        echo "Erro: O arquivo PDF é obrigatório.";
        exit;
    }

    // Inserção no banco
    $sql = "INSERT INTO clientes (nome, email, senha, foto, pdf) VALUES (:nome, :email, :senha, :foto, :pdf)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['nome' => $nome, 'email' => $email, 'senha' => $senha, 'foto' => $foto, 'pdf' => $pdf]);

    $_SESSION['cadastro'] = 'Cadastro realizado com sucesso!';
    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Cadastro</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Cadastro de Cliente</h2>
    <form method="POST" enctype="multipart/form-data">
        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" required><br><br>

        <label for="email">E-mail:</label>
        <input type="email" id="email" name="email" required><br><br>

        <label for="senha">Senha:</label>
        <input type="password" id="senha" name="senha" required><br><br>

        <label for="foto">Foto de Perfil (JPEG ou PNG):</label>
        <input type="file" id="foto" name="foto" accept="image/jpeg, image/png" required><br><br>

        <label for="pdf">PDF (Comprovante de Identidade):</label>
        <input type="file" id="pdf" name="pdf" accept="application/pdf" required><br><br>

        <button type="submit">Cadastrar</button>
    </form>
</body>
</html>
