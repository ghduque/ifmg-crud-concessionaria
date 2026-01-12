<?php
require_once __DIR__ . '/../Models/Veiculo.php';

class VeiculoController {
    
    // Lista todos os veículos (Página Inicial/Vitrine)
    public function index() {
        $veiculoModel = new Veiculo();
        $veiculos = $veiculoModel->listarTodos();
        
        // Carrega a view de listagem
        require_once __DIR__ . '/../Views/veiculos/index.php';
    }

    // Exibe o formulário de cadastro (Apenas Admin)
    public function create() {
        $this->verificarAdmin();
        require_once __DIR__ . '/../Views/veiculos/create.php';
    }

    // Recebe os dados do formulário e salva no banco
    public function store() {
        $this->verificarAdmin();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $marca = $_POST['marca'];
            $modelo = $_POST['modelo'];
            $ano_fabricacao = $_POST['ano_fabricacao'];
            $ano_modelo = $_POST['ano_modelo'];
            $valor = $_POST['valor'];
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
            $veiculoModel->cadastrar($marca, $modelo, $ano_fabricacao, $ano_modelo, $valor, $descricao, $caminhoFoto);

            header('Location: /veiculos'); // Redireciona após salvar
        }
    }

    // Deleta um veículo
    public function delete($id) {
        $this->verificarAdmin();
        $veiculoModel = new Veiculo();
        $veiculoModel->deletar($id);
        header('Location: /veiculos');
    }

    // Método auxiliar para proteger rotas administrativas
    private function verificarAdmin() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['usuario_id']) || $_SESSION['papel'] !== 'admin') {
            header('Location: /login'); // Manda para login se não for admin
            exit;
        }
    }
}
?>