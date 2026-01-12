<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AutoNível Concessionária</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
  <div class="container">
    <a class="navbar-brand" href="/">🚗 AutoNível</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link" href="/">Veículos</a></li>
        
        <?php 
        if (session_status() === PHP_SESSION_NONE) session_start();
        
        // Se estiver logado
        if (isset($_SESSION['usuario_id'])): ?>
            
            <?php if ($_SESSION['papel'] === 'admin'): ?>
                <li class="nav-item">
                    <a class="nav-link btn btn-outline-success ms-2" href="/veiculos/criar">Vender/Cadastrar</a>
                </li>
            <?php endif; ?>

            <li class="nav-item dropdown ms-3">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                    Olá, <?= $_SESSION['nome'] ?>
                </a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="/logout">Sair</a></li>
                </ul>
            </li>

        <?php else: // Se NÃO estiver logado ?>
            <li class="nav-item">
                <a class="nav-link" href="/login">Login</a>
            </li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>

<div class="container"> ```

---

### 2. `src/Views/layouts/footer.php`
Fecha as tags abertas.

```php
</div> <footer class="bg-light text-center text-lg-start mt-5">
  <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.05);">
    © 2026 AutoNível Concessionária - Projeto IFMG
  </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>