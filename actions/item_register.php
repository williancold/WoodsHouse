<?php
require_once('../includes/db_connect.php');
header('Content-Type: application/json');

$response = ['success' => false, 'message' => ''];

try {
    $nome = trim($_POST['nome'] ?? '');
    $grupo_id = intval($_POST['grupo_id'] ?? 0);
    $unidade_id = intval($_POST['unidade_id'] ?? 0);

    if (!$nome || !$grupo_id || !$unidade_id) {
        throw new Exception("Todos os campos são obrigatórios.");
    }

    // Verifica duplicidade de nome
    $stmtCheck = $pdo->prepare("SELECT COUNT(*) FROM itens_estoque WHERE nome = ?");
    $stmtCheck->execute([$nome]);
    if ($stmtCheck->fetchColumn() > 0) {
        throw new Exception("Já existe um item com este nome.");
    }

    // Obter prefixo do grupo
    $stmtGrupo = $pdo->prepare("SELECT nome FROM grupos_estoque WHERE id = ?");
    $stmtGrupo->execute([$grupo_id]);
    $grupoNome = $stmtGrupo->fetchColumn();
    if (!$grupoNome) {
        throw new Exception("Grupo inválido.");
    }

    $prefixo = strtoupper(substr(preg_replace('/[^A-Za-z]/', '', $grupoNome), 0, 3));

    // Geração de código aleatório com verificação de duplicidade
    $tentativas = 0;
    do {
        $numeroAleatorio = str_pad(random_int(0, 99999), 5, '0', STR_PAD_LEFT);
        $codigo = "{$prefixo}-{$numeroAleatorio}";

        $stmtCodigoCheck = $pdo->prepare("SELECT COUNT(*) FROM itens_estoque WHERE codigo = ?");
        $stmtCodigoCheck->execute([$codigo]);
        $duplicado = $stmtCodigoCheck->fetchColumn() > 0;

        $tentativas++;
        if ($tentativas > 10) {
            throw new Exception("Falha ao gerar código único após 10 tentativas.");
        }
    } while ($duplicado);

    // Inserção do item
    $stmtInsert = $pdo->prepare("
        INSERT INTO itens_estoque (nome, grupo_id, unidade_id, codigo, data_cadastro)
        VALUES (?, ?, ?, ?, NOW())
    ");
    $stmtInsert->execute([$nome, $grupo_id, $unidade_id, $codigo]);

    $response['success'] = true;
    $response['message'] = "Item cadastrado com sucesso! Código: <strong>{$codigo}</strong>";
} catch (Exception $e) {
    $response['message'] = $e->getMessage();
}

echo json_encode($response);
