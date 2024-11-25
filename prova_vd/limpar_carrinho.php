<?php
// Limpar o carrinho
setcookie('carrinho', '', time() - 3600, "/"); // Excluir cookie
header('Location: carrinho.php');
exit();
?>
