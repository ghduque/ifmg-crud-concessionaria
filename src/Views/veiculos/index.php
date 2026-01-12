<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="row">
    <div class="col-12 text-center mb-4">
        <h1>Nossos Veículos</h1>
        <p class="text-muted">Confira as melhores ofertas da região</p>
    </div>

    <?php if (empty($veiculos)): ?>
        <div class="alert alert-info">Nenhum veículo cadastrado no momento.</div>
    <?php else: ?>
        
        <?php foreach ($veiculos as $carro): ?>
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm">
                    <?php 
                        $foto = $carro['url_foto'] ? '/' . $carro['url_foto'] : 'https://via.placeholder.com/300x200?text=Sem+Foto';
                    ?>
                    <img src="<?= $foto ?>" class="card-img-top" alt="Foto do veículo" style="height: 200px; object-fit: cover;">
                    
                    <div class="card-body">
                        <h5 class="card-title"><?= $carro['marca'] ?> <?= $carro['modelo'] ?></h5>
                        <h6 class="card-subtitle mb-2 text-muted"><?= $carro['ano_modelo'] ?>/<?= $carro['ano_fabricacao'] ?></h6>
                        <p class="card-text text-truncate"><?= $carro['descricao'] ?></p>
                        
                        <h4 class="text-primary">R$ <?= number_format($carro['valor'], 2, ',', '.') ?></h4>
                        
                        <?php if($carro['status'] == 'vendido'): ?>
                            <span class="badge bg-danger">VENDIDO</span>
                        <?php else: ?>
                            <span class="badge bg-success">DISPONÍVEL</span>
                        <?php endif; ?>
                    </div>

                    <?php if (isset($_SESSION['papel']) && $_SESSION['papel'] === 'admin'): ?>
                    <div class="card-footer bg-white border-top-0">
                        <a href="/veiculos/delete?id=<?= $carro['id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Tem certeza?')">Excluir</a>
                        <?php if($carro['status'] == 'disponivel'): ?>
                            <button class="btn btn-sm btn-success float-end">Vender</button>
                        <?php endif; ?>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>

    <?php endif; ?>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>