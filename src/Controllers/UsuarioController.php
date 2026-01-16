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
            
            // --- CORREÇÃO DEFINITIVA: Limpa espaços do e-mail E da senha ---
            $email = trim($_POST['email']); 
            $senha = trim($_POST['senha']); // Agora "123 " vira "123"

            $usuarioModel = new Usuario();
            // Usa a variável $email limpa, e não o $_POST direto
            $usuario = $usuarioModel->buscarPorEmail($email);

            // Verifica se usuário existe e se a senha bate com o hash
            if ($usuario && password_verify($senha, $usuario['senha_hash'])) {
                if (session_status() === PHP_SESSION_NONE) session_start();
                
                // Salva dados na sessão
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

    public function atualizar() {
        // Verifica se é POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (session_status() === PHP_SESSION_NONE) session_start();
            
            // Verifica login
            if (!isset($_SESSION['usuario_id'])) {
                header('Location: /login'); exit;
            }
            
            $usuario_id = $_SESSION['usuario_id'];
            
            // 1. Limpeza dos dados
            $nome = trim($_POST['nome']);
            $email = trim($_POST['email']);
            $telefone = $_POST['telefone']; 
            
            $senha_atual = trim($_POST['senha_atual']);
            $nova_senha = trim($_POST['nova_senha']);

            $usuarioModel = new Usuario();
            $usuario = $usuarioModel->buscarPorId($usuario_id);

            // 2. Verificar senha atual
            if (!password_verify($senha_atual, $usuario['senha_hash'])) {
                // Se errar a senha, volta para o perfil com erro
                $erro = "Senha atual incorreta!";
                require_once __DIR__ . '/../Views/auth/perfil.php';
                return;
            }

            // 3. Define qual senha salvar
            $senha_final = !empty($nova_senha) ? password_hash($nova_senha, PASSWORD_DEFAULT) : $usuario['senha_hash'];

            // 4. Salva no banco
            if ($usuarioModel->atualizarPerfil($usuario_id, $nome, $email, $telefone, $senha_final)) {
                // Atualiza a sessão para o nome mudar no topo da página imediatamente
                $_SESSION['nome'] = $nome;
                $_SESSION['email'] = $email;
                $_SESSION['telefone'] = $telefone;

                // --- MUDANÇA AQUI: Redireciona para o ESTOQUE com mensagem de sucesso ---
                header('Location: /veiculos?msg=perfil_atualizado');
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

    public function perfil() {
        if (session_status() === PHP_SESSION_NONE) session_start();

        if (!isset($_SESSION['usuario_id'])) {
            header('Location: /login');
            exit;
        }
        
        include __DIR__ . '/../Views/auth/perfil.php';
    }

    public function cadastro() {
        require_once __DIR__ . '/../Views/auth/register.php';
    }

    // --- CADASTRO NOVO ---
    public function salvar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            // --- LIMPEZA TOTAL NOS DADOS DE ENTRADA ---
            $nome = trim($_POST['nome']);
            $email = trim($_POST['email']);
            $senha = trim($_POST['senha']);
            $confirmar = trim($_POST['confirmar_senha']);
            
            // Limpa CPF e Telefone (apenas números)
            $cpf = preg_replace('/[^0-9]/', '', $_POST['cpf']);
            $telefone = preg_replace('/[^0-9]/', '', $_POST['telefone']);

            // 2. Validação de senha
            if ($senha !== $confirmar) {
                $erro = "As senhas não coincidem!";
                require_once __DIR__ . '/../Views/auth/register.php';
                return;
            }

            // 3. Validação de CPF
            if (!$this->validarCPF($cpf)) {
                $erro = "CPF inválido! Verifique os números digitados.";
                require_once __DIR__ . '/../Views/auth/register.php';
                return;
            }

            // 4. Validação de Telefone
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

            // 5. Salva no banco (Agora a senha salva já está sem espaços extras)
            if ($usuarioModel->criar($nome, $email, $cpf, $telefone, $senha)) {
                header('Location: /login?msg=criado'); 
                exit;
            } else {
                $erro = "Erro ao cadastrar. Tente novamente.";
                require_once __DIR__ . '/../Views/auth/register.php';
            }
        }
    }

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