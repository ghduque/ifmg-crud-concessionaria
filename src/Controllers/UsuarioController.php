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
            
            $email = trim($_POST['email']); 
            $senha = trim($_POST['senha']);

            $usuarioModel = new Usuario();
            $usuario = $usuarioModel->buscarPorEmail($email);

            if ($usuario && password_verify($senha, $usuario['senha_hash'])) {
                if (session_status() === PHP_SESSION_NONE) session_start();
                
                $_SESSION['usuario_id'] = $usuario['id'];
                $_SESSION['nome']       = $usuario['nome'];
                $_SESSION['email']      = $usuario['email'];
                $_SESSION['papel']      = $usuario['papel']; 
                $_SESSION['cpf']        = $usuario['cpf'] ?? ''; 
                $_SESSION['telefone']   = $usuario['telefone'] ?? '';

                header('Location: /veiculos');
                exit;
            } else {
                $erro = "E-mail ou senha inválidos!";
                require_once __DIR__ . '/../Views/auth/login.php';
            }
        }
    }

    // Atualiza o perfil (Completo, sem partes faltando)
    public function atualizar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (session_status() === PHP_SESSION_NONE) session_start();
            
            $usuario_id = $_SESSION['usuario_id'];
            
            // Limpa os dados
            $nome = trim($_POST['nome']);
            $email = trim($_POST['email']);
            $telefone = $_POST['telefone'];
            $senha_atual = trim($_POST['senha_atual']);
            $nova_senha = trim($_POST['nova_senha']);

            $usuarioModel = new Usuario();
            $usuario = $usuarioModel->buscarPorId($usuario_id);

            // Verifica a senha atual
            if (!password_verify($senha_atual, $usuario['senha_hash'])) {
                $erro = "Senha atual incorreta!";
                require_once __DIR__ . '/../Views/auth/perfil.php';
                return;
            }

            // Define se vai trocar a senha ou manter a antiga
            $senha_final = !empty($nova_senha) ? password_hash($nova_senha, PASSWORD_DEFAULT) : $usuario['senha_hash'];

            // Salva no banco
            if ($usuarioModel->atualizarPerfil($usuario_id, $nome, $email, $telefone, $senha_final)) {
                // Atualiza a sessão
                $_SESSION['nome'] = $nome;
                $_SESSION['email'] = $email;
                $_SESSION['telefone'] = $telefone;

                // Mensagem de sucesso (Flash Message)
                $_SESSION['flash_sucesso'] = "Suas informações de perfil foram atualizadas com sucesso.";

                header('Location: /veiculos'); 
                exit;
            }
        }
    }

    // Faz logout
    public function logout() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        session_destroy();
        header('Location: /login');
        exit;
    }

    // Exibe perfil
    public function perfil() {
        if (session_status() === PHP_SESSION_NONE) session_start();

        if (!isset($_SESSION['usuario_id'])) {
            header('Location: /login');
            exit;
        }
        
        include __DIR__ . '/../Views/auth/perfil.php';
    }

    // Exibe formulário de cadastro
    public function cadastro() {
        require_once __DIR__ . '/../Views/auth/register.php';
    }

    // Salva novo usuário (Cadastro)
    public function salvar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            $nome = trim($_POST['nome']);
            $email = trim($_POST['email']);
            $senha = trim($_POST['senha']);
            $confirmar = trim($_POST['confirmar_senha']);
            
            // Remove caracteres não numéricos de CPF e Telefone
            $cpf = preg_replace('/[^0-9]/', '', $_POST['cpf']);
            $telefone = preg_replace('/[^0-9]/', '', $_POST['telefone']);

            // Validações
            if ($senha !== $confirmar) {
                $erro = "As senhas não coincidem!";
                require_once __DIR__ . '/../Views/auth/register.php';
                return;
            }

            if (!$this->validarCPF($cpf)) {
                $erro = "CPF inválido! Verifique os números digitados.";
                require_once __DIR__ . '/../Views/auth/register.php';
                return;
            }

            if (strlen($telefone) < 10 || strlen($telefone) > 11) {
                $erro = "Telefone inválido! Digite DDD + Número.";
                require_once __DIR__ . '/../Views/auth/register.php';
                return;
            }

            $usuarioModel = new Usuario();
            
            if ($usuarioModel->buscarPorEmail($email)) {
                $erro = "Este e-mail já está cadastrado!";
                require_once __DIR__ . '/../Views/auth/register.php';
                return;
            }

            // Tenta salvar no banco
            if ($usuarioModel->criar($nome, $email, $cpf, $telefone, $senha)) {
                header('Location: /login?msg=criado'); 
                exit;
            } else {
                $erro = "Erro ao cadastrar. Tente novamente.";
                require_once __DIR__ . '/../Views/auth/register.php';
            }
        }
    }

    // Função auxiliar para validar CPF
    private function validarCPF($cpf) {
        $cpf = preg_replace( '/[^0-9]/is', '', $cpf );
        if (strlen($cpf) != 11) return false;
        if (preg_match('/(\d)\1{10}/', $cpf)) return false;

        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cpf[$c] * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($cpf[$c] != $d) return false;
        }
        return true;
    }
}
?>