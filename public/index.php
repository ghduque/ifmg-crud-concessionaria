<?php
// Inicia sessão em todas as páginas
session_start();

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

    default:
        http_response_code(404);
        echo "<h1>404 - Página não encontrada</h1>";
        break;
}
?>