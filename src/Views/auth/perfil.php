<?php include __DIR__ . '/../layouts/cabecalho.php'; ?>

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
                <input type="text" 
                       name="telefone" 
                       class="dado-input" 
                       maxlength="15" 
                       value="<?= htmlspecialchars($_SESSION['telefone'] ?? '') ?>" 
                       placeholder="(00) 00000-0000"
                       oninput="mascaraTelefone(this)">
            </div>

            <hr class="divisor-limpo"> 

            <div class="dado-linha">
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

<?php include __DIR__ . '/../layouts/rodape.php'; ?>