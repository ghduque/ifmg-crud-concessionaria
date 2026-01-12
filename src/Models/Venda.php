<?php
require_once __DIR__ . '/../../config/database.php';

class Venda {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function registrarVenda($clienteId, $veiculoId, $vendedorId, $valorFinal) {
        $query = "INSERT INTO vendas (cliente_id, veiculo_id, vendedor_id, valor_final) 
                  VALUES (:cliente, :veiculo, :vendedor, :valor)";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':cliente', $clienteId);
        $stmt->bindParam(':veiculo', $veiculoId);
        $stmt->bindParam(':vendedor', $vendedorId);
        $stmt->bindParam(':valor', $valorFinal);
        
        return $stmt->execute();
    }
}
?>