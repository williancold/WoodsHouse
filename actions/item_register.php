<?php
require_once '../includes/db_connect.php';

header('Content-Type: application/json');

function gerarCodigo($prefixo)
{
    return $prefixo . '-' . str_pad(rand(0, 99999), 5, '0', STR_PAD_LEFT);
}

try {
    $nome = trim($_POST['nome']);
    $grupo_id = intval($_POST['grupo_id']);
    $unidade_id = intval($_POST['unidade_id']);

    if (empty($nome) || !$grupo_id || !$unidade_id) {
        echo json_encode(['status' => 'danger', 'message' => 'Todos os campos são obrigatórios.']);
        exit;
    }

    $stmt = $pdo->prepare("SELECT COUNT(*) FROM itens_estoque WHERE nome = ?");
    $stmt->execute([$nome]);
    if ($stmt->fetchColumn() > 0) {
        echo json_encode(['status' => 'danger', 'message' => 'Nome do item já cadastrado.']);
        exit;
    }

    // Pega prefixo do grupo
    $stmt = $pdo->prepare("SELECT nome FROM grupos_estoque WHERE id = ?");
    $stmt->execute([$grupo_id]);
    $grupo_nome = $stmt->fetchColumn();
    if (!$grupo_nome) {
        echo json_encode(['status' => 'danger', 'message' => 'Grupo inválido.']);
        exit;
    }
    $prefixo = strtoupper(substr(preg_replace('/[^A-Za-z]/', '', $grupo_nome), 0, 3));

    // Gera código único
    do {
        $codigo = gerarCodigo($prefixo);
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM itens_estoque WHERE codigo = ?");
        $stmt->execute([$codigo]);
    } while ($stmt->fetchColumn() > 0);

    // Insere item
    $stmt = $pdo->prepare("INSERT INTO itens_estoque (nome, grupo_id, unidade_id, codigo) VALUES (?, ?, ?, ?)");
    $stmt->execute([$nome, $grupo_id, $unidade_id, $codigo]);

    echo json_encode(['status' => 'success', 'message' => 'Item cadastrado com sucesso.']);
} catch (Exception $e) {
    echo json_encode(['status' => 'danger', 'message' => 'Erro: ' . $e->getMessage()]);
}
exit;
