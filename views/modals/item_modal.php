<!-- Modal Cadastro de Itens -->
<div class="modal fade" id="modalCadastroItem" tabindex="-1" role="dialog" aria-labelledby="modalItemLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form id="formCadastroItem" method="POST" action="../actions/item_register.php">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalItemLabel">Cadastro de itens do estoque</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div id="alertContainer"></div>
                    <div class="form-group">
                        <label for="nome">Nome do item</label>
                        <input type="text" class="form-control" name="nome" id="nome" required>
                    </div>

                    <div class="form-group">
                        <label for="grupo_id">Grupo de Estoque</label>
                        <select class="form-control" name="grupo_id" id="grupo_id" required>
                            <option value="">Selecione</option>
                            <?php
                            require_once __DIR__ . '/../../includes/db_connect.php';
                            try {
                                $stmt = $pdo->query("SELECT id, nome FROM grupos_estoque ORDER BY nome");
                                while ($g = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    echo "<option value='{$g['id']}'>{$g['nome']}</option>";
                                }
                            } catch (Exception $e) {
                                echo "<option disabled>Erro ao carregar grupos</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="unidade_id">Unidade de Medida</label>
                        <select class="form-control" name="unidade_id" id="unidade_id" required>
                            <option value="">Selecione</option>
                            <?php
                            try {
                                $stmt = $pdo->query("SELECT id, nome FROM unidades_medida ORDER BY nome");
                                while ($u = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    echo "<option value='{$u['id']}'>{$u['nome']}</option>";
                                }
                            } catch (Exception $e) {
                                echo "<option disabled>Erro ao carregar unidades</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <div class="alert alert-info mt-3">
                        O código do item será gerado automaticamente com base no grupo selecionado.
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Cadastrar</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </form>
    </div>
</div>