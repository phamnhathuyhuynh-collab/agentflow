-- AgentFlow - Schema SQL
-- Exécuter : mysql -u root -p agentflow < docs/schema.sql

CREATE DATABASE IF NOT EXISTS agentflow CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE agentflow;

CREATE TABLE IF NOT EXISTS agents (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    model_key VARCHAR(50) NOT NULL,
    prompt_template TEXT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS runs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    agent_id INT NOT NULL,
    input_text TEXT NOT NULL,
    status ENUM('queued', 'running', 'done', 'failed') DEFAULT 'queued',
    model_key VARCHAR(50) NOT NULL,
    rendered_prompt TEXT,
    result_text TEXT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (agent_id) REFERENCES agents(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
