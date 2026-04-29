<?php require __DIR__ . '/../layout/header.php'; ?>
<div class="container">
    <div class="error-page">
        <h1>400</h1>
        <p>Requête invalide. Veuillez vérifier les données soumises.</p>
        <?php if (!empty($errors)): ?>
            <ul class="error-list">
                <?php foreach ($errors as $e): ?>
                    <li><?= htmlspecialchars($e) ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
        <a href="javascript:history.back()" class="btn">← Retour</a>
    </div>
</div>
<?php require __DIR__ . '/../layout/footer.php'; ?>
