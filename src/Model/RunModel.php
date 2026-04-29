<?php
require_once __DIR__ . '/Database.php';

class RunModel {
    private PDO $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function getAll(): array {
        $stmt = $this->db->query(
            'SELECT r.*, a.name AS agent_name FROM runs r
             JOIN agents a ON r.agent_id = a.id
             ORDER BY r.created_at DESC'
        );
        return $stmt->fetchAll();
    }

    public function getById(int $id): ?array {
        $stmt = $this->db->prepare(
            'SELECT r.*, a.name AS agent_name, a.prompt_template FROM runs r
             JOIN agents a ON r.agent_id = a.id
             WHERE r.id = ?'
        );
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public function create(int $agentId, string $inputText, string $modelKey): int {
        $stmt = $this->db->prepare(
            'INSERT INTO runs (agent_id, input_text, model_key, status) VALUES (?, ?, ?, "queued")'
        );
        $stmt->execute([$agentId, $inputText, $modelKey]);
        return (int) $this->db->lastInsertId();
    }

    public function processRun(array $run): void {
        if ($run['status'] !== 'queued') return;

        // Remplacer les variables dans le prompt
        $rendered = str_replace(
            ['<agent_name>', '<input_text>'],
            [$run['agent_name'], $run['input_text']],
            $run['prompt_template']
        );

        // Générer un résultat simulé
        $result = $this->generateSimulatedResult($run);

        $stmt = $this->db->prepare(
            'UPDATE runs SET status="done", rendered_prompt=?, result_text=? WHERE id=?'
        );
        $stmt->execute([$rendered, $result, $run['id']]);
    }

    private function generateSimulatedResult(array $run): string {
        $lines = [
            "**Résultat :**",
            "- Analyse complétée avec succès par l'agent \"{$run['agent_name']}\".",
            "- Modèle utilisé : {$run['model_key']}.",
            "",
            "**Points clés :**",
            "- Le texte soumis a été traité et analysé.",
            "- Les éléments principaux ont été identifiés.",
            "- Une synthèse structurée a été générée.",
            "",
            "**Prochain pas :**",
            "- Vérifier le résultat et ajuster le prompt si nécessaire.",
            "- Relancer un run avec un texte différent pour affiner.",
        ];
        return implode("\n", $lines);
    }
}
