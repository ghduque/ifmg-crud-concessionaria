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

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label>Ano Fab.</label>
                            <input type="number" name="ano_fabricacao" class="form-control" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Ano Mod.</label>
                            <input type="number" name="ano_modelo" class="form-control" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Valor (R$)</label>
                            <input type="number" step="0.01" name="valor" class="form-control" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label>Descrição</label>
                        <textarea name="descricao" class="form-control" rows="3"></textarea>
                    </div>

                    <div class="mb-3">
                        <label>Foto Principal</label>
                        <input type="file" name="foto" class="form-control" accept="image/*">
                    </div>

                    <button type="submit" class="btn btn-success w-100">Salvar Veículo</button>
                </form>

            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>