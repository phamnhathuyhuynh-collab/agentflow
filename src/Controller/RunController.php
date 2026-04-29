<?php
require_once __DIR__ . '/../Model/RunModel.php';
require_once __DIR__ . '/../Model/AgentModel.php';

class RunController {
    private RunModel $runModel;
    private AgentModel $agentModel;

    public function __construct() {
        $this->runModel   = new RunModel();
        $this->agentModel = new AgentModel();
    }

    // GET /index.php?controller=run&action=index
    public function index(): void {
        $runs = $this->runModel->getAll();
        require __DIR__ . '/../View/run/index.php';
    }

    // POST /index.php?controller=run&action=create
    public function create(): void {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            return;
        }

        $agentId   = (int)($_POST['agent_id'] ?? 0);
        $inputText = trim($_POST['input_text'] ?? '');

        $errors = [];
        $agent  = $this->agentModel->getById($agentId);

        if (!$agent)          $errors[] = 'Agent introuvable.';
        if ($inputText === '') $errors[] = 'Le texte d\'entrée est obligatoire.';

        if (!empty($errors)) {
            http_response_code(400);
            require __DIR__ . '/../View/errors/400.php';
            return;
        }

        $id = $this->runModel->create($agentId, $inputText, $agent['model_key']);
        header('Location: index.php?controller=run&action=show&id=' . $id);
        exit;
    }

    // GET /index.php?controller=run&action=show&id=X
    public function show(): void {
        $id  = (int)($_GET['id'] ?? 0);
        $run = $this->runModel->getById($id);

        if (!$run) {
            http_response_code(404);
            require __DIR__ . '/../View/errors/404.php';
            return;
        }

        // Simulation : si queued → traiter et passer à done
        if ($run['status'] === 'queued') {
            $this->runModel->processRun($run);
            // Recharger après traitement
            $run = $this->runModel->getById($id);
        }

        require __DIR__ . '/../View/run/show.php';
    }
}
