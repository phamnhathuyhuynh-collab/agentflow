<?php require __DIR__ . '/../layout/header.php'; ?>

<div class="container">
    <div class="page-header">
        <h1><?= htmlspecialchars($agent['name']) ?></h1>
        <a href="index.php?controller=agent&action=index" class="btn btn-secondary">← Retour</a>
    </div>

    <div class="card">
        <div class="card-body">
            <table class="info-table">
                <tr>
                    <th>Modèle</th>
                    <td><span class="model-badge"><?= htmlspecialchars($agent['model_key']) ?></span></td>
                </tr>
                <?php if ($agent['description']): ?>
                <tr>
                    <th>Description</th>
                    <td><?= htmlspecialchars($agent['description']) ?></td>
                </tr>
                <?php endif; ?>
                <tr>
                    <th>Créé le</th>
                    <td><?= date('d/m/Y à H:i', strtotime($agent['created_at'])) ?></td>
                </tr>
            </table>

            <div class="prompt-block">
                <h3>Template de prompt</h3>
                <pre><?= htmlspecialchars($agent['prompt_template']) ?></pre>
            </div>
        </div>
    </div>

    <!-- Formulaire pour lancer un run -->
    <div class="card" style="margin-top: 2rem;">
        <div class="card-body">
            <h2>🚀 Lancer un run</h2>
            <form method="POST" action="index.php?controller=run&action=create">
                <input type="hidden" name="agent_id" value="<?= $agent['id'] ?>">
                <div class="form-group">
                    <label for="input_text">Texte d'entrée <span class="required">*</span></label>
                    <textarea id="input_text" name="input_text" rows="5"
                              placeholder="Entrez le texte à traiter par cet agent..." required></textarea>
                </div>
                <div class="form-actions">
                    <button type="submit" class="btn">▶ Lancer</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require __DIR__ . '/../layout/footer.php'; ?>
