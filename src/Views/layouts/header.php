<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AutoNível Multimarcas</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;600;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/style.css">
</head>
<body style="background-color: #121212; color: #fff;">

<header class="container-fluid p-0 m-0 bg-black border-bottom border-dark position-relative d-flex justify-content-center align-items-center" style="min-height: 120px;">
    
    <a href="/veiculos" style="text-decoration: none; width: 100%; display: flex; justify-content: center;">
        <img src="/img/logo-autonivel.png" 
             alt="AutoNível Banner" 
             style="width: 50%; height: auto; display: block; min-height: 80px; max-width: 600px;">
    </a>

    <div class="position-absolute top-0 end-0 h-100 d-none d-lg-flex align-items-center pe-5" style="z-index: 10;">
        <ul class="nav gap-4">
            
            <li class="nav-item">
                <a class="nav-link text-uppercase fw-bold text-white small" href="/veiculos">
                    <i class="fas fa-car me-2 text-warning"></i>Estoque
                </a>
            </li>

            <?php 
            if (session_status() === PHP_SESSION_NONE) session_start();
            
            if (isset($_SESSION['usuario_id'])): ?>
                
                <?php if ($_SESSION['papel'] === 'admin'): ?>
                    <li class="nav-item">
                        <a class="btn btn-sm btn-outline-warning fw-bold rounded-0" href="/veiculos/criar">
                            ANUNCIAR
                        </a>
                    </li>
                <?php endif; ?>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-white-50 small text-uppercase fw-bold" href="#" role="button" data-bs-toggle="dropdown">
                        <i class="fas fa-user-circle me-1"></i> 
                        <?= explode(' ', $_SESSION['nome'])[0] ?> 
                    </a>
                    <ul class="dropdown-menu dropdown-menu-dark shadow rounded-0 dropdown-menu-end">
                        <li><a class="dropdown-item" href="/logout"><i class="fas fa-sign-out-alt me-2"></i> Sair</a></li>
                    </ul>
                </li>

            <?php else: ?>
                <li class="nav-item">
                    <a class="nav-link btn btn-outline-light btn-sm px-3 border-0 small text-uppercase fw-bold" href="/login">
                        <i class="fas fa-user me-2"></i> Login
                    </a>
                </li>
            <?php endif; ?>

        </ul>
    </div>

    <nav class="navbar navbar-dark d-lg-none position-absolute top-0 end-0 h-100 pe-3">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mobileMenu">
            <span class="navbar-toggler-icon"></span>
        </button>
    </nav>

</header>

<div class="collapse navbar-collapse bg-dark border-bottom border-secondary d-lg-none" id="mobileMenu">
    <div class="container py-3">
        <ul class="navbar-nav text-center gap-3">
            <li class="nav-item"><a class="nav-link text-white" href="/veiculos">ESTOQUE</a></li>
            <?php if (isset($_SESSION['usuario_id'])): ?>
                <li class="nav-item"><a class="nav-link text-warning" href="/logout">SAIR (<?= $_SESSION['nome'] ?>)</a></li>
            <?php else: ?>
                <li class="nav-item"><a class="nav-link text-white" href="/login">Login</a></li>
            <?php endif; ?>
        </ul>
    </div>
</div>

<div class="container py-5"></div>