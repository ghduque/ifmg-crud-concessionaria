<?php
require_once __DIR__ . '/../Models/Veiculo.php';

class VeiculoController {
    
    // Lista todos os veículos (Página Inicial/Vitrine)
    public function index() {
        $veiculoModel = new Veiculo();
        $veiculos = $veiculoModel->listarTodos();
        
        require_once __DIR__ . '/../Views/veiculos/index.php';
    }

    // Exibe o formulário de cadastro (Apenas Admin)
    public function create() {
        $this->verificarAdmin();
        require_once __DIR__ . '/../Views/veiculos/create.php';
    }

    // Recebe os dados do formulário e salva no banco (CRIAR)
    public function store() {
        $this->verificarAdmin();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $marca = $_POST['marca'];
            $modelo = $_POST['modelo'];
            $ano_fabricacao = $_POST['ano_fabricacao'];
            $ano_modelo = $_POST['ano_modelo'];
            $valor = $_POST['valor'];
            $km = $_POST['km']; // Quilometragem
            $descricao = $_POST['descricao'];
            
            // Lógica de Upload de Foto
            $caminhoFoto = null;
            if (isset($_FILES['foto']) && $_FILES['foto']['error'] === 0) {
                $extensao = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
                $novoNome = uniqid() . "." . $extensao;
                $destino = __DIR__ . '/../../public/uploads/' . $novoNome;
                
                if (move_uploaded_file($_FILES['foto']['tmp_name'], $destino)) {
                    $caminhoFoto = 'uploads/' . $novoNome;
                }
            }

            $veiculoModel = new Veiculo();
            
            // Cadastra no banco
            $veiculoModel->cadastrar($marca, $modelo, $ano_fabricacao, $ano_modelo, $valor, $km, $descricao, $caminhoFoto);

            header('Location: /veiculos'); 
            exit;
        }
    }

    // --- MÉTODOS NOVOS PARA EDIÇÃO ---

    // 1. Carrega o formulário de edição com os dados preenchidos
    public function edit() {
        $this->verificarAdmin();

        // Verifica se passou o ID na URL (ex: /veiculos/edit?id=5)
        if (!isset($_GET['id'])) {
            header('Location: /veiculos');
            exit;
        }

        $veiculoModel = new Veiculo();
        $veiculo = $veiculoModel->buscarPorId($_GET['id']);

        // Se o carro não existir, volta pra lista
        if (!$veiculo) {
            header('Location: /veiculos');
            exit;
        }

        // Carrega a view de edição
        require_once __DIR__ . '/../Views/veiculos/edit.php';
    }

    // 2. Recebe os dados editados e atualiza no banco
    public function update() {
        $this->verificarAdmin();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id']; // ID é fundamental para saber quem atualizar
            $marca = $_POST['marca'];
            $modelo = $_POST['modelo'];
            $ano_fabricacao = $_POST['ano_fabricacao'];
            $ano_modelo = $_POST['ano_modelo'];
            $valor = $_POST['valor'];
            $km = $_POST['km'];
            $descricao = $_POST['descricao'];
            
            // Lógica de Upload (Só troca a foto se o usuário enviou uma nova)
            $caminhoFoto = null;
            if (isset($_FILES['foto']) && $_FILES['foto']['error'] === 0) {
                $extensao = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
                $novoNome = uniqid() . "." . $extensao;
                $destino = __DIR__ . '/../../public/uploads/' . $novoNome;
                
                if (move_uploaded_file($_FILES['foto']['tmp_name'], $destino)) {
                    $caminhoFoto = 'uploads/' . $novoNome;
                }
            }

            $veiculoModel = new Veiculo();
            
            // Chama a função atualizar do Model
            $veiculoModel->atualizar($id, $marca, $modelo, $ano_fabricacao, $ano_modelo, $valor, $km, $descricao, $caminhoFoto);

            header('Location: /veiculos');
            exit;
        }
    }

    // Deleta um veículo
    public function delete($id) {
        $this->verificarAdmin();
        $veiculoModel = new Veiculo();
        $veiculoModel->deletar($id);
        header('Location: /veiculos');
        exit;
    }

    // Método auxiliar para proteger rotas
    private function verificarAdmin() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['usuario_id']) || $_SESSION['papel'] !== 'admin') {
            header('Location: /login');
            exit;
        }
    }
    // Exibe os detalhes de UM veículo específico
    public function show() {
        if (!isset($_GET['id'])) {
            header('Location: /veiculos');
            exit;
        }

        $veiculoModel = new Veiculo();
        
        // 1. Busca os dados do carro (Texto, Preço, etc)
        $veiculo = $veiculoModel->buscarPorId($_GET['id']);

        if (!$veiculo) {
            header('Location: /veiculos');
            exit;
        }

        // 2. Busca TODAS as fotos desse carro para o carrossel
        $fotos = $veiculoModel->buscarFotos($_GET['id']);
        
        // Se não tiver fotos extras, cria um array com a foto principal para não quebrar o carrossel
        if (empty($fotos) && !empty($veiculo['url_foto'])) {
            $fotos = [['url_foto' => $veiculo['url_foto']]];
        }

        require_once __DIR__ . '/../Views/veiculos/details.php';
    }
}
?>