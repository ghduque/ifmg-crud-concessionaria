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

    // Método extra: Criar usuário (útil para criar o primeiro admin via código)
    public function criar($nome, $email,$cpf, $telefone, $senha, $papel = 'comum') {
        $senhaHash = password_hash($senha, PASSWORD_DEFAULT);
        
        $query = "INSERT INTO usuarios (nome, email, cpf, telefone, senha_hash, papel) VALUES (:nome, :email, :cpf, :telefone, :senha, :papel)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':cpf', $cpf);
        $stmt->bindParam(':telefone', $telefone);
        $stmt->bindParam(':senha', $senhaHash);
        $stmt->bindParam(':papel', $papel);
        
        return $stmt->execute();
    }
}
?>