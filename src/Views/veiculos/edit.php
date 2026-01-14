<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white py-3">
                    <h5 class="mb-0 fw-bold text-uppercase"><i class="fas fa-edit me-2"></i>Editar Veículo</h5>
                </div>
                <div class="card-body p-4">
                    
                    <form action="/veiculos/update" method="POST" enctype="multipart/form-data">
                        
                        <input type="hidden" name="id" value="<?= $veiculo['id'] ?>">

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-uppercase">Marca</label>
                                <input type="text" name="marca" class="form-control" value="<?= $veiculo['marca'] ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-uppercase">Modelo</label>
                                <input type="text" name="modelo" class="form-control" value="<?= $veiculo['modelo'] ?>" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label class="form-label fw-bold small text-uppercase">Ano Fab.</label>
                                <input type="number" name="ano_fabricacao" class="form-control" value="<?= $veiculo['ano_fabricacao'] ?>" required>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-bold small text-uppercase">Ano Mod.</label>
                                <input type="number" name="ano_modelo" class="form-control" value="<?= $veiculo['ano_modelo'] ?>" required>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-bold small text-uppercase">KM</label>
                                <input type="number" name="km" class="form-control" value="<?= $veiculo['km'] ?>" required>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-bold small text-uppercase">Valor (R$)</label>
                                <input type="number" step="0.01" name="valor" class="form-control" value="<?= $veiculo['valor'] ?>" required>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold small text-uppercase">Descrição</label>
                            <textarea name="descricao" class="form-control" rows="4"><?= $veiculo['descricao'] ?></textarea>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold small text-uppercase">Foto do Veículo</label>
                            
                            <?php if($veiculo['url_foto']): ?>
                                <div class="mb-2">
                                    <img src="/<?= $veiculo['url_foto'] ?>" alt="Foto Atual" style="height: 100px; border-radius: 5px; border: 1px solid #ddd;">
                                    <span class="text-muted small ms-2">Foto Atual</span>
                                </div>
                            <?php endif; ?>
                            
                            <input type="file" name="foto" class="form-control" accept="image/*">
                            <div class="form-text">Deixe em branco para manter a foto atual.</div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-success fw-bold text-uppercase py-3">Salvar Alterações</button>
                            <a href="/veiculos" class="btn btn-outline-secondary text-uppercase btn-sm">Cancelar</a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>