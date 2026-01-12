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
                $_SESSION['papel'] = $usuario['papel']; // 'admin' ou 'comum'

                header('Location: /'); // Login sucesso
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
}
?>