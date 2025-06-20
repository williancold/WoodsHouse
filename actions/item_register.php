<?php
require_once('../includes/db_connect.php');
header('Content-Type: application/json');

// Garantir limpeza de buffer
ob_clean();

$response = ['success' => false, 'message' => 'Erro desconhecido'];

try {
    $nome = trim($_POST['nome'] ?? '');
    $grupo_id = $_POST['grupo_id'] ?? '';
    $unidade_id = $_POST['unidade_id'] ?? '';

    if (empty($nome) || empty($grupo_id) || empty($unidade_id)) {
        throw new Exception("Preencha todos os campos.");
    }

    // Verificar duplicidade por nome
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM itens_estoque WHERE nome = ?");
    $stmt->execute([$nome]);
    if ($stmt->fetchColumn() > 0) {
        throw new Exception("Item com este nome já está cadastrado.");
    }

    // Obter nome do grupo
    $grupo = $pdo->prepare("SELECT nome FROM grupos_estoque WHERE id = ?");
    $grupo->execute([$grupo_id]);
    $grupo_nome = $grupo->fetchColumn();

    if (!$grupo_nome) {
        throw new Exception("Grupo de estoque inválido.");
    }

    // Gerar prefixo do grupo (3 primeiras letras sem acento/espaço)
    $prefixo = strtoupper(substr(preg_replace('/[^A-Z]/i', '', $grupo_nome), 0, 3));

    // Buscar último código existente com esse prefixo
    $stmt = $pdo->prepare("SELECT codigo FROM itens_estoque WHERE codigo LIKE ? ORDER BY codigo DESC LIMIT 1");
    $stmt->execute([$prefixo . '%']);
    $ultimo_codigo = $stmt->fetchColumn();

    $proximo_num = 1;
    if ($ultimo_codigo) {
        $num = intval(substr($ultimo_codigo, strlen($prefixo)));
        $proximo_num = $num + 1;
    }

    $codigo = $prefixo . str_pad($proximo_num, 3, '0', STR_PAD_LEFT);

    // Inserir novo item
    $stmt = $pdo->prepare("
        INSERT INTO itens_estoque (nome, grupo_id, unidade_id, codigo, data_cadastro)
        VALUES (?, ?, ?, ?, NOW())
    ");
    $stmt->execute([$nome, $grupo_id, $unidade_id, $codigo]);

    $response = [
        'success' => true,
        'message' => "Item cadastrado com sucesso: código {$codigo}."
    ];
} catch (Exception $e) {
    $response['message'] = $e->getMessage();
}

echo json_encode($response);
exit;
