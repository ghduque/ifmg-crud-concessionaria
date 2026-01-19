<?php include __DIR__ . '/../layouts/cabecalho.php'; ?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="fw-bold text-uppercase">Gerenciar Categorias</h2>
                <a href="/veiculos" class="btn btn-outline-dark btn-sm">Voltar</a>
            </div>

            <div class="card p-4 mb-4 shadow-sm border-0">
                <form action="/categorias/store" method="POST" class="d-flex gap-2">
                    <input type="text" name="nome" class="form-control" placeholder="Nova Categoria (Ex: Esportivo)" required>
                    <button type="submit" class="btn btn-primary fw-bold px-4">ADICIONAR</button>
                </form>
            </div>

            <div class="card shadow-sm border-0">
                <div class="card-body p-0">
                    <table class="table table-hover mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th class="ps-4">ID</th>
                                <th>Nome</th>
                                <th class="text-end pe-4">Ação</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($categorias as $cat): ?>
                                <tr>
                                    <td class="ps-4">#<?= $cat['id'] ?></td>
                                    <td class="fw-bold"><?= htmlspecialchars($cat['nome']) ?></td>
                                    <td class="text-end pe-4">
                                        <a href="/categorias/delete?id=<?= $cat['id'] ?>" 
                                           class="btn btn-sm btn-danger"
                                           onclick="return confirm('Excluir esta categoria?')">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>

<?php include __DIR__ . '/../layouts/rodape.php'; ?>