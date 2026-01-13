<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro - AutoNível</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;600;800&display=swap" rel="stylesheet">
</head>
<body class="login-page">

    <div class="overlay"></div>

    <div class="container h-100 position-relative" style="z-index: 2;">
        <div class="row h-100 align-items-center justify-content-start">
            
            <div class="col-md-7 col-lg-5 text-white p-5 login-card">
                <h4 class="text-uppercase ls-2 mb-3 text-secondary">Junte-se a nós</h4>
                <h1 class="display-5 fw-bold mb-4">CRIAR <span class="text-primary">CONTA</span></h1>
                
                <?php if (isset($erro)): ?>
                    <div class="alert alert-danger py-2 border-0 opacity-75"><?= $erro ?></div>
                <?php endif; ?>

                <form action="/cadastro/salvar" method="POST">
                    <div class="mb-3">
                        <label class="form-label text-uppercase small text-secondary">Nome Completo</label>
                        <input type="text" name="nome" class="form-control form-control-dark" placeholder="Seu nome" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-uppercase small text-secondary">E-mail</label>
                        <input type="email" name="email" class="form-control form-control-dark" placeholder="seu@email.com" required>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label class="form-label text-uppercase small text-secondary">Senha</label>
                            <input type="password" name="senha" class="form-control form-control-dark" placeholder="******" required>
                        </div>
                        <div class="col-md-6 mb-4">
                            <label class="form-label text-uppercase small text-secondary">Confirmar</label>
                            <input type="password" name="confirmar_senha" class="form-control form-control-dark" placeholder="******" required>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 py-3 text-uppercase fw-bold mt-2">Cadastrar</button>
                    
                    <div class="mt-4 text-center">
                        <span class="text-white-50 small">Já tem uma conta?</span>
                        <a href="/" class="text-primary text-decoration-none fw-bold small ms-1">Fazer Login</a>
                    </div>
                </form>
            </div>

        </div>
    </div>

</body>
</html>