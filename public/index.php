<?php
// Inicia sessão em todas as páginas (verifica se já não está iniciada)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 1. Carrega o arquivo da classe Database
require_once __DIR__ . '/../config/database.php';

// 2. CRIA A CONEXÃO (A CORREÇÃO ESTÁ AQUI)
// Instancia a classe que você criou e pega a conexão
$database = new Database();
$pdo = $database->getConnection();

// Importa os Controllers
require_once __DIR__ . '/../src/Controllers/VeiculoController.php';
require_once __DIR__ . '/../src/Controllers/UsuarioController.php';

// Roteamento Simples
$url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

switch ($url) {
    case '/':
        $controller = new UsuarioController();
        $controller->login();
        break;

    case '/veiculos':
        $controller = new VeiculoController();
        $controller->index();
        break;

    case '/veiculos/criar':
        $controller = new VeiculoController();
        $controller->create();
        break;

    case '/veiculos/store':
        $controller = new VeiculoController();
        $controller->store();
        break;
    
    case '/veiculos/delete':
        $id = $_GET['id'] ?? null;
        if ($id) {
            $controller = new VeiculoController();
            $controller->delete($id);
        }
        break;

    case '/login':
        $controller = new UsuarioController();
        $controller->login();
        break;

    case '/login/auth':
        $controller = new UsuarioController();
        $controller->autenticar();
        break;

    case '/logout':
        $controller = new UsuarioController();
        $controller->logout();
        break;
    
    case '/cadastro':
        $controller = new UsuarioController();
        $controller->cadastro();
        break;

    case '/cadastro/salvar':
        $controller = new UsuarioController();
        $controller->salvar();
        break;

    // --- NOVA ROTA PARA O PERFIL ---
    case '/perfil':
        $controller = new UsuarioController();
        $controller->perfil();
        break;

    case '/perfil/atualizar':
        $controller = new UsuarioController();
        $controller->atualizar();
        break;

    case '/veiculos/edit':
        $controller = new VeiculoController();
        $controller->edit();
        break;

    case '/veiculos/update':
        $controller = new VeiculoController();
        $controller->update();
        break;

    case '/veiculos/detalhes':
        $controller = new VeiculoController();
        $controller->show();
        break;

    // --- ROTAS DE CATEGORIAS (CRUD EXTRA) ---
    case '/categorias':
        require_once __DIR__ . '/../src/Controllers/CategoriaController.php';
        // Agora o $pdo existe porque criamos ele lá em cima!
        $controller = new CategoriaController($pdo);
        $controller->index();
        break;

    case '/categorias/store':
        require_once __DIR__ . '/../src/Controllers/CategoriaController.php';
        $controller = new CategoriaController($pdo);
        $controller->store();
        break;

    case '/categorias/delete':
        require_once __DIR__ . '/../src/Controllers/CategoriaController.php';
        $controller = new CategoriaController($pdo);
        $controller->delete();
        break;

    default:
        http_response_code(404);
        echo "<h1>404 - Página não encontrada</h1>";
        break;
        
    }
?>