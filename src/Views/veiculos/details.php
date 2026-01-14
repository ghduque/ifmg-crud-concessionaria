<?php include __DIR__ . '/../layouts/header.php'; ?>

<style>
    /* --- CONFIGURAÇÃO DE CORES (Mantendo o pedido anterior) --- */
    body { background-color: #ffffff !important; color: #212529 !important; }
    
    /* Navbar: Links Brancos */
    .navbar a, .navbar .nav-link, .nav-item a { color: #ffffff !important; }

    /* Cards e Textos */
    .card { background-color: #ffffff !important; color: #212529 !important; border: 1px solid #dee2e6 !important; }
    h1, h2, h3, h4, h5, h6, p, .text-muted { color: #212529 !important; }
    .text-secondary-custom { color: #6c757d !important; }

    /* AJUSTE DO CARROSSEL */
    .carousel-item img {
        height: 500px; /* Altura fixa para não pular */
        object-fit: cover; /* Corta a imagem para preencher sem esticar */
        width: 100%;
        border-radius: 5px;
    }
    
    /* Cor das setinhas (Pretas para aparecer no fundo claro se a foto for clara) */
    .carousel-control-prev-icon,
    .carousel-control-next-icon {
        background-color: rgba(0,0,0,0.5); /* Fundo escuro na seta */
        border-radius: 50%;
        padding: 20px;
        background-size: 50% 50%;
    }
</style>

<div class="container py-5">
    
    <div class="mb-4">
        <a href="/veiculos" class="btn btn-outline-dark btn-sm fw-bold">
            <i class="fas fa-arrow-left me-2"></i>VOLTAR PARA O ESTOQUE
        </a>
    </div>

    <div class="row">
        
        <div class="col-lg-8">
            
            <div class="card mb-4 border-0 p-0">
                
                <?php if (count($fotos) > 0): ?>
                    <div id="carouselVeiculo" class="carousel slide" data-bs-ride="carousel">
                        
                        <div class="carousel-inner">
                            <?php foreach ($fotos as $index => $f): ?>
                                <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                                    <img src="/<?= $f['url_foto'] ?>" class="d-block w-100" alt="Foto do Veículo">
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselVeiculo" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Anterior</span>
                        </button>
                        
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselVeiculo" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Próximo</span>
                        </button>

                    </div>
                <?php else: ?>
                    <img src="https://images.unsplash.com/photo-1533473359331-0135ef1b58bf?auto=format&fit=crop&w=800&q=80" class="img-fluid rounded" alt="Sem foto">
                <?php endif; ?>

            </div>
            <div class="d-block d-lg-none mb-3">
                <h2 class="fw-bold text-uppercase"><?= $veiculo['marca'] ?> <?= $veiculo['modelo'] ?></h2>
                <h3 class="fw-bold text-primary" style="color: #0d6efd !important;">R$ <?= number_format($veiculo['valor'], 2, ',', '.') ?></h3>
            </div>

            <div class="card p-4">
                <h4 class="fw-bold mb-3 border-bottom pb-2">Sobre este veículo</h4>
                
                <div class="row mb-4 text-center">
                    <div class="col-4 border-end">
                        <small class="text-uppercase fw-bold text-secondary-custom">Ano</small>
                        <p class="fw-bold fs-5 mb-0"><?= $veiculo['ano_fabricacao'] ?>/<?= $veiculo['ano_modelo'] ?></p>
                    </div>
                    <div class="col-4 border-end">
                        <small class="text-uppercase fw-bold text-secondary-custom">KM</small>
                        <p class="fw-bold fs-5 mb-0"><?= number_format($veiculo['km'], 0, ',', '.') ?></p>
                    </div>
                    <div class="col-4">
                        <small class="text-uppercase fw-bold text-secondary-custom">Câmbio</small>
                        <p class="fw-bold fs-5 mb-0">Automático</p>
                    </div>
                </div>

                <h5 class="fw-bold mb-2">Descrição do Vendedor</h5>
                <p class="text-secondary-custom" style="white-space: pre-line; line-height: 1.6;">
                    <?= nl2br(htmlspecialchars($veiculo['descricao'])) ?>
                </p>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card p-4 sticky-top" style="top: 20px;">
                <div class="mb-3">
                    <span class="badge bg-dark text-white mb-2"><?= $veiculo['ano_fabricacao'] ?>/<?= $veiculo['ano_modelo'] ?></span>
                    <h3 class="fw-bold text-uppercase mb-1"><?= $veiculo['modelo'] ?></h3>
                    <p class="text-muted text-secondary-custom"><?= $veiculo['marca'] ?></p>
                </div>
                <div class="mb-4">
                    <small class="text-decoration-line-through text-secondary-custom">De R$ <?= number_format($veiculo['valor'] * 1.05, 2, ',', '.') ?></small>
                    <h2 class="fw-bold text-primary" style="color: #0d6efd !important;">R$ <?= number_format($veiculo['valor'], 2, ',', '.') ?></h2>
                </div>
                <div class="d-grid gap-2">
                    <a href="https://wa.me/5537999999999?text=Interesse no <?= $veiculo['modelo'] ?>" target="_blank" class="btn btn-success fw-bold py-3 text-white" style="color: #fff !important;">
                        <i class="fab fa-whatsapp me-2"></i> NEGOCIAR NO WHATSAPP
                    </a>
                    <button class="btn btn-outline-dark fw-bold py-2">
                        <i class="fas fa-phone-alt me-2"></i> Ver Telefone
                    </button>
                </div>
                <div class="mt-4 pt-3 border-top">
                    <p class="small text-center mb-0 text-secondary-custom">
                        <i class="fas fa-shield-alt me-1 text-success"></i> Compra 100% Segura
                    </p>
                </div>
                <?php if (isset($_SESSION['papel']) && $_SESSION['papel'] === 'admin'): ?>
                    <div class="mt-3 pt-3 border-top text-center">
                        <a href="/veiculos/edit?id=<?= $veiculo['id'] ?>" class="fw-bold text-decoration-none small text-warning" style="color: #ffc107 !important;">
                            <i class="fas fa-edit"></i> Editar este anúncio
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>