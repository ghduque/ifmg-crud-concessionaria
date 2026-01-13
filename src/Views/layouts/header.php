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

<nav class="navbar navbar-expand-lg navbar-dark sticky-top" style="background-color: #000; border-bottom: 1px solid #333;">
  <div class="container">
    
    <a class="navbar-brand" href="/veiculos">
        <img src="/img/logo-autonivel.png" alt="AutoNível" style="max-height: 50px; width: auto;">
    </a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto align-items-center">
        <li class="nav-item">
            <a class="nav-link text-uppercase" href="/veiculos">
                <i class="fas fa-car me-1"></i> Estoque
            </a>
        </li>
        
        <?php 
        // Verifica se a sessão já existe antes de iniciar
        if (session_status() === PHP_SESSION_NONE) session_start();
        
        // SE ESTIVER LOGADO
        if (isset($_SESSION['usuario_id'])): ?>
            
            <?php if ($_SESSION['papel'] === 'admin'): ?>
                <li class="nav-item">
                    <a class="btn btn-sm btn-primary ms-lg-3 px-3 fw-bold text-black" href="/veiculos/criar">
                        <i class="fas fa-plus-circle"></i> Anunciar
                    </a>
                </li>
            <?php endif; ?>

            <li class="nav-item dropdown ms-lg-3">
                <a class="nav-link dropdown-toggle text-white" href="#" role="button" data-bs-toggle="dropdown">
                    <i class="fas fa-user-circle fa-lg me-1"></i> 
                    <?= explode(' ', $_SESSION['nome'])[0] ?> </a>
                <ul class="dropdown-menu dropdown-menu-dark shadow">
                    <li><a class="dropdown-item" href="/logout"><i class="fas fa-sign-out-alt me-2"></i> Sair</a></li>
                </ul>
            </li>

        <?php else: // SE NÃO ESTIVER LOGADO ?>
            <li class="nav-item ms-lg-3">
                <a class="nav-link btn btn-outline-light btn-sm px-4 text-white" href="/login">
                    <i class="fas fa-user me-1"></i> Login
                </a>
            </li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>

<div class="container py-4">