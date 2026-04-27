<?php require 'config.php'; ?>

<?php
$filieres = $pdo->query("SELECT * FROM filieres")->fetchAll();

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

<h1>🎓 Gestion des Étudiants</h1>

<h2>Ajouter un étudiant</h2>

<form id="form">
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

    <p id="error"></p>
    <p id="success"></p>
</form>

<h2>Liste des étudiants</h2>

<input type="text" id="search" placeholder="🔍 Rechercher un étudiant...">

<table>
<thead>
<tr>
    <th>Nom</th>
    <th>Prénom</th>
    <th>Filière</th>
    <th>Actions</th>
</tr>
</thead>

<tbody id="tableBody">
<?php foreach($etudiants as $e): ?>
<tr>
    <td><?= htmlspecialchars($e['nom']) ?></td>
    <td><?= htmlspecialchars($e['prenom']) ?></td>
    <td><?= htmlspecialchars($e['filiere']) ?></td>
    <td>
        <a href="update.php?id=<?= $e['id'] ?>" class="btn-update">Modifier</a>
        <a href="delete.php?id=<?= $e['id'] ?>" onclick="return confirm('Supprimer ?')" class="btn-delete">Supprimer</a>
    </td>
</tr>
<?php endforeach; ?>
</tbody>

</table>

</div>

<script src="assets/js/script.js"></script>

</body>
</html>
