<?php require __DIR__ . '/../layout/header.php'; ?>

<div class="container">
    <div class="page-header">
        <h1>Run #<?= $run['id'] ?></h1>
        <a href="index.php?controller=run&action=index" class="btn btn-secondary">← Retour</a>
    </div>

    <div class="card">
        <div class="card-body">
            <table class="info-table">
                <tr>
                    <th>Agent</th>
                    <td>
                        <a href="index.php?controller=agent&action=show&id=<?= $run['agent_id'] ?>">
                            <?= htmlspecialchars($run['agent_name']) ?>
                        </a>
                    </td>
                </tr>
                <tr>
                    <th>Modèle</th>
                    <td><span class="model-badge"><?= htmlspecialchars($run['model_key']) ?></span></td>
                </tr>
                <tr>
                    <th>Statut</th>
                    <td><span class="status status-<?= $run['status'] ?>"><?= $run['status'] ?></span></td>
                </tr>
                <tr>
                    <th>Créé le</th>
                    <td><?= date('d/m/Y à H:i', strtotime($run['created_at'])) ?></td>
                </tr>
            </table>
        </div>
    </div>

    <div class="card" style="margin-top:1.5rem">
        <div class="card-body">
            <h3>Texte d'entrée</h3>
            <pre><?= htmlspecialchars($run['input_text']) ?></pre>
        </div>
    </div>

    <?php if ($run['rendered_prompt']): ?>
    <div class="card" style="margin-top:1.5rem">
        <div class="card-body">
            <h3>Prompt rendu</h3>
            <pre><?= htmlspecialchars($run['rendered_prompt']) ?></pre>
        </div>
    </div>
    <?php endif; ?>

    <?php if ($run['result_text']): ?>
    <div class="card result-card" style="margin-top:1.5rem">
        <div class="card-body">
            <h3>✅ Résultat</h3>
            <pre><?= htmlspecialchars($run['result_text']) ?></pre>
        </div>
    </div>
    <?php endif; ?>
</div>

<?php require __DIR__ . '/../layout/footer.php'; ?>
