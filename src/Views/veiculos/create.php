<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-primary text-white">Cadastrar Novo Veículo</div>
            <div class="card-body">
                
                <form action="/veiculos/store" method="POST" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Marca</label>
                            <input type="text" name="marca" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Modelo</label>
                            <input type="text" name="modelo" class="form-control" required>
                        </div>
                    </div>

                   <div class="row mb-3">
                        <div class="col-md-3">
                            <label class="form-label">Ano Fab.</label>
                            <input type="number" name="ano_fabricacao" class="form-control" required placeholder="Ex: 2020">
                        </div>
                        
                        <div class="col-md-3">
                            <label class="form-label">Ano Mod.</label>
                            <input type="number" name="ano_modelo" class="form-control" required placeholder="Ex: 2021">
                        </div>
                        
                        <div class="col-md-3">
                            <label class="form-label">Quilometragem (Km)</label>
                            <input type="number" name="km" class="form-control" required placeholder="Ex: 50000">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Valor (R$)</label>
                            <input type="number" step="0.01" name="valor" class="form-control" required placeholder="0,00">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold small text-uppercase">Fotos do Veículo</label>

                        <div class="input-group">
                            <input type="file" name="fotos[]" class="form-control" id="inputFotos" multiple accept="image/*">
                            <label class="input-group-text" for="inputFotos">Selecionar</label>
                        </div>
                        <div class="form-text">Segure a tecla <b>Ctrl</b> para selecionar várias fotos de uma vez.</div>
                    </div>

                    <button type="submit" class="btn btn-success w-100">Salvar Veículo</button>
                </form>

            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>