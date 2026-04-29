<?php require __DIR__ . '/../layout/header.php'; ?>

<?php
$defaultPrompt = 'Tu es un agent IA spécialisé dans la tâche suivante : <agent_name>.

Objectif :
- Produire un résultat clair, structuré, et actionnable.

Contraintes :
- Répondre en français.
- Utiliser des listes à puces quand c\'est pertinent.
- Rester concis.

Texte d\'entrée :
<input_text>

Réponse attendue :
- Résultat :
- Points clés :
- Prochain pas :';
?>

<div class="container">
    <div class="page-header">
        <h1>Nouvel agent</h1>
        <a href="index.php?controller=agent&action=index" class="btn btn-secondary">← Retour</a>
    </div>

    <?php if (!empty($errors)): ?>
        <div class="alert alert-error">
            <ul>
                <?php foreach ($errors as $e): ?>
                    <li><?= htmlspecialchars($e) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <div class="card">
        <div class="card-body">
            <form method="POST" action="index.php?controller=agent&action=create">

                <div class="form-group">
                    <label for="name">Nom de l'agent <span class="required">*</span></label>
                    <input type="text" id="name" name="name"
                           value="<?= htmlspecialchars($_POST['name'] ?? '') ?>"
                           placeholder="Ex: Résumeur de texte" required>
                </div>

                <div class="form-group">
                    <label for="description">Description</label>
                    <input type="text" id="description" name="description"
                           value="<?= htmlspecialchars($_POST['description'] ?? '') ?>"
                           placeholder="Optionnel">
                </div>

                <div class="form-group">
                    <label for="model_key">Modèle IA <span class="required">*</span></label>
                    <select id="model_key" name="model_key" required>
                        <option value="">-- Choisir un modèle --</option>
                        <?php foreach ($models as $key => $label): ?>
                            <option value="<?= htmlspecialchars($key) ?>"
                                <?= (($_POST['model_key'] ?? '') === $key) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($label) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="prompt_template">Template de prompt <span class="required">*</span></label>
                    <textarea id="prompt_template" name="prompt_template" rows="12"><?= htmlspecialchars($_POST['prompt_template'] ?? $defaultPrompt) ?></textarea>
                    <small>Utilisez <code>&lt;agent_name&gt;</code> et <code>&lt;input_text&gt;</code> comme variables.</small>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn">Créer l'agent</button>
                    <a href="index.php?controller=agent&action=index" class="btn btn-secondary">Annuler</a>
                </div>

            </form>
        </div>
    </div>
</div>

<?php require __DIR__ . '/../layout/footer.php'; ?>
