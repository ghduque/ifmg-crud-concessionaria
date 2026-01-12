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
        $controller = new VeiculoController();
        $controller->index();
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

    default:
        http_response_code(404);
        echo "<h1>404 - Página não encontrada</h1>";
        break;
}
?>