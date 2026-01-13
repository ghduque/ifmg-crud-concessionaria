<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - AutoNível</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;600&display=swap" rel="stylesheet">
</head>
<body class="login-page">

    <div class="overlay"></div>

    <div class="container h-100 position-relative" style="z-index: 2;">
        <div class="row h-100 align-items-center justify-content-start">
            
            <div class="col-md-6 col-lg-4 text-white p-5 login-card">
                <h4 class="text-uppercase ls-2 mb-3 text-secondary">Bem-vindo</h4>
                <h1 class="display-4 fw-bold mb-4">AUTO<span class="text-primary">NÍVEL</span></h1>
                <p class="mb-5 lead">A excelência em veículos que você procura. Faça login para gerenciar o estoque.</p>
                
                <?php if (isset($erro)): ?>
                    <div class="alert alert-danger py-2"><?= $erro ?></div>
                <?php endif; ?>

                <form action="/login/auth" method="POST">
                    <div class="mb-4">
                        <label class="form-label text-uppercase small text-secondary">E-mail</label>
                        <input type="email" name="email" class="form-control form-control-dark" placeholder="seu@email.com" required>
                    </div>
                    
                    <div class="mb-4">
                        <label class="form-label text-uppercase small text-secondary">Senha</label>
                        <input type="password" name="senha" class="form-control form-control-dark" placeholder="******" required>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 py-3 text-uppercase fw-bold mt-3">Entrar no Sistema</button>
                    
                    <div class="mt-4 text-center">
                        <p class="mb-2 text-white-50 small">Ainda não tem acesso?</p>
                        <a href="/cadastro" class="btn btn-outline-light w-100 text-uppercase fw-bold" style="font-size: 0.8rem;">Criar Conta Agora</a>
                    </div>

                    <div class="mt-3 text-center">
                        <a href="/" class="text-white-50 text-decoration-none small" style="opacity: 0.5;">← Voltar ao site</a>
                    </div>
                </form>
            </div>

        </div>
    </div>

</body>
</html>