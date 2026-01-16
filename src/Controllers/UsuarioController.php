<?php
require_once __DIR__ . '/../Models/Usuario.php';

class UsuarioController {

    // Exibe formulário de login
    public function login() {
        require_once __DIR__ . '/../Views/auth/login.php';
    }

    // Processa o login
   // Processa o login
    public function autenticar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $senha = $_POST['senha'];

            $usuarioModel = new Usuario();
            $usuario = $usuarioModel->buscarPorEmail($email);

            // Verifica se usuário existe e se a senha bate com o hash
            if ($usuario && password_verify($senha, $usuario['senha_hash'])) {
                if (session_status() === PHP_SESSION_NONE) session_start();
                
                // --- AQUI ESTÁ A CHAVE: SALVAR TODOS OS DADOS NA SESSÃO ---
                $_SESSION['usuario_id'] = $usuario['id'];
                $_SESSION['nome']       = $usuario['nome'];
                $_SESSION['email']      = $usuario['email']; // Essencial para o perfil
                $_SESSION['papel']      = $usuario['papel']; 
                $_SESSION['cpf']        = $usuario['cpf'] ?? ''; // Salva se existir no banco
                $_SESSION['telefone']   = $usuario['telefone'] ?? ''; // Salva se existir no banco

                // Redireciona para o estoque
                header('Location: /veiculos');
                exit;
            } else {
                $erro = "E-mail ou senha inválidos!";
                require_once __DIR__ . '/../Views/auth/login.php';
            }
        }
    }

    public function atualizar() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (session_status() === PHP_SESSION_NONE) session_start();
        
        $usuario_id = $_SESSION['usuario_id'];
        $nome = $_POST['nome'];
        $email = $_POST['email'];
        $telefone = $_POST['telefone'];
        $senha_atual = $_POST['senha_atual'];
        $nova_senha = $_POST['nova_senha'];

        $usuarioModel = new Usuario();
        $usuario = $usuarioModel->buscarPorId($usuario_id);

        // 1. Verificar se a senha atual está correta
        if (!password_verify($senha_atual, $usuario['senha_hash'])) {
            $erro = "Senha atual incorreta!";
            require_once __DIR__ . '/../Views/auth/perfil.php';
            return;
        }

        // 2. Se houver nova senha, gerar o hash. Se não, manter a atual.
        $senha_final = !empty($nova_senha) ? password_hash($nova_senha, PASSWORD_DEFAULT) : $usuario['senha_hash'];

        // 3. Salvar no banco
        if ($usuarioModel->atualizarPerfil($usuario_id, $nome, $email, $telefone, $senha_final)) {
            // Atualizar os dados da sessão para refletir no header imediatamente
            $_SESSION['nome'] = $nome;
            $_SESSION['email'] = $email;
            $_SESSION['telefone'] = $telefone;

            header('Location: /perfil?sucesso=1');
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
    // Verifica se está logado antes de mostrar a página
    if (!isset($_SESSION['usuario_id'])) {
        header('Location: /login');
        exit;
    }
    
    // Aqui você pode buscar dados extras no banco se necessário
    include __DIR__ . '/../Views/auth/perfil.php';
}

    // Exibe o formulário de cadastro
    public function cadastro() {
        require_once __DIR__ . '/../Views/auth/register.php';
    }

    // --- AQUI ESTÁ A MUDANÇA PRINCIPAL ---
    public function salvar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nome = $_POST['nome'];
            $email = $_POST['email'];
            $senha = $_POST['senha'];
            $confirmar = $_POST['confirmar_senha'];
            
            // 1. Captura e LIMPA a formatação (tira pontos e traços)
            $cpf = preg_replace('/[^0-9]/', '', $_POST['cpf']);
            $telefone = preg_replace('/[^0-9]/', '', $_POST['telefone']);

            // 2. Validação de senha
            if ($senha !== $confirmar) {
                $erro = "As senhas não coincidem!";
                require_once __DIR__ . '/../Views/auth/register.php';
                return;
            }

            // 3. Validação de CPF (Matemática)
            if (!$this->validarCPF($cpf)) {
                $erro = "CPF inválido! Verifique os números digitados.";
                require_once __DIR__ . '/../Views/auth/register.php';
                return;
            }

            // 4. Validação de Telefone (10 ou 11 dígitos)
            if (strlen($telefone) < 10 || strlen($telefone) > 11) {
                $erro = "Telefone inválido! Digite DDD + Número.";
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

            // 5. Salva no banco passando os NOVOS campos ($cpf, $telefone)
            // Certifique-se que seu Usuario.php (Model) também foi atualizado!
            if ($usuarioModel->criar($nome, $email, $cpf, $telefone, $senha)) {
                // Sucesso: Redireciona para login
                header('Location: /login?msg=criado'); 
                exit;
            } else {
                $erro = "Erro ao cadastrar. Tente novamente.";
                require_once __DIR__ . '/../Views/auth/register.php';
            }
        }
    }

    // --- FUNÇÃO PRIVADA PARA VALIDAR MATEMATICAMENTE O CPF ---
    private function validarCPF($cpf) {
        // Extrai somente os números
        $cpf = preg_replace( '/[^0-9]/is', '', $cpf );
         
        if (strlen($cpf) != 11) {
            return false;
        }

        // Verifica sequências repetidas (ex: 111.111.111-11)
        if (preg_match('/(\d)\1{10}/', $cpf)) {
            return false;
        }

        // Cálculo dos dígitos verificadores
        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cpf[$c] * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($cpf[$c] != $d) {
                return false;
            }
        }
        return true;
    }
}
?>