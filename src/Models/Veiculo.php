<?php
require_once __DIR__ . '/../../config/database.php';

class Veiculo {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    // Lista todos os veículos trazendo a foto de capa
    public function listarTodos() {
        // O "v.*" já vai trazer a coluna 'km' automaticamente, pois adicionamos ela no banco
        $query = "SELECT DISTINCT ON (v.id) v.*, f.url_foto 
                  FROM veiculos v 
                  LEFT JOIN veiculos_fotos f ON v.id = f.veiculo_id 
                  ORDER BY v.id DESC";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // --- AQUI ESTÁ A ALTERAÇÃO ---
    // Adicionei $km na lista de itens que a função recebe
    public function cadastrar($marca, $modelo, $ano_fab, $ano_mod, $valor, $km, $descricao, $caminhoFoto) {
        try {
            $this->conn->beginTransaction();

            // 1. Insere o Veículo (Adicionei 'km' aqui)
            $query = "INSERT INTO veiculos (marca, modelo, ano_fabricacao, ano_modelo, valor, km, descricao) 
                      VALUES (:marca, :modelo, :ano_fab, :ano_mod, :valor, :km, :descricao) RETURNING id";
            
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':marca', $marca);
            $stmt->bindParam(':modelo', $modelo);
            $stmt->bindParam(':ano_fab', $ano_fab);
            $stmt->bindParam(':ano_mod', $ano_mod);
            $stmt->bindParam(':valor', $valor);
            $stmt->bindParam(':km', $km); // <--- NOVO: Liga o valor do KM
            $stmt->bindParam(':descricao', $descricao);
            $stmt->execute();
            
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

            $this->conn->commit();
            return true;

        } catch (Exception $e) {
            $this->conn->rollBack();
            return false;
        }
    }

    public function alterarStatus($id, $novoStatus) {
        $query = "UPDATE veiculos SET status = :status WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':status', $novoStatus);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function deletar($id) {
        $query = "DELETE FROM veiculos WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
    // Busca um único veículo pelo ID (para preencher o formulário de edição)
    public function buscarPorId($id) {
        $query = "SELECT v.*, f.url_foto 
                  FROM veiculos v 
                  LEFT JOIN veiculos_fotos f ON v.id = f.veiculo_id 
                  WHERE v.id = :id 
                  LIMIT 1";
                  
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    // Busca todas as fotos de um veículo específico
    public function buscarFotos($veiculoId) {
        $query = "SELECT url_foto FROM veiculos_fotos WHERE veiculo_id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $veiculoId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Atualiza os dados do veículo
    public function atualizar($id, $marca, $modelo, $ano_fab, $ano_mod, $valor, $km, $descricao, $novaFoto = null) {
        try {
            $this->conn->beginTransaction();

            // 1. Atualiza os dados principais
            $query = "UPDATE veiculos 
                      SET marca = :marca, modelo = :modelo, ano_fabricacao = :ano_fab, 
                          ano_modelo = :ano_mod, valor = :valor, km = :km, descricao = :descricao 
                      WHERE id = :id";
            
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':marca', $marca);
            $stmt->bindParam(':modelo', $modelo);
            $stmt->bindParam(':ano_fab', $ano_fab);
            $stmt->bindParam(':ano_mod', $ano_mod);
            $stmt->bindParam(':valor', $valor);
            $stmt->bindParam(':km', $km);
            $stmt->bindParam(':descricao', $descricao);
            $stmt->bindParam(':id', $id);
            $stmt->execute();

            // 2. Se enviou uma nova foto, atualiza a tabela de fotos
            if ($novaFoto) {
                // Primeiro tenta atualizar se já existir
                $queryFoto = "UPDATE veiculos_fotos SET url_foto = :url WHERE veiculo_id = :id";
                $stmtFoto = $this->conn->prepare($queryFoto);
                $stmtFoto->bindParam(':url', $novaFoto);
                $stmtFoto->bindParam(':id', $id);
                $stmtFoto->execute();

                // Se não atualizou nenhuma linha (não tinha foto antes), insere uma nova
                if ($stmtFoto->rowCount() == 0) {
                    $queryInsert = "INSERT INTO veiculos_fotos (veiculo_id, url_foto, destaque) VALUES (:id, :url, true)";
                    $stmtInsert = $this->conn->prepare($queryInsert);
                    $stmtInsert->bindParam(':id', $id);
                    $stmtInsert->bindParam(':url', $novaFoto);
                    $stmtInsert->execute();
                }
            }

            $this->conn->commit();
            return true;

        } catch (Exception $e) {
            $this->conn->rollBack();
            return false;
        }
    }
}
?>