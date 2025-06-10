<?php
require_once('../includes/db_connect.php');

// ID vindo pela URL
$id = $_GET['id'] ?? null;

if (!$id) {
    die("ID do usuário não informado.");
}

try {
    $stmt = $pdo->prepare("DELETE FROM usuarios WHERE id = ?");
    $stmt->execute([$id]);
    header("Location: ../views/user_list_view.php");
    exit;
} catch (PDOException $e) {
    echo "Erro ao excluir usuário: " . $e->getMessage();
}
