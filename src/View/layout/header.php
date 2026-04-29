<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AgentFlow</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body class="<?= isset($_COOKIE['ui_mode']) ? htmlspecialchars($_COOKIE['ui_mode']) : 'comfortable' ?>">

<header>
    <div class="header-inner">
        <a href="index.php" class="logo">⚡ AgentFlow</a>
        <nav>
            <a href="index.php?controller=agent&action=index">Agents</a>
            <a href="index.php?controller=run&action=index">Runs</a>
            <a href="index.php?controller=agent&action=new" class="btn-nav">+ Nouvel agent</a>
        </nav>
        <div class="ui-toggle">
            <?php
            $currentMode = isset($_COOKIE['ui_mode']) ? $_COOKIE['ui_mode'] : 'comfortable';
            $nextMode    = $currentMode === 'compact' ? 'comfortable' : 'compact';
            $label       = $currentMode === 'compact'  ? '🔲 Mode confortable' : '▣ Mode compact';
            ?>
            <a href="index.php?action=setMode&mode=<?= $nextMode ?>" class="btn-mode"><?= $label ?></a>
        </div>
    </div>
</header>

<main>
