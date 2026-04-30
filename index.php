<?php require 'config.php'; ?>

<?php
// Récupérer les filières
$filieres = $pdo->query("SELECT * FROM filieres")->fetchAll();

// Récupérer les étudiants + filière
$etudiants = $pdo->query("
    SELECT e.*, f.nom as filiere
    FROM etudiants e
    JOIN filieres f ON e.filiere_id = f.id
")->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des étudiants</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<div class="container">

    <h2>Ajouter un étudiant</h2>

    <form action="traitement.php" method="POST" id="form">
        <input type="text" name="nom" placeholder="Nom">
        <input type="text" name="prenom" placeholder="Prénom">

        <select name="filiere">
            <option value="">-- Choisir une filière --</option>
            <?php foreach($filieres as $f): ?>
                <option value="<?= $f['id'] ?>">
                    <?= htmlspecialchars($f['nom']) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <button type="submit">Ajouter</button>
    </form>

    <h2>Liste des étudiants</h2>

    <table>
        <tr>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Filière</th>
            <th>Actions</th>
        </tr>

        <?php if(count($etudiants) > 0): ?>
            <?php foreach($etudiants as $e): ?>
            <tr>
                <td><?= htmlspecialchars($e['nom']) ?></td>
                <td><?= htmlspecialchars($e['prenom']) ?></td>
                <td><?= htmlspecialchars($e['filiere']) ?></td>
                <td>
                    <a href="update.php?id=<?= $e['id'] ?>">Modifier</a>
                    <a href="delete.php?id=<?= $e['id'] ?>" 
                       onclick="return confirm('Supprimer cet étudiant ?')">
                       Supprimer
                    </a>
                </td>
            </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="4">Aucun étudiant trouvé</td>
            </tr>
        <?php endif; ?>

    </table>

</div>

<!-- JS ici (important) -->
<script src="assets/js/script.js"></script>

</body>
</html>