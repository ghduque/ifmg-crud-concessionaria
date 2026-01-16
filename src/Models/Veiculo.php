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
        // Traz apenas a foto definida como destaque ou a primeira encontrada
        $query = "SELECT DISTINCT ON (v.id) v.*, f.url_foto 
                  FROM veiculos v 
                  LEFT JOIN veiculos_fotos f ON v.id = f.veiculo_id 
                  ORDER BY v.id DESC, f.destaque DESC";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // --- MÉTODO ATUALIZADO PARA MÚLTIPLAS FOTOS ---
    // Recebe um array $fotos em vez de uma string única
    public function cadastrar($marca, $modelo, $ano_fab, $ano_mod, $valor, $km, $descricao, $fotos = []) {
        try {
            $this->conn->beginTransaction();

            // 1. Insere o Veículo
            $query = "INSERT INTO veiculos (marca, modelo, ano_fabricacao, ano_modelo, valor, km, descricao) 
                      VALUES (:marca, :modelo, :ano_fab, :ano_mod, :valor, :km, :descricao) RETURNING id";
            
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':marca', $marca);
            $stmt->bindParam(':modelo', $modelo);
            $stmt->bindParam(':ano_fab', $ano_fab);
            $stmt->bindParam(':ano_mod', $ano_mod);
            $stmt->bindParam(':valor', $valor);
            $stmt->bindParam(':km', $km);
            $stmt->bindParam(':descricao', $descricao);
            $stmt->execute();
            
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
            $veiculoId = $resultado['id'];

            // 2. Loop para inserir TODAS as fotos enviadas
            if (!empty($fotos) && is_array($fotos)) {
                $queryFoto = "INSERT INTO veiculos_fotos (veiculo_id, url_foto, destaque) VALUES (:id, :url, :destaque)";
                $stmtFoto = $this->conn->prepare($queryFoto);

                foreach ($fotos as $index => $urlFoto) {
                    // A primeira foto (index 0) será o destaque/capa
                    $destaque = ($index === 0) ? 'true' : 'false';
                    
                    $stmtFoto->bindParam(':id', $veiculoId);
                    $stmtFoto->bindParam(':url', $urlFoto);
                    $stmtFoto->bindParam(':destaque', $destaque);
                    $stmtFoto->execute();
                }
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

    // Busca um único veículo pelo ID
    public function buscarPorId($id) {
        $query = "SELECT v.*, f.url_foto 
                  FROM veiculos v 
                  LEFT JOIN veiculos_fotos f ON v.id = f.veiculo_id 
                  WHERE v.id = :id 
                  ORDER BY f.destaque DESC 
                  LIMIT 1"; // Pega a foto destaque como capa
                  
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Busca TODAS as fotos de um veículo (Para o Carrossel)
    public function buscarFotos($veiculoId) {
        $query = "SELECT url_foto FROM veiculos_fotos WHERE veiculo_id = :id ORDER BY id ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $veiculoId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Atualiza os dados do veículo (Edição)
    // Mantive a lógica original para edição por enquanto (troca a foto principal)
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

            // 2. Se enviou uma nova foto, atualiza a tabela de fotos (substitui capa)
            if ($novaFoto) {
                // Tira o destaque de todas as fotos anteriores desse carro
                $queryReset = "UPDATE veiculos_fotos SET destaque = false WHERE veiculo_id = :id";
                $stmtReset = $this->conn->prepare($queryReset);
                $stmtReset->bindParam(':id', $id);
                $stmtReset->execute();

                // Insere a nova foto como destaque
                $queryInsert = "INSERT INTO veiculos_fotos (veiculo_id, url_foto, destaque) VALUES (:id, :url, true)";
                $stmtInsert = $this->conn->prepare($queryInsert);
                $stmtInsert->bindParam(':id', $id);
                $stmtInsert->bindParam(':url', $novaFoto);
                $stmtInsert->execute();
            }

            $this->conn->commit();
            return true;

        } catch (Exception $e) {
            $this->conn->rollBack();
            return false;
        }
    }

    public function listarComFiltros($filtros) {
        $sql = "SELECT DISTINCT ON (v.id) v.*, f.url_foto 
                FROM veiculos v 
                LEFT JOIN veiculos_fotos f ON v.id = f.veiculo_id 
                WHERE 1=1";
        
        $params = [];

        if (!empty($filtros['busca'])) {
            $sql .= " AND (v.modelo ILIKE :busca OR v.marca ILIKE :busca)";
            $params[':busca'] = '%' . $filtros['busca'] . '%';
        }

        if (!empty($filtros['preco_min'])) {
            $sql .= " AND v.valor >= :pmin";
            $params[':pmin'] = $filtros['preco_min'];
        }
        if (!empty($filtros['preco_max'])) {
            $sql .= " AND v.valor <= :pmax";
            $params[':pmax'] = $filtros['preco_max'];
        }

        if (!empty($filtros['ano_min'])) {
            $sql .= " AND v.ano_modelo >= :amin";
            $params[':amin'] = $filtros['ano_min'];
        }
        if (!empty($filtros['ano_max'])) {
            $sql .= " AND v.ano_modelo <= :amax";
            $params[':amax'] = $filtros['ano_max'];
        }

        if (!empty($filtros['km_min'])) {
            $sql .= " AND v.km >= :kmin";
            $params[':kmin'] = $filtros['km_min'];
        }
        if (!empty($filtros['km_max'])) {
            $sql .= " AND v.km <= :kmax";
            $params[':kmax'] = $filtros['km_max'];
        }

        $sqlCompleto = "SELECT * FROM ($sql ORDER BY v.id, f.destaque DESC) AS subquery";

        if (isset($filtros['ordem'])) {
            if ($filtros['ordem'] == 'menor_preco') {
                $sqlCompleto .= " ORDER BY valor ASC";
            } elseif ($filtros['ordem'] == 'maior_preco') {
                $sqlCompleto .= " ORDER BY valor DESC";
            } elseif ($filtros['ordem'] == 'recente') {
                $sqlCompleto .= " ORDER BY id DESC";
            } else {
                $sqlCompleto .= " ORDER BY id DESC";
            }
        } else {
            $sqlCompleto .= " ORDER BY id DESC";
        }

        $stmt = $this->conn->prepare($sqlCompleto);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>