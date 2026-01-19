<?php

class Categoria {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function listar() {
        $stmt = $this->pdo->query("SELECT * FROM categorias ORDER BY id DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function criar($nome) {
        $stmt = $this->pdo->prepare("INSERT INTO categorias (nome) VALUES (:nome)");
        return $stmt->execute([':nome' => $nome]);
    }

    public function excluir($id) {
        $stmt = $this->pdo->prepare("DELETE FROM categorias WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }
}