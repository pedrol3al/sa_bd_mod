<!-- Dentro do form, substitua a seção de equipamentos por: -->
<div class="form-section">
    <h2>Equipamentos e Serviços</h2>
    
    <!-- Equipamentos existentes -->
    <?php foreach ($equipamentos as $equipamento): ?>
    <div class="editable-equipment">
        <h5>Editar Equipamento</h5>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Fabricante:</label>
                    <input type="text" name="equipamentos[<?= $equipamento['id'] ?>][fabricante]" 
                           class="form-control" value="<?= htmlspecialchars($equipamento['fabricante']) ?>" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Modelo:</label>
                    <input type="text" name="equipamentos[<?= $equipamento['id'] ?>][modelo]" 
                           class="form-control" value="<?= htmlspecialchars($equipamento['modelo']) ?>" required>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Nº Série:</label>
                    <input type="text" name="equipamentos[<?= $equipamento['id'] ?>][num_serie]" 
                           class="form-control" value="<?= htmlspecialchars($equipamento['num_serie']) ?>">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Nº Aparelho:</label>
                    <input type="text" name="equipamentos[<?= $equipamento['id'] ?>][num_aparelho]" 
                           class="form-control" value="<?= htmlspecialchars($equipamento['num_aparelho']) ?>">
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Defeito Reclamado:</label>
                    <textarea name="equipamentos[<?= $equipamento['id'] ?>][defeito_reclamado]" 
                              class="form-control" rows="2"><?= htmlspecialchars($equipamento['defeito_reclamado']) ?></textarea>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Condição:</label>
                    <textarea name="equipamentos[<?= $equipamento['id'] ?>][condicao]" 
                              class="form-control" rows="2"><?= htmlspecialchars($equipamento['condicao']) ?></textarea>
                </div>
            </div>
        </div>

        <!-- Serviços do equipamento -->
        <h6>Serviços:</h6>
        <?php foreach ($servicos_por_equipamento[$equipamento['id']] as $servico): ?>
        <div class="editable-service">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Tipo Serviço:</label>
                        <input type="text" name="equipamentos[<?= $equipamento['id'] ?>][servicos][<?= $servico['id'] ?>][tipo_servico]" 
                               class="form-control" value="<?= htmlspecialchars($servico['tipo_servico']) ?>" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Valor:</label>
                        <input type="number" step="0.01" name="equipamentos[<?= $equipamento['id'] ?>][servicos][<?= $servico['id'] ?>][valor]" 
                               class="form-control" value="<?= $servico['valor'] ?>" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Produto Utilizado:</label>
                        <select name="equipamentos[<?= $equipamento['id'] ?>][servicos][<?= $servico['id'] ?>][id_produto]" class="form-control">
                            <option value="">Nenhum</option>
                            <?php foreach ($produtos as $produto): ?>
                            <option value="<?= $produto['id_produto'] ?>" <?= $produto['id_produto'] == $servico['id_produto'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($produto['nome']) ?> - R$ <?= number_format($produto['preco'], 2, ',', '.') ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Descrição:</label>
                        <textarea name="equipamentos[<?= $equipamento['id'] ?>][servicos][<?= $servico['id'] ?>][descricao]" 
                                  class="form-control" rows="2"><?= htmlspecialchars($servico['descricao']) ?></textarea>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
        
        <!-- Botão para adicionar novo serviço -->
        <button type="button" class="btn btn-success btn-sm add-service-btn" data-equipamento="<?= $equipamento['id'] ?>">
            <i class="bi bi-plus-circle"></i> Adicionar Serviço
        </button>
    </div>
    <?php endforeach; ?>

    <!-- Botão para adicionar novo equipamento -->
    <button type="button" class="btn btn-primary" id="add-equipment-btn">
        <i class="bi bi-plus-circle"></i> Adicionar Equipamento
    </button>
</div>