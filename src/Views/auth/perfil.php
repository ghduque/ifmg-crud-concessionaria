<?php include __DIR__ . '/../layouts/header.php'; ?>

<style>
    body { background-color: #ffffff !important; color: #212529 !important; }
    
    .perfil-container {
        max-width: 700px;
        margin: 20px auto; /* Reduzi a margem do topo de 50px para 20px */
        padding: 10px 20px;
    }

    .secao-titulo {
        font-size: 1.8rem;
        font-weight: 800;
        margin-bottom: 20px; /* Reduzi de 40px para 20px */
        color: #000;
        display: flex;
        align-items: center;
    }

    .secao-titulo i { color: #ffc107; margin-right: 15px; }

    /* Estilo ultra-compacto para tirar o buraco */
    .dado-linha {
        display: flex;
        align-items: center;
        margin-bottom: 10px; /* Espaço mínimo entre campos */
        padding: 5px 0;
    }

    .dado-label {
        width: 140px; /* Encurtei a label para o input começar antes */
        font-weight: 600;
        color: #666;
        font-size: 0.95rem;
    }

    .dado-input {
        flex: 1;
        border: none;
        border-bottom: 1px solid #eee;
        padding: 5px 0;
        font-size: 1rem;
        background: transparent;
    }

    .dado-input:focus {
        outline: none;
        border-bottom: 2px solid #ffc107;
    }

    /* Linha divisória fina e sem margens exageradas */
    .divisor-limpo {
        border: 0;
        border-top: 1px solid #f8f8f8;
        margin: 10px 0; /* Quase nenhum espaço no divisor */
    }

    .btn-editar {
        background-color: #000;
        color: #fff;
        padding: 10px 60px;
        border-radius: 50px;
        font-weight: 700;
        border: none;
        margin-top: 20px;
        transition: 0.3s;
    }

    .btn-editar:hover { background-color: #ffc107; color: #000; }
</style>

<div class="container">
    <div class="perfil-container">
        
        <form action="/perfil/atualizar" method="POST">
            <div class="secao-titulo">
                <i class="fas fa-user-circle"></i> Dados pessoais
            </div>

            <div class="dado-linha">
                <div class="dado-label">Nome</div>
                <input type="text" name="nome" class="dado-input" value="<?= htmlspecialchars($_SESSION['nome'] ?? '') ?>" required>
            </div>

            <div class="dado-linha">
                <div class="dado-label">E-mail</div>
                <input type="email" name="email" class="dado-input" value="<?= htmlspecialchars($_SESSION['email'] ?? '') ?>" required>
            </div>

            <div class="dado-linha">
                <div class="dado-label">Telefone</div>
                <input type="text" name="telefone" class="dado-input" maxlength="15" value="<?= htmlspecialchars($_SESSION['telefone'] ?? '') ?>" placeholder="Telefone">
            </div>

            <hr class="divisor-limpo"> <div class="dado-linha">
                <div class="dado-label">Senha Atual</div>
                <input type="password" name="senha_atual" class="dado-input" placeholder="Sua senha atual" required>
            </div>
            
            <div class="dado-linha">
                <div class="dado-label">Nova Senha</div>
                <input type="password" name="nova_senha" class="dado-input" placeholder="Nova senha (opcional)">
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-editar">Editar</button>
            </div>
        </form>

         <div class="text-center mt-5">
                <a href="/logout" class="text-danger fw-bold text-decoration-none small">
                <i class="fas fa-sign-out-alt"></i> SAIR DA MINHA CONTA
                </a>
        </div>

    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>