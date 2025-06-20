<?php
require_once('../includes/db_connect.php');

header('Content-Type: application/json');

$response = ['success' => false, 'message' => 'Erro desconhecido'];

try {
    $nome = trim($_POST['nome'] ?? '');
    $grupo_id = $_POST['grupo_id'] ?? '';
    $unidade_id = $_POST['unidade_id'] ?? '';

    if (empty($nome) || empty($grupo_id) || empty($unidade_id)) {
        throw new Exception("Preencha todos os campos.");
    }

    // Verifica duplicidade
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM itens_estoque WHERE nome = ?");
    $stmt->execute([$nome]);

    if ($stmt->fetchColumn() > 0) {
        throw new Exception("Item com esse nome já existe.");
    }

    // Gera código
    $prefixo = strtoupper(substr($nome, 0, 3));
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM itens_estoque WHERE grupo_id = ?");
    $stmt->execute([$grupo_id]);
    $seq = $stmt->fetchColumn() + 1;
    $codigo = $prefixo . str_pad($seq, 4, "0", STR_PAD_LEFT);

    // Insere item
    $stmt = $pdo->prepare("INSERT INTO itens_estoque (nome, grupo_id, unidade_id, codigo, data_cadastro) VALUES (?, ?, ?, ?, NOW())");
    $stmt->execute([$nome, $grupo_id, $unidade_id, $codigo]);

    $response = ['success' => true, 'message' => 'Item cadastrado com sucesso!'];
} catch (Exception $e) {
    $response['message'] = $e->getMessage();
}

echo json_encode($response);
