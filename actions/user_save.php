<?php
require_once('../includes/db_connect.php');

$id = $_POST['id'] ?? null;
$nome = $_POST['nome'] ?? '';
$email = $_POST['email'] ?? '';
$senha = $_POST['senha'] ?? '';
$cargo_id = $_POST['cargo_id'] ?? '';

if (!$nome || !$email || !$cargo_id) {
    die("Preencha todos os campos obrigatórios.");
}

try {
    if ($id) {
        // Atualização
        if (!empty($senha)) {
            $senha_hash = password_hash($senha, PASSWORD_DEFAULT);
            $sql = "UPDATE usuarios SET nome = ?, email = ?, senha = ?, cargo_id = ? WHERE id = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$nome, $email, $senha_hash, $cargo_id, $id]);
        } else {
            $sql = "UPDATE usuarios SET nome = ?, email = ?, cargo_id = ? WHERE id = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$nome, $email, $cargo_id, $id]);
        }
        header("Location: ../views/user_list_view.php");
        exit;
    } else {
        // Cadastro
        $senha_hash = password_hash($senha, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT INTO usuarios (nome, email, senha, cargo_id) VALUES (?, ?, ?, ?)");
        $stmt->execute([$nome, $email, $senha_hash, $cargo_id]);
        header("Location: ../views/user_register_view.php?success=1");
        exit;
    }
} catch (PDOException $e) {
    echo "Erro ao salvar usuário: " . $e->getMessage();
}
