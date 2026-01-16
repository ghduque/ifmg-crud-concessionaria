<?php
require_once __DIR__ . '/../Models/Veiculo.php';

class VeiculoController {
    
    // Lista todos os veículos (Com Filtros)
    public function index() {
        // Captura os dados enviados pelo formulário de filtro
        $filtros = [
            'busca'     => $_GET['busca'] ?? '',
            'preco_min' => $_GET['preco_min'] ?? '',
            'preco_max' => $_GET['preco_max'] ?? '',
            'ano_min'   => $_GET['ano_min'] ?? '',
            'ano_max'   => $_GET['ano_max'] ?? '',
            'km_min'    => $_GET['km_min'] ?? '',
            'km_max'    => $_GET['km_max'] ?? '',
            'ordem'     => $_GET['ordem'] ?? 'recente'
        ];

        $veiculoModel = new Veiculo();
        // Chamamos a função de listar com filtros
        $veiculos = $veiculoModel->listarComFiltros($filtros);
        
        require_once __DIR__ . '/../Views/veiculos/index.php';
    }

    // Exibe o formulário de cadastro (Apenas Admin)
    public function create() {
        $this->verificarAdmin();
        require_once __DIR__ . '/../Views/veiculos/create.php';
    }

    // --- ATUALIZADO: Recebe múltiplas fotos e salva no banco ---
    public function store() {
        $this->verificarAdmin();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $marca = $_POST['marca'];
            $modelo = $_POST['modelo'];
            $ano_fabricacao = $_POST['ano_fabricacao'];
            $ano_modelo = $_POST['ano_modelo'];
            $valor = $_POST['valor'];
            $km = $_POST['km'];
            $descricao = $_POST['descricao'];
            
            // Array para guardar os caminhos das várias fotos
            $caminhosFotos = [];

            // Verifica se o campo 'fotos' (do input multiple) foi enviado
            if (isset($_FILES['fotos']) && !empty($_FILES['fotos']['name'][0])) {
                
                // Conta quantos arquivos vieram
                $totalArquivos = count($_FILES['fotos']['name']);

                for ($i = 0; $i < $totalArquivos; $i++) {
                    // Verifica se não deu erro no upload deste arquivo específico
                    if ($_FILES['fotos']['error'][$i] === 0) {
                        
                        $extensao = pathinfo($_FILES['fotos']['name'][$i], PATHINFO_EXTENSION);
                        // Cria nome único: id_unico-indice.extensao
                        $novoNome = uniqid() . "-" . $i . "." . $extensao;
                        $destino = __DIR__ . '/../../public/uploads/' . $novoNome;
                        
                        // Move o arquivo para a pasta uploads
                        if (move_uploaded_file($_FILES['fotos']['tmp_name'][$i], $destino)) {
                            $caminhosFotos[] = 'uploads/' . $novoNome;
                        }
                    }
                }
            }

            $veiculoModel = new Veiculo();
            
            // Agora passamos o ARRAY $caminhosFotos em vez de uma string única
            // Certifique-se que seu Model Veiculo -> cadastrar() já está atualizado para receber array
            $veiculoModel->cadastrar($marca, $modelo, $ano_fabricacao, $ano_modelo, $valor, $km, $descricao, $caminhosFotos);

            header('Location: /veiculos'); 
            exit;
        }
    }

    // Carrega o formulário de edição
    public function edit() {
        $this->verificarAdmin();

        if (!isset($_GET['id'])) {
            header('Location: /veiculos');
            exit;
        }

        $veiculoModel = new Veiculo();
        $veiculo = $veiculoModel->buscarPorId($_GET['id']);

        if (!$veiculo) {
            header('Location: /veiculos');
            exit;
        }

        require_once __DIR__ . '/../Views/veiculos/edit.php';
    }

    // Atualiza os dados (Edição)
    public function update() {
        $this->verificarAdmin();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $marca = $_POST['marca'];
            $modelo = $_POST['modelo'];
            $ano_fabricacao = $_POST['ano_fabricacao'];
            $ano_modelo = $_POST['ano_modelo'];
            $valor = $_POST['valor'];
            $km = $_POST['km'];
            $descricao = $_POST['descricao'];
            
            // Lógica de Upload para Edição (Por enquanto, substitui a foto principal)
            // Se quiser adicionar mais fotos na edição, precisaremos de uma lógica mais complexa depois
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

    // Exibe os detalhes de UM veículo específico (Carrossel)
    public function show() {
        if (!isset($_GET['id'])) {
            header('Location: /veiculos');
            exit;
        }

        $veiculoModel = new Veiculo();
        
        // 1. Busca os dados do carro
        $veiculo = $veiculoModel->buscarPorId($_GET['id']);

        if (!$veiculo) {
            header('Location: /veiculos');
            exit;
        }

        // 2. Busca TODAS as fotos desse carro para o carrossel
        $fotos = $veiculoModel->buscarFotos($_GET['id']);
        
        // Fallback: Se não tiver fotos na tabela nova, usa a antiga
        if (empty($fotos) && !empty($veiculo['url_foto'])) {
            $fotos = [['url_foto' => $veiculo['url_foto']]];
        }

        require_once __DIR__ . '/../Views/veiculos/details.php';
    }
}
?>