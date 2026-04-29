<?php
declare(strict_types=1);

// Autoload des classes
spl_autoload_register(function (string $class): void {
    $dirs = [
        __DIR__ . '/../src/Controller/',
        __DIR__ . '/../src/Model/',
    ];
    foreach ($dirs as $dir) {
        $file = $dir . $class . '.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});

// Gestion du cookie ui_mode
if (isset($_GET['action']) && $_GET['action'] === 'setMode') {
    $mode = $_GET['mode'] ?? 'comfortable';
    $mode = in_array($mode, ['compact', 'comfortable']) ? $mode : 'comfortable';
    setcookie('ui_mode', $mode, time() + 7 * 24 * 3600, '/');
    $ref = $_SERVER['HTTP_REFERER'] ?? 'index.php?controller=agent&action=index';
    header('Location: ' . $ref);
    exit;
}

// Routage
$controller = $_GET['controller'] ?? 'agent';
$action     = $_GET['action']     ?? 'index';

// Whitelist des routes autorisées
$routes = [
    'agent' => ['index', 'new', 'create', 'show'],
    'run'   => ['index', 'create', 'show'],
];

if (!isset($routes[$controller]) || !in_array($action, $routes[$controller])) {
    http_response_code(404);
    require __DIR__ . '/../src/View/errors/404.php';
    exit;
}

// Instanciation et appel du controller
$controllerClass = ucfirst($controller) . 'Controller';
$instance = new $controllerClass();
$instance->$action();
