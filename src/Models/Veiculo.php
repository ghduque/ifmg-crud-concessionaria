<?php
require_once __DIR__ . '/../../config/database.php';

class Veiculo {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    // Lista todos os veículos trazendo a foto de capa (se houver)
    public function listarTodos() {
        // DISTINCT ON (v.id) é um recurso top do PostgreSQL para evitar duplicatas
        $query = "SELECT DISTINCT ON (v.id) v.*, f.url_foto 
                  FROM veiculos v 
                  LEFT JOIN veiculos_fotos f ON v.id = f.veiculo_id 
                  ORDER BY v.id DESC";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Cadastra veículo e foto numa transação única
    public function cadastrar($marca, $modelo, $ano_fab, $ano_mod, $valor, $descricao, $caminhoFoto) {
        try {
            $this->conn->beginTransaction(); // Inicia transação

            // 1. Insere o Veículo
            $query = "INSERT INTO veiculos (marca, modelo, ano_fabricacao, ano_modelo, valor, descricao) 
                      VALUES (:marca, :modelo, :ano_fab, :ano_mod, :valor, :descricao) RETURNING id";
            
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':marca', $marca);
            $stmt->bindParam(':modelo', $modelo);
            $stmt->bindParam(':ano_fab', $ano_fab);
            $stmt->bindParam(':ano_mod', $ano_mod);
            $stmt->bindParam(':valor', $valor);
            $stmt->bindParam(':descricao', $descricao);
            $stmt->execute();
            
            // Pega o ID do carro criado
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
            $veiculoId = $resultado['id'];

            // 2. Se tiver foto, insere na tabela auxiliar
            if ($caminhoFoto) {
                $queryFoto = "INSERT INTO veiculos_fotos (veiculo_id, url_foto, destaque) VALUES (:id, :url, true)";
                $stmtFoto = $this->conn->prepare($queryFoto);
                $stmtFoto->bindParam(':id', $veiculoId);
                $stmtFoto->bindParam(':url', $caminhoFoto);
                $stmtFoto->execute();
            }

            $this->conn->commit(); // Salva tudo
            return true;

        } catch (Exception $e) {
            $this->conn->rollBack(); // Se der erro, cancela tudo
            return false;
        }
    }

    // Atualiza o status (Disponível -> Vendido)
    public function alterarStatus($id, $novoStatus) {
        $query = "UPDATE veiculos SET status = :status WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':status', $novoStatus);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    // Deleta o veículo (O banco já apaga as fotos por causa do CASCADE)
    public function deletar($id) {
        $query = "DELETE FROM veiculos WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
?>