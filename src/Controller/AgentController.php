<?php
require_once __DIR__ . '/../Model/AgentModel.php';

class AgentController {
    private AgentModel $model;
    private array $availableModels;

    public function __construct() {
        $this->model = new AgentModel();
        $this->availableModels = require __DIR__ . '/../Config/models.php';
    }

    // GET /index.php?controller=agent&action=index
    public function index(): void {
        $agents = $this->model->getAll();
        require __DIR__ . '/../View/agent/index.php';
    }

    // GET /index.php?controller=agent&action=new
    public function new(): void {
        $models = $this->availableModels;
        $errors = [];
        require __DIR__ . '/../View/agent/new.php';
    }

    // POST /index.php?controller=agent&action=create
    public function create(): void {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            return;
        }

        $name           = trim($_POST['name'] ?? '');
        $description    = trim($_POST['description'] ?? '');
        $modelKey       = trim($_POST['model_key'] ?? '');
        $promptTemplate = trim($_POST['prompt_template'] ?? '');

        $errors = [];
        if ($name === '')                                    $errors[] = 'Le nom est obligatoire.';
        if ($modelKey === '')                                $errors[] = 'Le modèle est obligatoire.';
        if (!array_key_exists($modelKey, $this->availableModels)) $errors[] = 'Modèle invalide.';
        if ($promptTemplate === '')                          $errors[] = 'Le prompt est obligatoire.';

        if (!empty($errors)) {
            http_response_code(400);
            $models = $this->availableModels;
            require __DIR__ . '/../View/agent/new.php';
            return;
        }

        $id = $this->model->create($name, $description, $modelKey, $promptTemplate);
        header('Location: index.php?controller=agent&action=show&id=' . $id);
        exit;
    }

    // GET /index.php?controller=agent&action=show&id=X
    public function show(): void {
        $id = (int)($_GET['id'] ?? 0);
        $agent = $this->model->getById($id);

        if (!$agent) {
            http_response_code(404);
            require __DIR__ . '/../View/errors/404.php';
            return;
        }

        require __DIR__ . '/../View/agent/show.php';
    }
}
