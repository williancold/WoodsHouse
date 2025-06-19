<?php
require_once('../includes/db.php');

$nome = trim($_POST['nome']);
$grupo_id = $_POST['grupo_id'];
$unidade_id = $_POST['unidade_id'];

if (!$nome || !$grupo_id || !$unidade_id) {
    echo json_encode(['status' => 'error', 'message' => 'Preencha todos os campos']);
    exit;
}

// Verifica duplicidade
$check = $conn->prepare("SELECT COUNT(*) FROM itens_estoque WHERE nome = ?");
$check->execute([$nome]);
if ($check->fetchColumn() > 0) {
    echo json_encode(['status' => 'error', 'message' => 'Item já cadastrado']);
    exit;
}

// Pega prefixo
$grupo = $conn->prepare("SELECT nome FROM grupos_estoque WHERE id = ?");
$grupo->execute([$grupo_id]);
$prefixo = strtoupper(substr($grupo->fetchColumn(), 0, 3));

// Conta quantos já existem nesse grupo
$count = $conn->prepare("SELECT COUNT(*) FROM itens_estoque WHERE grupo_id = ?");
$count->execute([$grupo_id]);
$num = $count->fetchColumn() + 1;

$codigo = $prefixo . str_pad($num, 3, '0', STR_PAD_LEFT);

// Insere
$stmt = $conn->prepare("INSERT INTO itens_estoque (data_cadastro, nome, grupo_id, unidade_id, codigo) VALUES (NOW(), ?, ?, ?, ?)");
$stmt->execute([$nome, $grupo_id, $unidade_id, $codigo]);

echo json_encode(['status' => 'ok']);
