<?php
require_once __DIR__ . '/../Models/Categoria.php';

class CategoriaController {
    private $categoriaModel;

    public function __construct($pdo) {
        $this->categoriaModel = new Categoria($pdo);
    }

    public function index() {
        // Proteção: Só admin acessa
        if (!isset($_SESSION['papel']) || $_SESSION['papel'] !== 'admin') {
            header('Location: /login');
            exit;
        }

        $categorias = $this->categoriaModel->listar();
        require __DIR__ . '/../Views/categorias/index.php';
    }

    public function store() {
        if (!isset($_SESSION['papel']) || $_SESSION['papel'] !== 'admin') {
            header('Location: /login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['nome'])) {
            $this->categoriaModel->criar($_POST['nome']);
        }
        
        header('Location: /categorias');
        exit;
    }

    public function delete() {
        if (!isset($_SESSION['papel']) || $_SESSION['papel'] !== 'admin') {
            header('Location: /login');
            exit;
        }

        if (isset($_GET['id'])) {
            $this->categoriaModel->excluir($_GET['id']);
        }

        header('Location: /categorias');
        exit;
    }
}