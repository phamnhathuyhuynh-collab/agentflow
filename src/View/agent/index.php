<?php require __DIR__ . '/../layout/header.php'; ?>

<div class="container">
    <div class="page-header">
        <h1>Agents IA</h1>
        <a href="index.php?controller=agent&action=new" class="btn">+ Nouvel agent</a>
    </div>

    <?php if (empty($agents)): ?>
        <div class="empty-state">
            <p>Aucun agent pour l'instant.</p>
            <a href="index.php?controller=agent&action=new" class="btn">Créer le premier agent</a>
        </div>
    <?php else: ?>
        <div class="card-grid">
            <?php foreach ($agents as $agent): ?>
                <div class="card">
                    <div class="card-body">
                        <h2 class="card-title">
                            <a href="index.php?controller=agent&action=show&id=<?= $agent['id'] ?>">
                                <?= htmlspecialchars($agent['name']) ?>
                            </a>
                        </h2>
                        <p class="model-badge"><?= htmlspecialchars($agent['model_key']) ?></p>
                        <?php if ($agent['description']): ?>
                            <p class="card-desc"><?= htmlspecialchars($agent['description']) ?></p>
                        <?php endif; ?>
                        <p class="card-date">Créé le <?= date('d/m/Y H:i', strtotime($agent['created_at'])) ?></p>
                    </div>
                    <div class="card-footer">
                        <a href="index.php?controller=agent&action=show&id=<?= $agent['id'] ?>" class="btn btn-sm">Voir</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<?php require __DIR__ . '/../layout/footer.php'; ?>
