<?php include __DIR__ . '/../layouts/cabecalho.php'; ?>

<div class="container py-5">
    
    <div class="mb-4">
        <a href="/veiculos" class="btn btn-link text-dark text-decoration-none fw-bold p-0">
            <i class="fas fa-chevron-left me-2"></i>VOLTAR PARA O ESTOQUE
        </a>
    </div>

    <div class="row">
        
        <div class="col-lg-8">
            <div class="card card-detalhe mb-4 p-0 overflow-hidden">
                <?php if (count($fotos) > 0): ?>
                    <div id="carouselVeiculo" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            <?php foreach ($fotos as $index => $f): ?>
                                <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                                    <img src="/<?= $f['url_foto'] ?>" class="d-block w-100 carousel-detalhe-img" alt="Foto do Veículo">
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselVeiculo" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon carousel-control-icon-bg" aria-hidden="true"></span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselVeiculo" data-bs-slide="next">
                            <span class="carousel-control-next-icon carousel-control-icon-bg" aria-hidden="true"></span>
                        </button>
                    </div>
                <?php else: ?>
                    <img src="https://via.placeholder.com/800x550?text=Sem+Foto" class="img-fluid carousel-detalhe-img" alt="Sem foto">
                <?php endif; ?>
            </div>

            <div class="card card-detalhe p-4">
                <h4 class="fw-bold mb-4 border-bottom pb-3">Sobre este veículo</h4>
                
                <div class="row g-3">
                    <?php 
                    $opcionais = explode("\n", $veiculo['descricao']);
                    foreach ($opcionais as $item): 
                        $item = trim($item);
                        if (empty($item)) continue;
                        
                        // Lógica simples para escolher ícones baseados no texto
                        $icon = "fa-check";
                        if (stripos($item, 'Teto') !== false) $icon = "fa-sun";
                        if (stripos($item, 'Ar') !== false) $icon = "fa-snowflake";
                        if (stripos($item, 'Direção') !== false) $icon = "fa-steering-wheel";
                        if (stripos($item, 'Chave') !== false) $icon = "fa-key";
                        if (stripos($item, 'Câmbio') !== false || stripos($item, 'Paddle') !== false) $icon = "fa-cog";
                        if (stripos($item, 'Air') !== false || stripos($item, 'ABS') !== false) $icon = "fa-shield-alt";
                    ?>
                        <div class="col-md-6 col-lg-4">
                            <div class="opcional-item">
                                <div class="opcional-icon">
                                    <i class="fas <?= $icon ?>"></i>
                                </div>
                                <span class="opcional-text"><?= htmlspecialchars($item) ?></span>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="mt-5">
                    <h5 class="fw-bold mb-3">Destaques AutoNível</h5>
                    <p class="text-secondary-custom" style="line-height: 1.8;">
                        Veículo selecionado e periciado. Na <strong>AutoNível Multimarcas</strong>, oferecemos transparência total e garantia de procedência em todo o nosso estoque. Agende seu test-drive e conheça de perto a qualidade deste <?= $veiculo['modelo'] ?>.
                    </p>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card card-detalhe p-4 sticky-details">
                <div class="mb-3">
                    <span class="badge-ano"><?= $veiculo['ano_fabricacao'] ?> / <?= $veiculo['ano_modelo'] ?></span>
                    <h2 class="fw-bold text-uppercase mt-2 mb-1"><?= $veiculo['modelo'] ?></h2>
                    <p class="text-muted fs-5"><?= $veiculo['marca'] ?></p>
                </div>

                <div class="row mb-4">
                    <div class="col-6">
                        <small class="text-uppercase text-muted d-block">Quilometragem</small>
                        <span class="fw-bold"><?= number_format($veiculo['km'], 0, ',', '.') ?> km</span>
                    </div>
                    <div class="col-6">
                        <small class="text-uppercase text-muted d-block">Transmissão</small>
                        <span class="fw-bold">Automático</span>
                    </div>
                </div>

                <div class="mb-4">
                    <small class="text-uppercase text-muted d-block mb-1">Preço de Venda</small>
                    <h1 class="preco-destaque">
                        R$ <?= number_format($veiculo['valor'], 2, ',', '.') ?>
                    </h1>
                </div>

                <div class="d-grid gap-3">
                    <a href="https://wa.me/5537999592879?text=Olá! Vi o <?= urlencode($veiculo['modelo']) ?> no site e gostaria de negociar." 
                       target="_blank" 
                       class="btn btn-whatsapp-socio btn-lg fw-bold py-3 shadow-sm rounded-pill-custom">
                        <i class="fab fa-whatsapp me-2"></i> (37) 99959-2879
                    </a>

                    <a href="https://wa.me/5537991923096?text=Olá! Vi o <?= urlencode($veiculo['modelo']) ?> no site e gostaria de negociar." 
                       target="_blank" 
                       class="btn btn-whatsapp-socio btn-lg fw-bold py-3 shadow-sm rounded-pill-custom">
                        <i class="fab fa-whatsapp me-2"></i> (37) 99192-3096    
                    </a>
                </div>

                <div class="mt-4 pt-3 border-top text-center">
                    <div class="d-flex align-items-center justify-content-center text-success small fw-bold">
                        <i class="fas fa-shield-alt me-2"></i> COMPRA 100% SEGURA E PERICIADA
                    </div>
                </div>

                <?php if (isset($_SESSION['papel']) && $_SESSION['papel'] === 'admin'): ?>
                    <div class="mt-3 text-center border-top pt-3">
                        <a href="/veiculos/edit?id=<?= $veiculo['id'] ?>" class="btn btn-sm btn-light text-warning fw-bold rounded-pill-custom px-4 border">
                            <i class="fas fa-edit me-1"></i> Editar Anúncio
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layouts/rodape.php'; ?>