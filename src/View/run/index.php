<?php require __DIR__ . '/../layout/header.php'; ?>

<div class="container">
    <div class="page-header">
        <h1>Historique des runs</h1>
    </div>

    <?php if (empty($runs)): ?>
        <div class="empty-state">
            <p>Aucun run pour l'instant.</p>
            <a href="index.php?controller=agent&action=index" class="btn">Voir les agents</a>
        </div>
    <?php else: ?>
        <div class="table-wrap">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Agent</th>
                        <th>Modèle</th>
                        <th>Statut</th>
                        <th>Date</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($runs as $run): ?>
                        <tr>
                            <td><?= $run['id'] ?></td>
                            <td><?= htmlspecialchars($run['agent_name']) ?></td>
                            <td><span class="model-badge small"><?= htmlspecialchars($run['model_key']) ?></span></td>
                            <td><span class="status status-<?= $run['status'] ?>"><?= $run['status'] ?></span></td>
                            <td><?= date('d/m/Y H:i', strtotime($run['created_at'])) ?></td>
                            <td><a href="index.php?controller=run&action=show&id=<?= $run['id'] ?>" class="btn btn-sm">Voir</a></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<?php require __DIR__ . '/../layout/footer.php'; ?>
