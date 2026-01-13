<?php
require_once __DIR__ . '/../Models/Usuario.php';

class UsuarioController {

    // Exibe formulário de login
    public function login() {
        require_once __DIR__ . '/../Views/auth/login.php';
    }

    // Processa o login
    public function autenticar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $senha = $_POST['senha'];

            $usuarioModel = new Usuario();
            $usuario = $usuarioModel->buscarPorEmail($email);

            // Verifica se usuário existe e se a senha bate com o hash
            if ($usuario && password_verify($senha, $usuario['senha_hash'])) {
                session_start();
                $_SESSION['usuario_id'] = $usuario['id'];
                $_SESSION['nome'] = $usuario['nome'];
                $_SESSION['papel'] = $usuario['papel'];

               // MUDANÇA AQUI: Redireciona para /veiculos ao invés de /
               header('Location: /veiculos');
            } else {
                $erro = "E-mail ou senha inválidos!";
                require_once __DIR__ . '/../Views/auth/login.php';
            }
        }
    }

// Faz logout
public function logout() {
    session_start();
    session_destroy();
    header('Location: /login');
}

// Exibe o formulário de cadastro
public function cadastro() {
        require_once __DIR__ . '/../Views/auth/register.php';
    }

    // Processa o cadastro
    public function salvar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nome = $_POST['nome'];
            $email = $_POST['email'];
            $senha = $_POST['senha'];
            $confirmar = $_POST['confirmar_senha'];

            // Validação simples de senha
            if ($senha !== $confirmar) {
                $erro = "As senhas não coincidem!";
                require_once __DIR__ . '/../Views/auth/register.php';
                return;
            }

            $usuarioModel = new Usuario();
            
            // Verifica se email já existe
            if ($usuarioModel->buscarPorEmail($email)) {
                $erro = "Este e-mail já está cadastrado!";
                require_once __DIR__ . '/../Views/auth/register.php';
                return;
            }

            // Tenta criar (padrão papel 'comum')
            if ($usuarioModel->criar($nome, $email, $senha)) {
                // Redireciona para o login com mensagem de sucesso (opcional)
                header('Location: /?msg=criado'); 
            } else {
                $erro = "Erro ao cadastrar. Tente novamente.";
                require_once __DIR__ . '/../Views/auth/register.php';
            }
        }
    }
}
?>