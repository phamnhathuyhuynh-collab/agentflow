<?php
require_once __DIR__ . '/Database.php';

class AgentModel {
    private PDO $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function getAll(): array {
        $stmt = $this->db->query('SELECT * FROM agents ORDER BY created_at DESC');
        return $stmt->fetchAll();
    }

    public function getById(int $id): ?array {
        $stmt = $this->db->prepare('SELECT * FROM agents WHERE id = ?');
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public function create(string $name, string $description, string $modelKey, string $promptTemplate): int {
        $stmt = $this->db->prepare(
            'INSERT INTO agents (name, description, model_key, prompt_template) VALUES (?, ?, ?, ?)'
        );
        $stmt->execute([$name, $description, $modelKey, $promptTemplate]);
        return (int) $this->db->lastInsertId();
    }
}
