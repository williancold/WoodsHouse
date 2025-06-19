<!-- Modal Cadastro de Itens -->
<div class="modal fade" id="modalCadastroItem" tabindex="-1" role="dialog" aria-labelledby="modalItemLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form id="formCadastroItem">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Cadastro de itens do estoque</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="nome">Nome do item</label>
                        <input type="text" class="form-control" name="nome" id="nome" required>
                    </div>
                    <div class="form-group">
                        <label for="grupo_id">Grupo de Estoque</label>
                        <select class="form-control" name="grupo_id" id="grupo_id" required>
                            <option value="">Selecione</option>
                            <?php
                            require_once('../includes/db.php');
                            $grupos = $conn->query("SELECT id, nome FROM grupos_estoque");
                            while ($g = $grupos->fetch(PDO::FETCH_ASSOC)) {
                                echo "<option value='{$g['id']}'>{$g['nome']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="unidade_id">Unidade de Medida</label>
                        <select class="form-control" name="unidade_id" id="unidade_id" required>
                            <option value="">Selecione</option>
                            <?php
                            $unidades = $conn->query("SELECT id, nome FROM unidades_medida");
                            while ($u = $unidades->fetch(PDO::FETCH_ASSOC)) {
                                echo "<option value='{$u['id']}'>{$u['nome']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Cadastrar</button>
                </div>
            </div>
        </form>
    </div>
</div>