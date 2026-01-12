<?php
require_once __DIR__ . '/../Models/Venda.php';
require_once __DIR__ . '/../Models/Veiculo.php';

class VendaController {

    // Registra uma venda
    public function registrar() {
        // Verifica se é admin (vendedor)
        session_start();
        if (!isset($_SESSION['papel']) || $_SESSION['papel'] !== 'admin') {
            header('Location: /');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $veiculo_id = $_POST['veiculo_id'];
            $cliente_id = $_POST['cliente_id'];
            $valor_final = $_POST['valor_final'];
            $vendedor_id = $_SESSION['usuario_id'];

            $vendaModel = new Venda();
            
            // Tenta registrar a venda
            if ($vendaModel->registrarVenda($cliente_id, $veiculo_id, $vendedor_id, $valor_final)) {
                
                // Atualiza o status do carro para 'vendido'
                $veiculoModel = new Veiculo();
                $veiculoModel->alterarStatus($veiculo_id, 'vendido');
                
                header('Location: /admin/dashboard?msg=venda_sucesso');
            } else {
                echo "Erro ao registrar venda.";
            }
        }
    }
}
?>