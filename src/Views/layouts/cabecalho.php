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
<body style="background-color: #ffffff; color: #212529;"> <header class="container-fluid p-0 m-0 bg-black border-bottom border-secondary position-relative d-flex justify-content-center align-items-center" style="min-height: 150px;">
    
    <a href="/veiculos" style="text-decoration: none; width: 100%; display: flex; justify-content: center;">
        <img src="/img/logo-autonivel.png" 
             alt="AutoNível Banner" 
             style="width: 50%; height: auto; display: block; min-height: 80px; max-width: 600px;">
    </a>

    <div class="position-absolute top-0 end-0 h-100 d-none d-lg-flex align-items-center pe-5" style="z-index: 10;">
        <div class="d-flex flex-column align-items-end gap-2"> <div class="d-flex align-items-center gap-3 mb-1">
                <a class="nav-link text-uppercase fw-bold text-white small hover-warning" href="/veiculos">
                    <i class="fas fa-car me-1 text-warning"></i> Estoque
                </a>

                <?php 
                if (session_status() === PHP_SESSION_NONE) session_start();
                if (isset($_SESSION['usuario_id'])): ?>
                    <div class="dropdown">
                        <a class="nav-link dropdown-toggle text-white fw-bold small text-uppercase d-flex align-items-center" 
                           href="#" role="button" data-bs-toggle="dropdown">
                           <div class="bg-warning text-dark rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 28px; height: 28px;">
                               <i class="fas fa-user" style="font-size: 0.8rem;"></i>
                           </div>
                           <?= explode(' ', $_SESSION['nome'])[0] ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-end shadow-lg">
                            <li><a class="dropdown-item py-2" href="/perfil"><i class="fas fa-id-card-alt me-2 text-warning"></i> Meu Perfil</a></li>
                            <?php if ($_SESSION['papel'] === 'admin'): ?>
                                <li><a class="dropdown-item py-2" href="/veiculos/criar"><i class="fas fa-plus-circle me-2 text-warning"></i> Anunciar Veículo</a></li>
                            <?php endif; ?>
                            <li><hr class="dropdown-divider border-secondary"></li>
                            <li><a class="dropdown-item py-2 text-danger fw-bold" href="/logout"><i class="fas fa-sign-out-alt me-2"></i> Sair</a></li>
                        </ul>
                    </div>
                <?php else: ?>
                    <a class="btn btn-outline-light btn-sm px-3 rounded-pill fw-bold" href="/login">LOGIN</a>
                <?php endif; ?>
            </div>

            <?php if (isset($_SESSION['usuario_id']) && $_SESSION['papel'] === 'admin'): ?>
                <a class="btn btn-warning fw-bold rounded-pill px-4 shadow-sm" href="/veiculos/criar" style="font-size: 0.75rem; letter-spacing: 1px;">
                    <i class="fas fa-plus-circle me-1"></i> ANUNCIAR VEÍCULO
                </a>
            <?php endif; ?>

        </div>
    </div>

    <nav class="navbar navbar-dark d-lg-none position-absolute top-0 end-0 h-100 pe-3">
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#mobileMenu">
            <span class="navbar-toggler-icon"></span>
        </button>
    </nav>
</header>

<div class="collapse navbar-collapse bg-black border-bottom border-secondary d-lg-none" id="mobileMenu">
    <div class="container py-3 text-center">
        <ul class="navbar-nav gap-2">
            <li class="nav-item"><a class="nav-link text-white fw-bold" href="/veiculos">ESTOQUE</a></li>
            <?php if (isset($_SESSION['usuario_id'])): ?>
                <?php if ($_SESSION['papel'] === 'admin'): ?>
                    <li class="nav-item"><a class="nav-link text-warning fw-bold" href="/veiculos/criar">ANUNCIAR</a></li>
                <?php endif; ?>
                <li class="nav-item"><a class="nav-link text-white fw-bold" href="/perfil">MEU PERFIL</a></li>
                <li class="nav-item"><a class="nav-link text-danger fw-bold" href="/logout">SAIR</a></li>
            <?php else: ?>
                <li class="nav-item"><a class="nav-link text-white fw-bold" href="/login">LOGIN</a></li>
            <?php endif; ?>
        </ul>
    </div>
</div>

<style>
    /* Correção para o conteúdo não subir */
    header {
        position: relative !important;
        z-index: 1000;
        box-shadow: 0 4px 10px rgba(0,0,0,0.3);
    }

    .dropdown-item:hover {
        background-color: #212529;
        color: #ffc107 !important;
        padding-left: 20px;
    }
    
    .hover-warning:hover {
        color: #ffc107 !important;
        transition: 0.3s;
    }
</style>