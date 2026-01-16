<?php include __DIR__ . '/../layouts/header.php'; ?>

<style>
    /* Fundo geral da página */
    body { background-color: #f5f7fa !important; color: #333 !important; }

    /* Estilo dos Inputs do Filtro (Fundo Escuro + Letra Branca) */
    .input-filtro {
        background-color: #212529 !important;
        border: 1px solid #495057 !important;
        color: #fff !important;
    }
    
    .input-filtro::placeholder { color: rgba(255, 255, 255, 0.7) !important; }
    
    .input-filtro:focus {
        background-color: #000 !important;
        border-color: #0d6efd !important; /* Azul conforme seu tema */
        color: #fff !important;
        box-shadow: none !important;
    }

    /* Card dos Carros */
    .card-veiculo {
        background-color: #fff !important;
        transition: transform 0.2s, box-shadow 0.2s;
        border-radius: 12px;
        overflow: hidden;
    }
    .card-veiculo:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
    }
    .object-fit-cover { object-fit: cover; }
</style>

<div class="container py-4">
    <div class="row mb-4">
        <div class="col-12 text-center text-md-start">
            <h2 class="fw-bold text-uppercase text-dark">Nossos <span class="text-primary">Veículos</span></h2>
            <p class="text-muted">Confira as melhores ofertas da região</p>
        </div>
    </div>

    <div class="row">
        <aside class="col-lg-3 mb-4">
            <div class="p-3 bg-white border rounded shadow-sm">
                <h5 class="text-dark mb-3 pb-2 border-bottom"><i class="fas fa-filter text-primary me-2"></i>Filtrar</h5>
                
                <form action="/veiculos" method="GET" id="formFiltros">
                    <input type="hidden" name="ordem" value="<?= $_GET['ordem'] ?? 'recente' ?>">
                    
                    <div class="mb-4">
                        <label class="text-muted small text-uppercase fw-bold mb-1">Buscar</label>
                        <div class="input-group">
                            <input type="text" name="busca" class="form-control form-control-sm input-filtro" placeholder="Digite o nome..." value="<?= htmlspecialchars($_GET['busca'] ?? '') ?>">
                            <button type="submit" class="btn btn-sm btn-primary text-dark fw-bold"><i class="fas fa-search"></i></button>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="text-muted small text-uppercase fw-bold mb-1">Preço (R$)</label>
                        <div class="d-flex gap-2">
                            <input type="number" name="preco_min" class="form-control form-control-sm input-filtro" placeholder="Mín" value="<?= $_GET['preco_min'] ?? '' ?>">
                            <input type="number" name="preco_max" class="form-control form-control-sm input-filtro" placeholder="Máx" value="<?= $_GET['preco_max'] ?? '' ?>">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="text-muted small text-uppercase fw-bold mb-1">Ano</label>
                        <div class="d-flex gap-2">
                            <input type="number" name="ano_min" class="form-control form-control-sm input-filtro" placeholder="De" value="<?= $_GET['ano_min'] ?? '' ?>">
                            <input type="number" name="ano_max" class="form-control form-control-sm input-filtro" placeholder="Até" value="<?= $_GET['ano_max'] ?? '' ?>">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="text-muted small text-uppercase fw-bold mb-1">Quilometragem</label>
                        <div class="d-flex gap-2">
                            <input type="number" name="km_min" class="form-control form-control-sm input-filtro" placeholder="Mín" value="<?= $_GET['km_min'] ?? '' ?>">
                            <input type="number" name="km_max" class="form-control form-control-sm input-filtro" placeholder="Máx" value="<?= $_GET['km_max'] ?? '' ?>">
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 fw-bold text-dark text-uppercase">Aplicar Filtros</button>
                    <a href="/veiculos" class="btn btn-link w-100 text-muted btn-sm mt-2 text-decoration-none">Limpar Filtros</a>
                </form>
            </div>
        </aside>

        <main class="col-lg-9">
            <div class="d-flex justify-content-between align-items-center mb-3 bg-white p-2 border rounded shadow-sm">
                <span class="text-muted small fw-bold ms-2">
                    <?= count($veiculos) ?> anúncios encontrados
                </span>
                
                <div class="d-flex align-items-center">
                    <label class="text-muted small me-2 d-none d-md-block">Ordenar por:</label>
                    <select class="form-select form-select-sm border-secondary text-dark" style="width: auto;" onchange="alterarOrdem(this.value)">
                        <option value="recente" <?= ($_GET['ordem'] ?? '') == 'recente' ? 'selected' : '' ?>>Mais Recentes</option>
                        <option value="menor_preco" <?= ($_GET['ordem'] ?? '') == 'menor_preco' ? 'selected' : '' ?>>Menor Preço</option>
                        <option value="maior_preco" <?= ($_GET['ordem'] ?? '') == 'maior_preco' ? 'selected' : '' ?>>Maior Preço</option>
                    </select>
                </div>
            </div>

            <div class="row">
                <?php if (empty($veiculos)): ?>
                    <div class="col-12 text-center py-5 bg-white border rounded">
                        <h4 class="text-muted"><i class="fas fa-car-crash fa-2x mb-3"></i><br>Nenhum veículo encontrado.</h4>
                        <p class="text-muted">Tente ajustar os filtros ao lado.</p>
                    </div>
                <?php else: ?>
                    <?php foreach ($veiculos as $carro): ?>
                        <div class="col-md-6 col-xl-4 mb-4">
                            <div class="card card-veiculo h-100 border-0 shadow-sm">
                                <div class="card-img-wrapper position-relative" style="height: 200px; overflow: hidden;">
                                    <?php if(($carro['status'] ?? '') == 'vendido'): ?>
                                        <div class="position-absolute top-0 end-0 bg-danger text-white px-2 py-1 fw-bold small m-2 rounded" style="z-index: 2;">VENDIDO</div>
                                    <?php endif; ?>

                                    <?php $foto = !empty($carro['url_foto']) ? '/' . $carro['url_foto'] : 'https://via.placeholder.com/500x300?text=Sem+Foto'; ?>
                                    <img src="<?= $foto ?>" class="w-100 h-100 object-fit-cover" alt="<?= htmlspecialchars($carro['modelo']) ?>">
                                </div>
                                
                                <div class="card-body d-flex flex-column">
                                    <div class="mb-2">
                                        <span class="badge bg-light text-dark border fw-normal"><?= $carro['ano_fabricacao'] ?>/<?= $carro['ano_modelo'] ?></span>
                                    </div>
                                    
                                    <h6 class="card-title text-uppercase fw-bold text-dark mb-auto"><?= htmlspecialchars($carro['marca'] . ' ' . $carro['modelo']) ?></h6>
                                    
                                    <div class="card-price my-3 text-dark fw-bold fs-5">
                                        R$ <?= number_format($carro['valor'], 2, ',', '.') ?>
                                    </div>
                                    
                                    <div class="card-info d-flex justify-content-between border-top pt-2 text-muted" style="font-size: 0.8rem;">
                                        <span><i class="fas fa-tachometer-alt me-1"></i> <?= number_format($carro['km'] ?? 0, 0, ',', '.') ?> km</span>
                                        <span><i class="fas fa-map-marker-alt me-1"></i> Arcos-MG</span>
                                    </div>

                                    <a href="/veiculos/detalhes?id=<?= $carro['id'] ?>" class="btn btn-outline-primary w-100 mt-3 btn-sm text-uppercase fw-bold">Ver Oferta</a>

                                    <?php if (isset($_SESSION['papel']) && $_SESSION['papel'] === 'admin'): ?>
                                        <div class="mt-2 d-flex gap-2">
                                            <a href="/veiculos/edit?id=<?= $carro['id'] ?>" class="btn btn-sm btn-warning flex-fill fw-bold text-dark"><i class="fas fa-edit"></i></a>
                                            <a href="/veiculos/delete?id=<?= $carro['id'] ?>" class="btn btn-sm btn-danger flex-fill" onclick="return confirm('Excluir este veículo?')"><i class="fas fa-trash"></i></a>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </main>
    </div>
</div>

<script>
// Função para mudar a ordem mantendo os filtros atuais na URL
function alterarOrdem(valor) {
    const urlParams = new URLSearchParams(window.location.search);
    urlParams.set('ordem', valor);
    window.location.search = urlParams.toString();
}
</script>

<?php include __DIR__ . '/../layouts/footer.php'; ?>