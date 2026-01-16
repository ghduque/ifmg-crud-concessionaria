<?php
require_once __DIR__ . '/../../config/database.php';

class Usuario {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    // Busca usuário pelo email para o Login
    public function buscarPorEmail($email) {
        $query = "SELECT * FROM usuarios WHERE email = :email LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // --- NOVO: Busca pelo ID (Necessário para a edição de perfil) ---
    public function buscarPorId($id) {
        $query = "SELECT * FROM usuarios WHERE id = :id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Cria usuário (Cadastro)
    public function criar($nome, $email, $cpf, $telefone, $senha, $papel = 'usuario') {
        // Gera o hash da senha
        $senhaHash = password_hash($senha, PASSWORD_DEFAULT);
        
        $query = "INSERT INTO usuarios (nome, email, cpf, telefone, senha_hash, papel) 
                  VALUES (:nome, :email, :cpf, :telefone, :senha, :papel)";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':cpf', $cpf);
        $stmt->bindParam(':telefone', $telefone);
        $stmt->bindParam(':senha', $senhaHash);
        $stmt->bindParam(':papel', $papel);
        
        return $stmt->execute();
    }

    // --- NOVO: Atualiza os dados do perfil (Resolve o Erro 500) ---
    public function atualizarPerfil($id, $nome, $email, $telefone, $senhaHash) {
        try {
            $query = "UPDATE usuarios 
                      SET nome = :nome, 
                          email = :email, 
                          telefone = :telefone, 
                          senha_hash = :senha 
                      WHERE id = :id";

            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':nome', $nome);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':telefone', $telefone);
            $stmt->bindParam(':senha', $senhaHash);
            $stmt->bindParam(':id', $id);

            return $stmt->execute();
        } catch (PDOException $e) {
            // Retorna falso se der erro (ex: e-mail duplicado)
            return false;
        }
    }
}
?>